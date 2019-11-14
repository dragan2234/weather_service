<?php

namespace Drupal\weather_service;

/**
 * WeatherService
 */
class WeatherService {

  public function getForecast($cityName) {

    $client = \Drupal::httpClient();
    $apiEndPoint = 'http://api.openweathermap.org/data/2.5/weather?q=' . $cityName . '&appid=73cd23b00dddfb2aad2ad3ddb2c12e36';

    $response = $client->request('GET', $apiEndPoint);
    $object = json_decode($response->getBody()->getContents());

    return $object->weather[0]->main;
  }
}
