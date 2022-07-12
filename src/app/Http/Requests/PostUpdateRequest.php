<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        if ($this->userId == $user->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', 'string'],
            'title' => ['required', 'string', 'max:40'],
        ];
    }
    public function messages()
    {
        return [
            'textContent.required' => '投稿内容は必ず記入して下さい。',
            'textContent.string' => '投稿内容は文字列で記入して下さい。',
            'title.required' => 'タイトルは必ず記入して下さい。',
            'title.string' => 'タイトルは文字列で記入して下さい。',
            'title.max' => 'タイトルは20文字までで入力して下さい。',
        ];
    }
}
