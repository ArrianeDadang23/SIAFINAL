<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city = $request->input('city');
        $apiKey = '4123b0a04dmsh6904a8dcecad229p17ba38jsndcdfb75e3498';
        $apiHost = 'ai-weather-by-meteosource.p.rapidapi.com';

        $client = new Client();

        try {
            $response = $client->request('GET', "https://ai-weather-by-meteosource.p.rapidapi.com/current?lat=37.81021&lon=-122.42282&timezone=auto&language=en&units=auto", [
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

            return response()->json(['error' => "Error fetching weather data: $message"], $statusCode);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching weather data: ' . $e->getMessage()], 500);
        }
    }
}
