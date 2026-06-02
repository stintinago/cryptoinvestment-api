<?php
/**
 * Service in charge of consuming the CoinMarketCap API.
 * Centralizes the integration to avoid duplicating logic
 * in controllers and facilitates maintenance.
 */
namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoinMarketCapService
{
    /**
     * * Obtains the latest cryptocurrency listings from CoinMarketCap.
     */
    public function getLatestListings()
    {
        $response = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => env('CMC_API_KEY'),
            'Accept' => 'application/json'
        ])->get(
            'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest',
            [
                'limit' => 20,
                'convert' => 'USD'
            ]
        );

        return $response->json();
    }
}