<?php

namespace Tests\Feature;

use Tests\TestCase;

class WeatherCommandTest extends TestCase
{
    /** @test */
    public function it_can_send_weather_to_telegram()
    {
        $this->artisan('weather open-weather-map Tashkent --telegram=1157219338')
            ->expectsOutput('Telegram message sent successfully');
    }

    /** @test */
    public function it_should_fail_if_telegram_id_is_not_integer()
    {
        $this->artisan('weather open-weather-map Tashkent --telegram=abc')
            ->expectsOutput('Telegram id must be an integer')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_checks_valid_weather_provider()
    {
        $this->artisan('weather open-weather-map Tashkent --telegram=abc')
            ->assertSuccessful();
    }

    /** @test */
    public function it_checks_invalid_weather_provider()
    {
        $this->artisan('weather invalid-provider Tashkent')
            ->expectsOutput('Provider not found');
    }
}
