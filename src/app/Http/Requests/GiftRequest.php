<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class GiftRequest extends FormRequest
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
        $rules = [
            'url' => ['string','regex:/(http).*(booth).*(items)/'],
        ];
        return $rules;
    }
}
