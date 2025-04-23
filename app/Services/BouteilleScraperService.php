<?php

namespace App\Services;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use App\Models\Bottle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BouteilleScraperService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client(HttpClient::create(['timeout' => 60]));
    }

     /**
      * Recupere uniquement le code SAQ et le url de la carte detaillée
      */
    public function getListeProduits(string $url): array
    {
        $crawler = $this->client->request('GET', $url);
        $produits = [];

        $crawler->filter('.product-item')->each(function ($node) use (&$produits) {
            $code_saq = '';
            $urlProduit = $node->filter('.product-item-link')->count() ? $node->filter('.product-item-link')->attr('href') : null;

            $node->filter('.saq-code')->each(function ($codeNode) use (&$code_saq) {
                if (preg_match("/\d+/", $codeNode->text(), $matches)) {
                    $code_saq = $matches[0];
                }
            });

            if ($code_saq && $urlProduit) {
                $produits[] = [
                    'code_saq' => $code_saq,
                    'url' => $urlProduit,
                ];
            }
        });

        return $produits;
    }

    /**
     *  Récupère les détails d’une bouteille à partir de son URL
     */
    public function getDetailsProduit(string $url, string $code_saq): ?array
    {
        $crawler = $this->client->request('GET', $url);

        if (Bottle::where('code_saq', $code_saq)->exists()) {
            return null;
        }

        $name = $crawler->filter('h1.page-title')->count() ? trim($crawler->filter('h1.page-title')->text()) : null;
        $price = $crawler->filter('.price')->count() ? $this->convertirPrix($crawler->filter('.price')->text()) : null;
        $image = $crawler->filter('img[itemprop="image"]')->count() ? $crawler->filter('img[itemprop="image"]')->attr('src') : null;

        $details = [
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'code_saq' => $code_saq,
            'url' => $url,
            'country' => null,
            'type' => null,
            'format' => null,
            'alcohol' => null,
            'region' => null,
            'appellation' => null,
            'grape_variety' => null,
        ];

        // Parcourir les éléments de la liste et en extrait les attributs 
        $crawler->filter('.list-attributs li')->each(function ($li) use (&$details) 
        {
            $label = strtolower(trim($li->filter('span')->text()));
            $value = trim($li->filter('strong')->text());

            if (str_contains($label, 'pays')) {
                $details['country'] = $value;
            } elseif (str_contains($label, 'région')) {
                $details['region'] = $value;
            } elseif (str_contains($label, 'désignation réglementée') || str_contains($label, 'appellation')) {
                $details['appellation'] = $value;
            } elseif (str_contains($label, 'cépage')) {
                $details['grape_variety'] = $value;
             } elseif (str_contains($label, 'degré d\'alcool') || str_contains($label, 'alcool')) {
                $details['alcohol'] = str_replace(',', '.', str_replace('%', '', $value)); 
            } elseif (str_contains($label, 'format')) {
                $details['format'] = $value;
            } elseif (str_contains($label, 'couleur') ) {
                // Déterminer le type à partir de la couleur
                $couleur = strtolower($value);
                if ($couleur === 'rouge') {
                    $details['type'] = 'Vin rouge';
                } elseif ($couleur === 'blanc') {
                    $details['type'] = 'Vin blanc';
                } elseif ($couleur === 'rosé') {
                    $details['type'] = 'Vin rosé';
                } else {
                    $details['type'] = 'Vin';
                }
            }
        });

        Bottle::create($details);

        return $details;
    }

   /**
    * Fonction de conversion du prix en float
    */
    private function convertirPrix(string $prixTexte): ?float
    {
        $prixTexte = str_replace(['$', ' ', ' '], '', $prixTexte);
        $prixTexte = str_replace(',', '.', $prixTexte);
        return is_numeric($prixTexte) ? round((float) $prixTexte, 2) : null;
    }

    /**
     *  Fonction qui effectue  les deux étapes de recuperation des attributs   
     * et sauvegarde dans la  BD et JSON 
     */
    public function scraper(string $urlListe): array
    {
        $liste = $this->getListeProduits($urlListe);
        $resultats = [];

        foreach ($liste as $produit) {
            $details = $this->getDetailsProduit($produit['url'], $produit['code_saq']);
            if ($details) {
                $resultats[] = $details;
            }
        }

        try {
            Storage::disk('local')->put(
                'saq_bouteilles.json',
                json_encode($resultats, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        } catch (\Exception $e) {
            Log::warning('Erreur lors de la sauvegarde JSON SAQ', ['error' => $e->getMessage()]);
        }

        return $resultats;
    }
}