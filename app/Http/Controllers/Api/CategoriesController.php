<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoriesController extends ApiController
{
    public function index()
    {

        $categories = Category::all();
        if ($categories) {
            return $this->successResponse($categories);
        } else {
            return $this->failedResponse($categories, 'categories not found', 200);
        }
    }

    public function home()
    {

        $categories = Category::where('view', 1)->take(4)->get();
        if ($categories) {
            return $this->successResponse($categories);
        } else {
            return $this->failedResponse($categories, 'categories not found', 200);
        }
    }
}
