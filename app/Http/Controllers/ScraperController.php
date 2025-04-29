<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BouteilleScraperService;

class ScraperController extends Controller
{
    protected BouteilleScraperService $scraper;

    /**
     * Constructeur du scraper 
     */
    public function __construct(BouteilleScraperService $scraper)
    {
        $this->scraper = $scraper;
    }

    /**
     * Scraper toutes les bouteilles de vin de la SAQ.
     */
    public function index()
    {
        // URL de base pour toutes les bouteilles de vin
        $urlBase = 'https://www.saq.com/fr/produits/vin';
        // Appelle scraperAllPages avec un max de 200 pages
        $bouteilles = $this->scraper->scraperAllPages($urlBase, 200);

        return response()->json([
            'message' => 'Scraping terminé',
            'nombre_bouteilles' => count($bouteilles),
            'bouteilles' => $bouteilles
        ]);
    }

    /**
     * Teste une seule page.
     */
    public function test()
    {
        // URL d'une seule page
        $url = 'https://www.saq.com/fr/produits/vin';
        
        $bouteilles = $this->scraper->scraper($url);

        return response()->json([
            'message' => 'Test d\'une seule page terminé',
            'nombre_bouteilles' => count($bouteilles),
            'bouteilles' => $bouteilles
        ]);
    }
}