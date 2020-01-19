<?php

namespace App\Jobs;

use App\Location;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use stdClass;

class GetWeather implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Location
     */
    protected $location;

    /**
     * @var string[]
     */
    const WEATHER_TYPES = [
        'CLEAR_DAY'           => 'clear-day',
        'CLEAR_NIGHT'         => 'clear-night',
        'RAIN'                => 'rain',
        'SNOW'                => 'snow',
        'SLEET'               => 'sleet',
        'WIND'                => 'wind',
        'FOG'                 => 'fog',
        'CLOUDY'              => 'cloudy',
        'PARTLY_CLOUDY_DAY'   => 'partly-cloudy-day',
        'PARTLY_CLOUDY_NIGHT' => 'partly-cloudy-night'
    ];

    /**
     * Create a new job instance.
     *
     * @param \App\Location $location
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * Execute the job.
     *
     * @return object
     */
    public function handle()
    {
        $lat = $this->location->lat;
        $long = $this->location->long;

        $client = new Client();
        $response = $client->request('GET', 'https://api.darksky.net/forecast/'.config('keys.dark_sky').'/'.$lat.','.$long);

        $contents = json_decode($response->getBody()->getContents());

        $weather = new StdClass();

        $day = Carbon::now();

        if ($response->getStatusCode() === 200) {

            $weather->temperature = $this->convertToCelcius($contents->currently->temperature);
            $weather->feelsLike = $this->convertToCelcius($contents->currently->apparentTemperature);
            $weather->todaySummary = $contents->minutely->summary;
            $weather->weeklySummary = $contents->daily->summary;

            $weather->todayHigh = $this->convertToCelcius($contents->daily->data[0]->temperatureMax);
            $weather->todayLow = $this->convertToCelcius($contents->daily->data[0]->temperatureMin);
            $weather->todayWeekday = $day->englishDayOfWeek;
            $weather->todayIcon = $this->setIcon($contents->daily->data[0]->icon);
            $weather->todayRain = $this->percentage($contents->daily->data[0]->precipProbability);
            $weather->todaySunriseTime = $this->getTime($contents->daily->data[0]->sunriseTime);
            $weather->todaySunsetTime = $this->getTime($contents->daily->data[0]->sunsetTime);

            $weather->tomorrowHigh = $this->convertToCelcius($contents->daily->data[1]->temperatureMax);
            $weather->tomorrowLow = $this->convertToCelcius($contents->daily->data[1]->temperatureMin);
            $weather->tomorrowSummary = $contents->daily->data[1]->summary;
            $weather->tomorrowWeekday = $day->addDay()->englishDayOfWeek;
            $weather->tomorrowIcon = $this->setIcon($contents->daily->data[1]->icon);
            $weather->tomorrowRain = $this->percentage($contents->daily->data[1]->precipProbability);
            $weather->tomorrowSunriseTime = $this->getTime($contents->daily->data[1]->sunriseTime);
            $weather->tomorrowSunsetTime = $this->getTime($contents->daily->data[1]->sunsetTime);

            $weather->dayThreeHigh = $this->convertToCelcius($contents->daily->data[2]->temperatureMax);
            $weather->dayThreeLow = $this->convertToCelcius($contents->daily->data[2]->temperatureMin);
            $weather->dayThreeSummary = $contents->daily->data[2]->summary;
            $weather->dayThreeWeekday = $day->addDay()->englishDayOfWeek;
            $weather->dayThreeIcon = $this->setIcon($contents->daily->data[2]->icon);
            $weather->dayThreeRain = $this->percentage($contents->daily->data[2]->precipProbability);
            $weather->dayThreeSunriseTime = $this->getTime($contents->daily->data[2]->sunriseTime);
            $weather->dayThreeSunsetTime = $this->getTime($contents->daily->data[2]->sunsetTime);

            $weather->dayFourHigh = $this->convertToCelcius($contents->daily->data[3]->temperatureMax);
            $weather->dayFourLow = $this->convertToCelcius($contents->daily->data[3]->temperatureMin);
            $weather->dayFourSummary = $contents->daily->data[3]->summary;
            $weather->dayFourWeekday = $day->addDay()->englishDayOfWeek;
            $weather->dayFourIcon = $this->setIcon($contents->daily->data[3]->icon);
            $weather->dayFourRain = $this->percentage($contents->daily->data[3]->precipProbability);
            $weather->dayFourSunriseTime = $this->getTime($contents->daily->data[3]->sunriseTime);
            $weather->dayFourSunsetTime = $this->getTime($contents->daily->data[3]->sunsetTime);

            $weather->dayFiveHigh = $this->convertToCelcius($contents->daily->data[4]->temperatureMax);
            $weather->dayFiveLow = $this->convertToCelcius($contents->daily->data[4]->temperatureMin);
            $weather->dayFiveSummary = $contents->daily->data[4]->summary;
            $weather->dayFiveWeekday = $day->addDay()->englishDayOfWeek;
            $weather->dayFiveIcon = $this->setIcon($contents->daily->data[4]->icon);
            $weather->dayFiveRain = $this->percentage($contents->daily->data[4]->precipProbability);
            $weather->dayFiveSunriseTime = $this->getTime($contents->daily->data[4]->sunriseTime);
            $weather->dayFiveSunsetTime = $this->getTime($contents->daily->data[4]->sunsetTime);

            $weather->daySixHigh = $this->convertToCelcius($contents->daily->data[5]->temperatureMax);
            $weather->daySixLow = $this->convertToCelcius($contents->daily->data[5]->temperatureMin);
            $weather->daySixSummary = $contents->daily->data[5]->summary;
            $weather->daySixWeekday = $day->addDay()->englishDayOfWeek;
            $weather->daySixIcon = $this->setIcon($contents->daily->data[5]->icon);
            $weather->daySixRain = $this->percentage($contents->daily->data[5]->precipProbability);
            $weather->daySixSunriseTime = $this->getTime($contents->daily->data[5]->sunriseTime);
            $weather->daySixSunsetTime = $this->getTime($contents->daily->data[5]->sunsetTime);

            $weather->daySevenHigh = $this->convertToCelcius($contents->daily->data[6]->temperatureMax);
            $weather->daySevenLow = $this->convertToCelcius($contents->daily->data[6]->temperatureMin);
            $weather->daySevenSummary = $contents->daily->data[6]->summary;
            $weather->daySevenWeekday = $day->addDay()->englishDayOfWeek;
            $weather->daySevenIcon = $this->setIcon($contents->daily->data[6]->icon);
            $weather->daySevenRain = $this->percentage($contents->daily->data[6]->precipProbability);
            $weather->daySevenSunriseTime = $this->getTime($contents->daily->data[6]->sunriseTime);
            $weather->daySevenSunsetTime = $this->getTime($contents->daily->data[6]->sunsetTime);

            $weather->image = $this->setBackgroundImage($contents->daily->data[0]->icon);

            Cache::store('redis')->add($this->location->id, json_encode($weather), 1800);
        }

        return json_encode($weather);
    }

    /**
     * @param int $temp
     *
     * @return int
     */
    protected function convertToCelcius(int $temp): int
    {
        return (int) ($temp - 32) * 5/9;
    }

    /**
     * @param string $icon
     *
     * @return string
     */
    protected function setBackgroundImage(string $icon): string
    {
        foreach (self::WEATHER_TYPES as $WEATHER_TYPE) {
            if ($WEATHER_TYPE === $icon) return asset('storage/images/'.$WEATHER_TYPE.'.jpg');
        }

        return asset('storage/images/clear-day.jpg');
    }

    /**
     * @param string $icon
     *
     * @return string
     */
    protected function setIcon(string $icon): string
    {
        foreach (self::WEATHER_TYPES as $WEATHER_TYPE) {
            if ($WEATHER_TYPE === $icon) return asset('storage/icons/'.$WEATHER_TYPE.'.png');
        }

        return asset('storage/icons/clear-day.jpg');
    }

    /**
     * @param float $number
     *
     * @return string
     */
    protected function percentage(float $number): string
    {
        return ($number * 100) . '%';
    }

    /**
     * @param int $time
     *
     * @return string
     */
    protected function getTime(int $time): string
    {
        return date("H:i", $time);
    }
}
