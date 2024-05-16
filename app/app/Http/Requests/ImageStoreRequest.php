<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ImageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,tiff,webp,bmp|max:5120|dimensions:min_width=500,min_height=500',
            'uploaderName' => 'required|string|max:255',
            'uploaderEmail' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        ];
    }

    public function messages(): array
    {
        return [
            'uploaderName.required' => 'The uploader name is required!',
            'uploaderEmail.required' => 'The uploader email is required!',
            'uploaderEmail' => 'The email must be a valid email address!',
            'image.required' => 'Image is required!',
            'image.mime' => 'Wrong file type!',
            'image.dimensions' => 'The image must be at least 500x500 pixels!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
