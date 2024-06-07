<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class QuoteController extends Controller
{
    public function getRandomQuote(Request $request)
    {
        $apiKey = '4123b0a04dmsh6904a8dcecad229p17ba38jsndcdfb75e3498'; 
        $apiHost = 'get-quotes-api.p.rapidapi.com'; 

        $client = new Client();

        try {
            $response = $client->request('GET', 'https://get-quotes-api.p.rapidapi.com/random', [
                'headers' => [
                    'x-rapidapi-host' => $apiHost,
                    'x-rapidapi-key' => $apiKey,
                ],
                'verify' => false 
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $message = json_decode($response->getBody()->getContents(), true)['message'];

            return response()->json(['error' => "Error fetching quote: $message"], $statusCode);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching quote: ' . $e->getMessage()], 500);
        }
    }
}
