<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather
        {provider : weather provider}
        {city : city name}
        {--telegram= : send weather to telegram}';

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
    public function handle(WeatherService $weatherService): void
    {
        $provider = $this->argument('provider');
        $city = $this->argument('city');
        $telegram = $this->option('telegram');
        if (!empty($telegram)) {
            if (!filter_var($telegram, FILTER_VALIDATE_INT)) {
                $this->error('Telegram id must be an integer');
                return;
            }
        }

        try {
            $weather = $weatherService->getWeatherByCity($provider, $city);
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
            return;
        }
        if ($telegram) {
            $this->sendTelegram($weather, $telegram);
        } else {
            $this->info($weather);
        }
    }

    public function sendTelegram($message, $chatId): void
    {
        $response = Http::post('https://api.telegram.org/bot' . config("system.telegram.token") . '/sendMessage', [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
        if ($response->successful()) {
            $this->info('Telegram message sent successfully');
        } else {
            $this->error('Telegram message not sent');
        }
    }
}
