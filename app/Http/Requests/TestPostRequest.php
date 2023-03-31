<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestPostRequest extends FormRequest
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
        return [
            'content_update' => 'required| max:20',
            //
        ];
    }

    public function messages()
    {
        return [
            'content_update.required' => '・タスクを入力してください',
            'content_update.max' => '・タスクは20文字以内で入力してください。',
        ];
    }
}
