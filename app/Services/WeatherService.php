<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class WeatherService
{
    protected $client;
    protected $apiKey;
    protected $apiHost;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = '4123b0a04dmsh6904a8dcecad229p17ba38jsndcdfb75e3498'; 
        $this->apiHost = 'ai-weather-by-meteosource.p.rapidapi.com'; 
    }

    public function getWeather(Request $request)
    {
        try {
            $lat = $request->input('lat', '37.81021');
            $lon = $request->input('lon', '-122.42282');
            $timezone = $request->input('timezone', 'auto');
            $language = $request->input('language', 'en');
            $units = $request->input('units', 'auto');

            $response = $this->client->request('GET', 'https://ai-weather-by-meteosource.p.rapidapi.com/current', [
                'headers' => [
                    'x-rapidapi-host' => $this->apiHost,
                    'x-rapidapi-key' => $this->apiKey,
                ],
                'query' => [
                    'lat' => $lat,
                    'lon' => $lon,
                    'timezone' => $timezone,
                    'language' => $language,
                    'units' => $units,
                ],
                'verify' => false
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['current']) && isset($data['timezone']) && isset($data['units'])) {
                return [
                    'temperature' => $data['current']['temperature']['value'],
                    'humidity' => $data['current']['humidity']['value'],
                    'windSpeed' => $data['current']['wind']['speed'],
                    'condition' => $data['current']['summary']['condition'],
                    'timezone' => $data['timezone'],
                    'units' => $data['units'],
                ];
            } else {
                throw new \Exception('Required weather data not found');
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $message = json_decode($response->getBody()->getContents(), true)['message'];

            throw new \Exception("Error fetching weather data: $message", $statusCode);
        } catch (\Exception $e) {
            throw new \Exception('Error fetching weather data: ' . $e->getMessage(), 500);
        }
    }
}
