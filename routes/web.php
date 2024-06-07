<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/dashboard', function () {
    return file_get_contents(__DIR__ . '/../public/index.html');
});
$router->get('/news', 'NewsController@getLatestNews');
$router->get('/quote', 'QuoteController@getRandomQuote');
$router->get('/search', 'SearchController@getSearchResults');
$router->get('/weather', 'WeatherController@getWeather');
$router->get('/all-data', 'GatewayController@getAllData');
