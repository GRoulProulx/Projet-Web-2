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
     * Scraper toutes les pages de vin
     */
    public function scraperAllPages(): array
    {
        set_time_limit(0); 
        $page = 1;
        $numberOfPage = 24;
        $results = [];

        do {
            $url = "https://www.saq.com/fr/produits/vin?p={$page}&product_list_limit={$numberOfPage}&product_list_order=name_asc";
            $productsOnPage = $this->extraireProduits($url);

            foreach ($productsOnPage as $produit) {
                if (!Bottle::where('code_saq', $produit['code_saq'])->exists()) {
                    $detailsSup = $this->extraireDetailsSupplementaires($produit['url']);
                    $data = array_merge($produit, $detailsSup);
                    Bottle::create($data);
                    $results[] = $data;
                }
            }

            $page++;
            sleep(1); // Petite pause pour ne pas saturer la SAQ

        } while (count($productsOnPage) > 0);

        try {
            Storage::disk('local')->put(
                'saq_bouteilles.json',
                json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        } catch (\Exception $e) {
            Log::warning('Erreur sauvegarde JSON', ['error' => $e->getMessage()]);
        }

        return $results;
    }

    /**
     * Récupérer la liste de produits sur une page et en extraire quelques attributs 
     */
    private function extraireProduits(string $url): array
    {
        $crawler = $this->client->request('GET', $url);
        $products = [];

        $crawler->filter('.product-item')->each(function ($node) use (&$products) {
            $urlProduct = $node->filter('.product-item-link')->count() ? $node->filter('.product-item-link')->attr('href') : null;
            $code_saq = '';

            $node->filter('.saq-code')->each(function ($codeNode) use (&$code_saq) {
                if (preg_match("/\d+/", $codeNode->text(), $matches)) {
                    $code_saq = $matches[0];
                }
            });

            $prixTexte = $node->filter('.price')->count() ? $node->filter('.price')->text() : null;
            $price = $this->convertirPrix($prixTexte);
            $image = $node->filter('.product-image-photo')->count() ? $node->filter('.product-image-photo')->attr('src') : null;
            $name = $node->filter('.product-item-link')->count() ? trim($node->filter('.product-item-link')->text()) : null;

            if ($code_saq && $urlProduct) {
                $products[] = [
                    'code_saq' => $code_saq,
                    'url' => $urlProduct,
                    'price' => $price,
                    'image' => $image,
                    'name' => $name,
                ];
            }
        });

        return $products;
    }

    /**
     * Récupérer les détails supplémentaires sur la fiche produit
     */
    private function extraireDetailsSupplementaires(string $url): array
    {
        $crawler = $this->client->request('GET', $url);

        $details = [
            'country' => null,
            'region' => null,
            'appellation' => null,
            'alcohol' => null,
            'grape_variety' => null,
            'format' => null,
            'type' => null,
        ];

        $crawler->filter('.list-attributs li')->each(function ($li) use (&$details) {
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
            } elseif (str_contains($label, 'couleur')) {
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

        return $details;
    }

    /**
     * Convertir prix texte en float
     * @param string|null $prixTexte
     * @return float|null
     */
    private function convertirPrix(?string $prixTexte): ?float
    {
        if (!$prixTexte) return null;
        $prixTexte = str_replace(['$', ' ', ' '], '', $prixTexte);
        $prixTexte = str_replace(',', '.', $prixTexte);
        return is_numeric($prixTexte) ? round((float) $prixTexte, 2) : null;
    }
}
