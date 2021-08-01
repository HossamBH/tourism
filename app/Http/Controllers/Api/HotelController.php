<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Hotel\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Place;
use App\Http\Controllers\ApiController;

class HotelController extends ApiController
{
    /**
     * Display a listing of the cities.
     *
     * @return \Illuminate\Http\Response
     */
    public function showHotels()
    {

        $hotels = Hotel::all();
        if ($hotels) {
            foreach ($hotels as $hotel) {
                if (!$hotel->area) {
                    $hotel->city;
                } else {
                    $hotel->area->city;
                }
            }

            return $this->successResponse($hotels);
        } else {
            return $this->failedResponse($hotels, 'hotels not found', 200);
        }
    }

    public function showTopRating()
    {
        $hotels = Hotel::orderBy('rating', 'DESC')->paginate(8);

        if ($hotels) {
            foreach ($hotels as $hotel) {
                if (!$hotel->area) {
                    $hotel->city;
                } else {
                    $hotel->area->city;
                }
            }
            return $this->successResponse($hotels);
        } else {
            return $this->failedResponse($hotels, 'hotels not found', 200);
        }
    }

    public function getByLocation(Request $request)
    {
        $hotels = Hotel::where(function ($q) use ($request) {
            if ($request->city_id) {
                $q->where('city_id', $request->city_id);
            }
            if ($request->area_id) {
                $q->where('area_id', $request->area_id);
            }
        })->latest()->paginate(8);;

        if ($hotels) {
            foreach ($hotels as $hotel) {
                if (!$hotel->area) {
                    $hotel->city;
                } else {
                    $hotel->area->city;
                }
            }
            return $this->successResponse($hotels);
        } else {
            return $this->failedResponse($hotels, 'hotels not found', 200);
        }
    }

    /**
     * Display a listing of the areas.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRating(UpdateRequest $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        if ($hotel) {
            $rating = $hotel->rating * $hotel->counter + ($request->rating);
            $hotel->counter++;
            $newRating = $rating / $hotel->counter;
            $hotel->rating = $newRating;
            $hotel->save();

            return $this->successResponse($hotel);
        } else {
            return $this->failedResponse($hotel, 'hotel not found', 200);
        }
    }
}
