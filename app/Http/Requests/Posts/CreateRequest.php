<?php

namespace App\Http\Requests\Posts;

use Illuminate\Support\Arr;
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
        return [
            'title'       => 'required|string|min:3|max:60',
            'body'        => 'required|string|min:10',
            'description' => 'required|string|min:10|max:160',
            'category_id' => 'nullable|integer|exists:categories,id',
            'tags'        => 'nullable|array|exists:tags,id',
            'status'      => [
                'nullable',
                new PostStatusRule($this->user()),
                'in:' . implode(',', array_keys(PostStatus::all())),
            ],
        ];
    }

    public function process()
    {
        $data = $this->validated();

        $this
            ->user()
            ->posts()
            ->create(
                Arr::except($data, 'tags')
            )
            ->tags()->attach(
                $data['tags'] ?? []
            )
        ;
    }
}
