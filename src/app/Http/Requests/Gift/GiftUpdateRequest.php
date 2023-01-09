<?php
namespace App\Http\Requests\Gift;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Gift\BaseRequest;

class GiftUpdateRequest extends BaseRequest
{
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
        $data = $this->all();

        $rules = [
            'url' => [
                        'string',
                        Rule::unique('gifts')->ignore($data['id'], 'id')->where(function ($query) {
                            return $query->where('userId', Auth::user()->id);
                        }),
                        'regex:/^(http).*(booth).*(items\/)[0-9]+/',
                    ],
        ];
        return $rules;
    }
}
