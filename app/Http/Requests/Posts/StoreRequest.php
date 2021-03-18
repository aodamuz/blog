<?php

namespace App\Http\Requests\Posts;

use App\Models\Post;
use Illuminate\Support\Arr;
use App\Rules\PostStatusRule;
use App\Support\Enum\PostStatus;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Post);
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
            'category_id' => 'nullable|integer|exists:categories,id',
            'tags'        => 'nullable|array|exists:tags,id',
            'status'      => [
                'nullable',
                new PostStatusRule($this->user()),
                'in:' . implode(',', PostStatus::keys()),
            ],
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $data = parent::validated();

        unset($data['tags']);

        return $data;
    }
}
