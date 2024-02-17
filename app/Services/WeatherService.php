<?php

namespace App\Services;

use App\Repositories\OpenWeatherMapRepository;
use App\Repositories\OpenWeatherRepository;
use Exception;

class WeatherService
{
    /**
     * @throws Exception
     */
    public function getProvider(string $name): OpenWeatherRepository|OpenWeatherMapRepository
    {
        return match ($name) {
            'open-weather' => new OpenWeatherRepository(),
            'open-weather-map' => new OpenWeatherMapRepository(),
            default => throw new Exception('Provider not found'),
        };
    }

    /**
     * @throws Exception
     */
    public function getWeatherByCity(string $provider, string $city): string
    {
        return $this->getProvider($provider)->weatherByCity($city);
    }

}
