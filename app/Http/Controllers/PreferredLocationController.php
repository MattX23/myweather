<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreferredLocationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function setLocation(Request $request)
    {
        $request->user('api')->preferredLocation->update([
            'location_id' => $request->id,
        ]);
    }
}
