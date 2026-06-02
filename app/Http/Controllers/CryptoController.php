<?php

namespace App\Http\Controllers;

use App\Models\Cryptocurrency;
use App\Models\PriceHistory;
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

    /**
     * Synchronizes cryptocurrency data with local database.
     */
    public function sync()
    {
        $response = $this->coinMarketCapService
            ->getLatestListings();

        foreach ($response['data'] as $crypto) {

            $currency = Cryptocurrency::updateOrCreate(
                [
                    'symbol' => $crypto['symbol']
                ],
                [
                    'name' => $crypto['name'],
                    'cmc_id' => $crypto['id']
                ]
            );

            PriceHistory::create([
                'cryptocurrency_id' => $currency->id,
                'price' => $crypto['quote']['USD']['price'],
                'percent_change_24h' =>
                    $crypto['quote']['USD']['percent_change_24h'],
                'volume_24h' =>
                    $crypto['quote']['USD']['volume_24h'],
                'recorded_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cryptocurrency data synchronized'
        ]);
    }
}
