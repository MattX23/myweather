<?php

namespace App\Jobs;

use App\Location;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReturnLocationData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Location
     */
    protected $location;

    /**
     * @var bool
     */
    protected $success;

    /**
     * Create a new job instance.
     *
     * @param \App\Location $location
     * @param bool          $success
     */
    public function __construct(Location $location, bool $success = true)
    {
        $this->location = $location;
        $this->success = $success;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        if (!$this->location->lat) $this->dispatchNow(new GetLatLong($this->location));

        return response()->json([
            'success' => $this->success,
            'city' => $this->location->name,
            'lat' => $this->location->lat,
            'long' => $this->location->long,
            'id' => $this->location->id
        ]);
    }
}
