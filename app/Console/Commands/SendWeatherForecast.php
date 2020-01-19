<?php

namespace App\Console\Commands;

use App\Jobs\GetWeather;
use App\Mail\WeatherForecast;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendWeatherForecast extends Command
{
    use Dispatchable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myweather:mailforecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly forecast';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::mailable()->get();

        $users->map(function($user) {
            $location = $user->preferredLocation->location;

            $weather = Cache::store('redis')->get($location->id) ??
                dispatch_now((new GetWeather($location)));

            Mail::to($user)->send(new WeatherForecast($user, $weather, $location));
        });
    }
}
