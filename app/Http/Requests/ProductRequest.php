<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => ['required'],
            'description' => ['required', 'max:300'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required'],
        ];
        if($this->isMethod('post')){
            $rules['images.*'] = ['required', 'max:1000', 'image', 'mimes:jpeg,jpg,png,gif'];
        } else {
            $rules['images.*'] = ['max:1000', 'image', 'mimes:jpeg,jpg,png,gif'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'category_id.required' => 'The category is required',
            'images.*.required' => 'Please select an image for all image inputs',
            'images.*.max' => 'The images must not exceed 1MB',
            'images.*.image' => 'Invalid image format',
            'images.*.mimes' => 'Only JPEG, JPG, PNG, and GIF are allowed',
        ]; 
    }
}