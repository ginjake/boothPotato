<?php
namespace App\Http\Requests\Gift;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    /**
     * エラーメッセージの返却
     *
     * @return array
     */
    public function messages()
    {
        return [
            'url.string' => ':attributeはURLにしてください。',
            'url.unique' => '既に登録されている商品のようです',
            'url.regex' => ':attributeの形式が間違っています。',
        ];
    }
}
