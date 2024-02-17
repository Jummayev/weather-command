<?php

namespace App\Repositories\Interfaces;

interface WeatherProviderInterface
{
    public function send(array $params = []);

    public function weatherByCity(string $city);

}
