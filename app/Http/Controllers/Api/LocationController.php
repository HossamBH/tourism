<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\City;
use App\Http\Controllers\ApiController;

class LocationController extends ApiController
{
    /**
     * Display a listing of the cities.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCities()
    {
        $cities = City::all();

        if ($cities) {
            return $this->successResponse($cities);
        } else {
            return $this->failedResponse($cities, 'cities not found', 200);
        }
    }

    /**
     * Display a listing of the areas.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAreas()
    {
        $areas = Area::all();

        if ($areas) {
            return $this->successResponse($areas);
        } else {
            return $this->failedResponse($areas, 'areas not found', 200);
        }
    }

    /**
     * Display a listing of the areas for a city.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAreas($id)
    {
        $areas = Area::where('city_id', $id)->get();

        if ($areas) {
            return $this->successResponse($areas);
        } else {
            return $this->failedResponse($areas, 'areas not found', 200);
        }
    }
}
