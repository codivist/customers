<?php

namespace Codivist\Modules\Customers\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequestEmail extends AbstractFormRequest
{
    public function rules()
    {
        $rules = [
            'email' => 'required|email|max:255',
        ];

        return $rules;
    }
}
