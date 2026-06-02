<?php

namespace App\Http\Controllers;

use App\Services\CoinMarketCapService;

class CryptoController extends Controller
{
    /**
     * CoinMarketCap service instance.
     */
    public function __construct(
        private CoinMarketCapService $coinMarketCapService
    ) {}

    /**
     * Displays the main dashboard.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Returns cryptocurrency data as JSON.
     */
    public function getCryptocurrencies()
    {
        return response()->json(
            $this->coinMarketCapService->getLatestListings()
        );
    }
}
