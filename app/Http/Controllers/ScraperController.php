<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\BouteilleScraperService;

class ScraperController extends Controller
{
    // Déclaration variable de scraping
    protected BouteilleScraperService $scraper;

     /**
     * Constructeur du service
     */

    public function __construct(BouteilleScraperService $scraper)
    {
        $this->scraper = $scraper;
    }

     /**
     * Scraper une page de la SAQ .
     * Appelle le service et retourne les bouteilles scrapées au format JSON.
     */

    public function index()
    {
        $url = 'https://www.saq.com/fr/produits/vin/vin-rouge?p=".$page."&product_list_limit=".$nombre."&product_list_order=name_asc'; 

        $bouteilles = $this->scraper->scraper($url);

        return response()->json($bouteilles);
    }
    

    /**
     * Méthodes de test 
     */
    public function test(BouteilleScraperService $scraper)
    {
        $url = 'https://www.saq.com/fr/produits/vin/?p=".$page."&product_list_limit=".$nombre."&product_list_order=name_asc';
        $resultats = $scraper->scraper($url);
        return response()->json($resultats);
    }

}
