<?php

namespace App\Http\Requests\Post;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'post_name' => 'required',
            'slug'      => 'nullable',Rule::unique('posts', 'slug')->ignore($this->id),
        ];
    }

    public function messages() : array
    {
        return [
            'post_name.required' => 'The title name field is required.'
        ];
    }
}
