<?php

namespace App\Jobs;

use App\Location;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetLatLong implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $city;

    /**
     * Create a new job instance.
     *
     * @param string $city
     */
    public function __construct(string $city)
    {
        $this->city = $city;
    }

    /**
     * Execute the job.
     *
     * @return int|null
     */
    public function handle()
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            'https://api.opencagedata.com/geocode/v1/json?q='.$this->city.'&countrycode=gb&key='.config('keys.api_key')
        );

        $contents = json_decode($response->getBody()->getContents());

        if ($contents->results) {
            $lat = $contents->results[0]->geometry->lat;
            $long = $contents->results[0]->geometry->lng;

            $location = Location::create([
                'name' => ucfirst($this->city),
                'lat'  => $lat,
                'long' => $long,
            ]);

            return $location->id;
        }

        return null;
    }
}
