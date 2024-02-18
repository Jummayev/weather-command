<?php

namespace App\Repositories\Interfaces;

use Exception;

interface WeatherProviderInterface
{
    /**
     * @throws Exception
     */
    public function send(string $action = "", array $params = []);

    /**
     * @throws Exception
     */
    public function weatherByCity(string $city): string;

    public function arrayToString($data): string;

}
