<?php

namespace App\Repositories;

use App\Repositories\Interfaces\WeatherProviderInterface;
use Exception;
use Illuminate\Support\Facades\Http;

class OpenWeatherRepository implements WeatherProviderInterface
{
    /**
     * @throws Exception
     */
    public function send(string $action = "", array $params = [])
    {
        $url = 'https://dataservice.accuweather.com/' . $action;
        $http = Http::acceptJson()->get($url, [
            ...$params,
            "apikey" => config('system.open-weather.key')
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
        $location = $this->send("locations/v1/cities/search", [
            "q" => $city,
            'language' => 'en-us', // Ma'lumotlarni ingliz tilida qaytarish
            'details' => false, // Qo'shimcha tafsilotlarni qaytarilmaydi
            'metric' => true // Ma'lumotlarni metrik o'lchamda qaytarish
        ]);
        $locationKey = $location[0]['Key'] ?? null;

        if ($locationKey) {
            $data = $this->send("currentconditions/v1/" . $locationKey, [
                'language' => 'en-us',
                'details' => true
            ]);
            if (!empty($data)) {
                return $this->arrayToString($data[0]);
            }
        }
        return "Ob-havo ma'lumotlari topilmadi\n";
    }

    public function arrayToString($data): string
    {
        $text = "Hozirgi harorat: " . $data['Temperature']['Metric']['Value'] . " " . $data['Temperature']['Metric']['Unit'] . "\n";
        $text .= "Hissiyot: " . $data['Temperature']['Imperial']['Value'] . " " . $data['Temperature']['Imperial']['Unit'] . "\n";
        $text .= "Ob-havo holati: " . $data['WeatherText'] . "\n";
        $text .= "Minimal harorat: -" . "\n";
        $text .= "Maksimal harorat: -" . "\n";
        $text .= "Bosim: -" . "\n";
        $text .= "Namlik: -" . "\n";
        $text .= "Ko'rinish: -" . "\n";
        $text .= "Shamol tezligi: -" . "\n";
        $text .= "Shamol yo'nalishi: -" . "\n";
        $text .= "Bulutlar: -" . "\n";
        $text .= "Quyosh botishi: -" . "\n";
        $text .= "Quyosh chiqishi: -" . "\n";
        $text .= "Havo holati: -" . "\n";
        return $text;
    }

}
