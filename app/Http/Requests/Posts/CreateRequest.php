<?php

namespace App\Http\Requests\Posts;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'title'       => 'required|string|min:3|max:60',
			'body'        => 'required|string|min:10',
			'description' => 'required|string|min:10|max:160',
		];
	}

	/**
	 * Get the validated data of the request including the authenticated user.
	 *
	 * @return array
	 */
	public function getData() {
		$data = $this->validated();

		$data['user_id'] = $this->user()->id;

		return $data;
	}
}
