<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating' => 'required|integer|min:1|max:5', 
            'comment' => 'required|string|max:400', 
            'image_url' => 'nullable|image|mimes:jpeg,png|max:2048', 
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'rating.required' => '星の評価を選択してください。',
            'rating.integer' => '星の評価は整数で指定してください。',
            'rating.min' => '星の評価は最低1を選択してください。',
            'rating.max' => '星の評価は最大5を選択してください。',
            'comment.required' => 'コメントを入力してください。',
            'comment.max' => 'コメントは400文字以内で入力してください。',
            'image.image' => 'アップロードできるのは画像ファイルのみです。',
            'image.mimes' => '画像ファイルはjpegまたはpng形式のみ対応しています。',
            'image.max' => '画像ファイルのサイズは2MB以下にしてください。',
        ];
    }
}
