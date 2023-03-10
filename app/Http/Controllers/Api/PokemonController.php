<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PokemonController extends Controller
{
    public function get(Request $request)
    {
        $rules = [
            'limit' => ['nullable', 'numeric'],
            'offset' => ['nullable', 'numeric'],
        ];

        $validator = Validator::make($request->only(['limit', 'offset']), $rules);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'messages' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response = Http::withToken($request->bearerToken())
            ->get(Config::get('services.poke.endpoint') . 'pokemon', [
                'limit' => $request->limit,
                'offset' => $request->offset,
            ]);

        $collect = $response->collect('results');

        Pokemon::insert($collect->toArray());

        return response()->json([
            'status' => true,
            'messages' => 'success'
        ], Response::HTTP_OK);
    }
}
