<?php

namespace App\Repositories;

use App\Repositories\Interfaces\WeatherProviderInterface;
use Illuminate\Support\Facades\Http;

class OpenWeatherMapRepository implements WeatherProviderInterface
{

    public function send(array $params = [])
    {
        $url = 'https://api.openweathermap.org/data/2.5/weather';
        $http = Http::acceptJson()->get($url, [
            ...$params,
            "appid" => '667227644dfa61d3df315748ffa89fde'
        ]);
        if ($http->failed()) {
            throw new \Exception($http->body());
        }
        return $http->json();
    }

    /**
     * @throws \Exception
     */
    public function weatherByCity(string $city)
    {
        $data = $this->send([
            "q" => $city
        ]);
        return $this->arrayToString($data);
    }

    public function arrayToString($data): string
    {
        $text = '';
        $text .= "Toshkent";

        return $text;

    }
}
