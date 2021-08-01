<?php

namespace App\Http\Requests\Admin\Banner;

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
            'title_en' => "required|regex:/^[A-Za-z0-9_\s]+$/",
            'title_ar' => "required|string|regex:/^[ء-ي ?0-9]+$/u",
            'description_en' => "required|regex:/^[A-Za-z0-9_\s]+$/",
            'description_ar' => "required|string|regex:/^[ء-ي ?0-9]+$/u",
            'image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ];
    }
}
