<?php

namespace App\Http\Controllers;

use App\Jobs\GetLatLong;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return int|null
     */
    public function fetchLocation(Request $request): ?int
    {
        $city = $request->city;

        $location = Location::where('name', '=', $city)->first();

        return $location ? $location->id : $this->dispatchNow(new GetLatLong($city));
    }
}
