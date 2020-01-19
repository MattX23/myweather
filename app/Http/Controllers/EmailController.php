<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleSubscription(Request $request)
    {
        $request->user('api')->update([
            'is_mail' => $request->status,
        ]);

        return response()->json('success');
    }
}
