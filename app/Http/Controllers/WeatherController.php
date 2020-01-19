<?php

namespace App\Http\Controllers;

use App\Jobs\GetWeather;
use App\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function get(Request $request)
    {
        $location = Location::find($request->id);

        return Cache::store('redis')->get($location->id) ??
            $this->dispatchNow(new GetWeather($location));
    }

    /**
     * @param string $name
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function flush(string $name): RedirectResponse
    {
        $location = Location::where('name', '=', $name)->first();

        if ($location) Cache::store('redis')->pull($location->id);

        return response()->redirectTo(route('home'));
    }
}
