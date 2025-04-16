<?php

namespace App\Services;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use App\Models\Bottle; // Utilisation du modèle Bottle
use Illuminate\Support\Facades\Storage;

class BouteilleScraperService
{
    protected Client $client;

    // Initialisation du client HTTP avec un time-out de 60 secondes
    public function __construct()
    {
        $this->client = new Client(HttpClient::create(['timeout' => 60]));
    }

    // Scrape les bouteilles selon l'URL fournie
    public function scraper(string $url): array
    {
        $crawler = $this->client->request('GET', $url);

        $bottles = [];

        $crawler->filter('.product-item')->each(function ($node) use (&$bottles) {
            $image = $node->filter('.product-image-photo')->count() ? $node->filter('.product-image-photo')->attr('src') : null;
            $name = $node->filter('.product-item-link')->count() ? trim($node->filter('.product-item-link')->text()) : null;
            $urlProduit = $node->filter('.product-item-link')->count() ? $node->filter('.product-item-link')->attr('href') : null;
            $price = $node->filter('.price')->count() ? trim($node->filter('.price')->text()) : null;

            $type = '';
            $format = '';
            $country = '';
            $code_saq = '';

            $node->filter('strong.product.product-item-identity-format')->each(function ($descNode) use (&$type, &$format, &$country) {
                $desc = explode('|', trim($descNode->text()));
                if (count($desc) === 3) {
                    $type = trim($desc[0]);
                    $format = trim($desc[1]);
                    $country = trim($desc[2]);
                }
            });

            // Extraire le code SAQ (suite de chiffres)
            $node->filter('.saq-code')->each(function ($codeNode) use (&$code_saq) {
                if (preg_match("/\d+/", $codeNode->text(), $matches)) {
                    $code_saq = $matches[0];
                }
            });

            // Vérifier et enregistrer la bouteille seulement si le code SAQ est unique
            if ($code_saq && !Bottle::where('code_saq', $code_saq)->exists()) {
                $bottleData = [
                    'name' => $name,
                    'image' => $image,
                    'price' => $price,
                    'type' => $type,
                    'format' => $format,
                    'country' => $country,
                    'code_saq' => $code_saq,
                    'url' => $urlProduit,
                ];

                Bottle::create($bottleData);       // Insertion en base
                $bottles[] = $bottleData;          // Ajout au retour
            }
        });

        // Sauvegarde dans un fichier JSON pour test/local backup
        Storage::disk('local')->put('saq_bouteilles.json', json_encode($bottles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $bottles;
    }
}
