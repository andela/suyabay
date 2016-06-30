<?php

namespace Suyabay\Http\Requests;

use Suyabay\Http\Requests\Request;

class AccountUpgradeRequest extends Request
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
            'email' => 'required|email|max:100',
            'reason' => 'required|max:256',
        ];
    }
}
