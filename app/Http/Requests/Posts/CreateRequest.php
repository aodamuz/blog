<?php

namespace App\Http\Requests\Posts;

use App\Rules\PostStatusRule;
use App\Support\Enum\PostStatus;
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
        dd($this->all());
        $msg = 'You do not have permission to assign the status of this post.';

        return [
            'title'       => 'required|string|min:3|max:60',
            'body'        => 'required|string|min:10',
            'description' => 'required|string|min:10|max:160',
            // The identifier of the category assigned as default in a post is
            // null by default. The system assumes that a post without the
            // category identifier will be a post without a category.
            'category_id' => 'nullable|integer|exists:categories,id',
            'status'      => [
                'nullable',
                new PostStatusRule($this->user()),
                'in:' . implode(',', array_keys(PostStatus::all())),
            ],
        ];
    }
}
