<?php

namespace App\Http\Requests\Posts;

use Illuminate\Support\Arr;
use App\Rules\PostStatusRule;
use App\Support\Enum\PostStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        // dd($this->all());
        $id = $this->route('post')->id;
        $msg = 'You do not have permission to assign the status of this post.';

        return [
            'title'       => 'required|string|min:3|max:60',
            'slug'        => "required|string|min:1|max:60|unique:posts,{$id}",
            'body'        => 'required|string|min:10',
            'description' => 'required|string|min:10|max:160',
            // The category assigned by default in a publication is null.
            // The system assumes that a post without the identifier will
            // be an uncategorized post.
            'category_id' => 'nullable|integer|exists:categories,id',
            'tags'        => 'nullable|array|exists:tags,id',
            'user_id'     => 'nullable|integer|exists:users,id',
            'status'      => [
                'nullable',
                new PostStatusRule($this->user()),
                'in:' . implode(',', PostStatus::keys()),
            ],
        ];
    }

    public function process()
    {
        $data = $this->validated();

        if (empty($data['user_id'])) {
            unset($data['user_id']);
        }

        $this
            ->route('post')
            ->update(
                Arr::except($data, 'tags')
            )
        ;

        if (!empty($data['tags'])) {
            $this
                ->route('post')->tags()->sync(
                    $data['tags']
                )
            ;
        }
    }
}
