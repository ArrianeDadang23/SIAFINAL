<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class NewsService
{
    protected $client;
    protected $apiKey;
    protected $apiHost;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = '4123b0a04dmsh6904a8dcecad229p17ba38jsndcdfb75e3498'; 
        $this->apiHost = 'news-api14.p.rapidapi.com'; 
    }

    public function getLatestNews(Request $request)
    {
        try {
            $category = $request->input('category', 'sports'); // Default category to 'sports' if not provided
            
            $response = $this->client->request('GET', 'https://news-api14.p.rapidapi.com/top-headlines', [
                'headers' => [
                    'x-rapidapi-host' => $this->apiHost,
                    'x-rapidapi-key' => $this->apiKey,
                ],
                'query' => [
                    'category' => $category,
                    'country' => 'us',
                    'language' => 'en',
                    'pageSize' => 10,
                    'sortBy' => 'title' // Adjust 'sortBy' parameter to a valid value if required
                ],
                'verify' => false
            ]);

            return json_decode($response->getBody(), true);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $message = json_decode($response->getBody()->getContents(), true)['message'];

            throw new \Exception("Error fetching news data: $message", $statusCode);
        } catch (\Exception $e) {
            throw new \Exception('Error fetching news data: ' . $e->getMessage(), 500);
        }
    }
}
