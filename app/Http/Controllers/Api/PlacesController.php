<?php

namespace App\Http\Controllers\Api;

use App\Models\Place;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Place\UpdateRequest;
use App\Http\Requests\Api\Place\LocationRequest;
use App\Http\Requests\Api\Place\LocationClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlacesController extends ApiController
{
    public function index()
    {
        $places = Place::all();
        if ($places->count() == 0) {
            return $this->failedResponse($places, 'places not found', 200);
        }
        foreach ($places as $place) {
            $place->images = explode(',', $place->images);
            if (!$place->area) {
                $place->city;
            } else {
                $place->area->city;
            }
        }
        return $this->successResponse($places);
    }

    public function topRating(Request $request)
    {
        $value = false;
        if ($request->filled('sort')) {
            if ($request->sort == 'name') {
                $value = 'name_en';
                $order = 'asc';
            }
            if ($request->sort == 'area') {
                $value = 'name_en';
                $order = 'desc';
            }
        }
        if ($value && $order == 'desc') {
            $topPlaces = Place::join('areas', 'places.area_id', '=', 'areas.id')
                ->select('places.*')
                ->where('active_topRating', 1)
                ->orderBy('areas.' . $value, $order)
                ->paginate(8);
        } elseif ($value && $order == 'asc') {
            $topPlaces = Place::where('active_topRating', 1)->orderBy($value, $order)->paginate(8);
        } else {

            $topPlaces = Place::where('active_topRating', 1)->paginate(8);
        }
        if ($topPlaces->count() == 0) {
            return $this->failedResponse($topPlaces, 'Top Rating Places not found', 200);
        }
        foreach ($topPlaces as $place) {
            $place->images = explode(',', $place->images);
            if (!$place->area) {
                $place->city;
            } else {
                $place->area->city;
            }
        }
        return $this->successResponse($topPlaces);
    }


    public function popular(Request $request)
    {
        $value = false;
        if ($request->filled('sort')) {
            if ($request->sort == 'name') {
                $value = 'name_en';
                $order = 'asc';
            }
            if ($request->sort == 'area') {
                $value = 'name_en';
                $order = 'desc';
            }
        }

        if ($value && $order == 'desc') {
            $topPlaces = Place::join('areas', 'places.area_id', '=', 'areas.id')
                ->select('places.*')
                ->where('active_popular', 1)
                ->orderBy('areas.' . $value, $order)
                ->paginate(8);
        } elseif ($value && $order == 'asc') {
            $topPlaces = Place::where('active_popular', 1)->orderBy($value, $order)->paginate(8);
        } else {

            $topPlaces = Place::where('active_popular', 1)->paginate(8);
        }

        if ($topPlaces->count() == 0) {
            return $this->failedResponse($topPlaces, 'Popular Places not found', 200);
        }

        foreach ($topPlaces as $place) {
            $place->images = explode(',', $place->images);
            if (!$place->area) {
                $place->city;
            } else {
                $place->area->city;
            }
        }
        return $this->successResponse($topPlaces);
    }

    public function getByLocation(LocationRequest $request)
    {
        $value = false;
        if ($request->filled('sort')) {
            if ($request->sort == 'name') {
                $value = 'name_en';
                $order = 'asc';
            }
            if ($request->sort == 'date') {
                $value = 'created_at';
                $order = 'desc';
            }
        }
        if ($value) {
            $places = Place::where('category_id', $request->category_id)->where(function ($q) use ($request) {
                if ($request->city_id) {
                    $q->where('city_id', $request->city_id);
                }
                if ($request->area_id) {
                    $q->where('area_id', $request->area_id);
                }
            })->orderBy($value, $order)->paginate(8);
        } else {
            $places = Place::where('category_id', $request->category_id)->where(function ($q) use ($request) {
                if ($request->city_id) {
                    $q->where('city_id', $request->city_id);
                }
                if ($request->area_id) {
                    $q->where('area_id', $request->area_id);
                }
            })->paginate(8);
        }


        if ($places) {
            foreach ($places as $place) {
                $place->images = explode(',', $place->images);
                if (!$place->area) {
                    $place->city;
                } else {
                    $place->area->city;
                }
            }
            return $this->successResponse($places);
        } else {
            return $this->failedResponse($places, 'places not found', 200);
        }
    }

    public function getByClientLocation(LocationClientRequest $request)
    {
        $value = false;
        $client = Auth::guard('api')->user();
        if ($request->filled('sort')) {
            if ($request->sort == 'name') {
                $value = 'name_en';
                $order = 'asc';
            }
            if ($request->sort == 'date') {
                $value = 'created_at';
                $order = 'desc';
            }
        }
        if ($value) {
            $places = Place::where('category_id', $request->category_id)->where('city_id', $client->city_id)->orderBy($value, $order)->paginate(8);
        } else {
            $places = Place::where('category_id', $request->category_id)->where('city_id', $client->city_id)->paginate(8);
        }

        if ($places) {
            foreach ($places as $place) {
                $place->images = explode(',', $place->images);
                if (!$place->area) {
                    $place->city;
                } else {
                    $place->area->city;
                }
            }
            return $this->successResponse($places);
        } else {
            return $this->failedResponse($places, 'places not found', 200);
        }
    }

    public function updateRating(UpdateRequest $request, $id)
    {
        $place = Place::findOrFail($id);

        if ($place) {
            $rating = $place->rating * $place->counter + ($request->rating);
            $place->counter++;
            $newRating = $rating / $place->counter;
            $place->rating = $newRating;
            $place->save();

            return $this->successResponse($place);
        } else {
            return $this->failedResponse($place, 'place not found', 200);
        }
    }

    public function getByCategory($id)
    {
        $category = Category::findOrFail($id);
        $places = Place::where('category_id', $category->id)->paginate(8);
        if ($places) {
            return $this->successResponse($places);
        } else {
            return $this->failedResponse($places, 'place not found', 200);
        }
    }
}
