<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function getCountries()
    {
        return response()->json([
            [
                'code' => 'PH',
                'name' => 'Philippines'
            ],
        ]);
    }

    public function getProvinces()
    {
        try {
            $res = Http::timeout(10)->get("https://psgc.gitlab.io/api/provinces");
            if ($res->successful()) {
                return response()->json($res->json());
            }
            return response()->json(['error' => 'Failed to fetch provinces.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Service unavailable.'], 503);
        }
    }

    public function getStates($provinceCode)
    {
        try {
            $res = Http::timeout(10)->get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities");
            if ($res->successful()) {
                return response()->json($res->json());
            }
            return response()->json(['error' => 'Failed to fetch cities.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Service unavailable.'], 503);
        }
    }

    public function getBarangays($stateCode)
    {
        try {
            $res = Http::timeout(10)->get("https://psgc.gitlab.io/api/cities-municipalities/{$stateCode}/barangays");
            if ($res->successful()) {
                return response()->json($res->json());
            }
            return response()->json(['error' => 'Failed to fetch barangays.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Service unavailable.'], 503);
        }
    }
}
