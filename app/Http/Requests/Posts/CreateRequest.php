<?php

namespace App\Http\Requests\Posts;

use Illuminate\Support\Str;
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
            'title'       => 'required|string|min:3|max:60',
            'body'        => 'required|string|min:10',
            'description' => 'required|string|min:10|max:160',
            // The category assigned as the default is required in production.
            // The system will always have a category called: Uncategorized.
            // In the CreatePostsTable migration, the value of the "category_id"
            // table defaults to the identifier 1 of the default category.
            'category_id' => 'nullable|integer|exists:categories,id',
        ];
    }

    /**
     * Get the validated data of the request including the authenticated user.
     *
     * @return array
     */
    public function getValidData()
    {
        $data = $this->validated();

        $data['user_id'] = $this->user()->id;

        return $data;
    }
}
