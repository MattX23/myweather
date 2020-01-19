<?php

namespace App\Mail;

use App\Location;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeatherForecast extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    const SUBJECT = 'Your weather this week';

    /**
     * @var \App\User
     */
    protected $user;

    /**
     * @var string
     */
    protected $weather;

    /**
     * @var \App\Location
     */
    protected $city;

    /**
     * Create a new message instance.
     *
     * @param \App\User     $user
     * @param string        $weather
     * @param \App\Location $city
     */
    public function __construct(User $user, string $weather, Location $city)
    {
        $this->user = $user;
        $this->weather = json_decode($weather);
        $this->city = $city;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('forecast@myweather.co.uk')
            ->subject(self::SUBJECT)
            ->markdown('emails.forecast')
            ->withUser($this->user)
            ->withWeather($this->weather)
            ->withCity($this->city);
    }
}
