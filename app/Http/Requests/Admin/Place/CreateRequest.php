<?php

namespace App\Http\Requests\Admin\Place;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => "required|regex:/^[A-Za-z0-9_\s]+$/",
            'name_ar' => "required|string|regex:/^[ء-ي ?0-9]+$/u",
            'description_en' => "required|regex:/^[A-Za-z0-9_\s]+$/",
            'description_ar' => "required|string|regex:/^[ء-ي ?0-9]+$/u",
            'address_en' => "required|regex:/^[A-Za-z0-9_\s]+$/",
            'address_ar' => "required|string|regex:/^[ء-ي ?0-9]+$/u",
            'main_image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'images.0' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'active_topRating'=> "required",
            'active_popular'=> "required",
            'city_id' => "required|exists:cities,id",
            'area_id' => "required|exists:areas,id",



        ];
    }
}
