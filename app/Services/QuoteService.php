<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class QuoteService
{
    protected $client;
    protected $apiKey;
    protected $apiHost;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = '4123b0a04dmsh6904a8dcecad229p17ba38jsndcdfb75e3498';
        $this->apiHost = 'get-quotes-api.p.rapidapi.com';
    }

    public function getRandomQuote(Request $request)
    {
        try {
            $response = $this->client->request('GET', "https://get-quotes-api.p.rapidapi.com/random", [
                'headers' => [
                    'x-rapidapi-host' => $this->apiHost,
                    'x-rapidapi-key' => $this->apiKey,
                ],
                'verify' => false
            ]);

            $data = json_decode($response->getBody(), true);
            if (!empty($data) && isset($data['quote'])) {
                return ['quote' => $data['quote']];
            } else {
                throw new \Exception('Quote not found');
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $message = json_decode($response->getBody()->getContents(), true)['message'];

            throw new \Exception("Error fetching quote data: $message", $statusCode);
        } catch (\Exception $e) {
            throw new \Exception('Error fetching quote data: ' . $e->getMessage(), 500);
        }
    }
}
