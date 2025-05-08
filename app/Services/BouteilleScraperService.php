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
     * Scraper toutes les pages de vin de la SAQ
     */
    public function scraperAllPages(): array
    {
        set_time_limit(0); 
        $page = 1;
        $itemsPerPage = 24; // nombre des elements sur une page 
        $results = [];

        do {
            $url = "https://www.saq.com/fr/produits/vin?p={$page}&product_list_limit={$itemsPerPage}&product_list_order=name_asc";
            $productsOnPage = $this->getDetails($url);

            foreach ($productsOnPage as $product) {
                if (!Bottle::where('code_saq', $product['code_saq'])->exists()) {
                    $detailsSup = $this->getDetailsSu($product['url']);
                    $data = array_merge($product, $detailsSup);
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
    private function getDetails(string $url): array
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

            $priceText = $node->filter('.price')->count() ? $node->filter('.price')->text() : null;
            $price = $this->convertPrice($priceText);
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
    private function getDetailsSup(string $url): array
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
     * @param string|null $priceText
     * @return float|null
     */
    private function convertPrice(?string $priceText): ?float
    {
        if (!$priceText) return null;
        $priceText = str_replace(['$', ' ', ' '], '', $priceText);
        $priceText = str_replace(',', '.', $priceText);
        return is_numeric($priceText) ? round((float) $priceText, 2) : null;
    }
    
    //Pour les tests
    public function scraper(): array
    {
        set_time_limit(0);

        $page = 1;
        $itemsPerPage = 24;
        $results = [];


        $url = "https://www.saq.com/fr/produits/vin?p={$page}&product_list_limit={$itemsPerPage}&product_list_order=name_asc";
        $products = $this->getDetails($url);

        foreach ($products as $product) {
            if (!Bottle::where('code_saq', $product['code_saq'])->exists()) {
                $detailsSup = $this->getDetailsSup($product['url']);
                $data = array_merge($product, $detailsSup);
                Bottle::create($data);
                $results[] = $data;
            }
        }

        return $results;
    }
}
