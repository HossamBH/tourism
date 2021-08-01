<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BannerController extends ApiController
{
    public function index()
    {

        $banners = Banner::paginate(8);
        if ($banners) {
            return $this->successResponse($banners);
        } else {
            return $this->failedResponse($banners, 'banners not found', 200);
        }
    }
}
