<?php

namespace App\Repositories;

use App\Repositories\Interfaces\WeatherProviderInterface;
use Exception;
use Illuminate\Support\Facades\Http;

class OpenWeatherMapRepository implements WeatherProviderInterface
{

    public function send(string $action = "", array $params = [])
    {
        $url = 'https://api.openweathermap.org/data/2.5/weather/' . $action;
        $http = Http::acceptJson()->get($url, [
            ...$params,
            "appid" => config("system.open-weather-map.key")
        ]);
        if ($http->successful()) {
            return $http->json();
        }
        throw new Exception($http->body());
    }

    /**
     * @throws Exception
     */
    public function weatherByCity(string $city): string
    {
        $data = $this->send(params: [
            "q" => $city
        ]);
        return $this->arrayToString($data);
    }

    public function arrayToString($data): string
    {
        // Ma'lumotlarni chiqarish
        $text = "Hozirgi harorat: " . $data["main"]["temp"] . " Kelvin\n";
        $text .= "Hissiyot: " . $data["main"]["feels_like"] . " Kelvin\n";
        $text .= "Minimal harorat: " . $data["main"]["temp_min"] . " Kelvin\n";
        $text .= "Maksimal harorat: " . $data["main"]["temp_max"] . " Kelvin\n";
        $text .= "Bosim: " . $data["main"]["pressure"] . " hPa\n";
        $text .= "Namlik: " . $data["main"]["humidity"] . "%\n";
        $text .= "Ko'rinish: " . $data["visibility"] . " metr\n";
        $text .= "Shamol tezligi: " . $data["wind"]["speed"] . " m/s\n";
        $text .= "Shamol yo'nalishi: " . $data["wind"]["deg"] . " gradus\n";
        $text .= "Bulutlar: " . $data["clouds"]["all"] . "%\n";
        $text .= "Quyosh botishi: " . date("Y-m-d H:i:s", $data["sys"]["sunrise"]) . "\n";
        $text .= "Quyosh chiqishi: " . date("Y-m-d H:i:s", $data["sys"]["sunset"]) . "\n";
        $text .= "Havo holati: " . $data["weather"][0]["description"] . "\n";
        return $text;
    }
}
