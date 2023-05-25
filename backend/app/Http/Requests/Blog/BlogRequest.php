<?php

namespace App\Http\Requests\Blog;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends BaseRequest
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
            'userId' => ['required'],
            'name' => ['required'],
            'slug' => ['required'],
            'description' => ['required'],
            'content' => ['required']
        ];
    }
}
