<?php

namespace Asseco\PlanRouter\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRuleRequest extends FormRequest
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
            'rules'           => 'array|required',
            'rules.*.rule_id' => 'required_with:rules|exists:rules,id',
            'rules.*.regex'   => 'string|required_with:rules',
        ];
    }
}
