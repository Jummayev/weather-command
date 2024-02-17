<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
use Illuminate\Console\Command;

class WeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather {provider} {--p|provider} {city} {--c|city}  {--ch|channel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weather Command';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(WeatherService $weatherService)
    {
        $provider = $this->argument('provider');
        $city = $this->argument('city');
        $channel = $this->option('channel');

        if ($provider && $city) {
            $weather = $weatherService->getWeatherByCity($provider, $city);
            dd($weather);
            $this->info($weather);
        }

    }
}
