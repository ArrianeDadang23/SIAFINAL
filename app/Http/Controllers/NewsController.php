<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class NewsController extends Controller
{
    public function getLatestNews(Request $request)
    {
        $apiKey = '4123b0a04dmsh6904a8dcecad229p17ba38jsndcdfb75e3498'; 
        $apiHost = 'news-api14.p.rapidapi.com'; 

        $client = new Client();

        try {
            $response = $client->request('GET', 'https://news-api14.p.rapidapi.com/top-headlines?country=us&language=en&pageSize=10&category=sports&sortBy=titles', [
                'headers' => [
                    'x-rapidapi-host' => $apiHost,
                    'x-rapidapi-key' => $apiKey,
                ],
                'query' => [
        
                ],
                'verify' => false 
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $message = json_decode($response->getBody()->getContents(), true)['message'];

            return response()->json(['error' => "Error fetching news data: $message"], $statusCode);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching news data: ' . $e->getMessage()], 500);
        }
    }
}
