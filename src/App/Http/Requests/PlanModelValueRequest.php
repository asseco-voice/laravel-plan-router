<?php

namespace Asseco\PlanRouter\App\Http\Requests;

use Asseco\PlanRouter\App\Contracts\PlanModelValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PlanModelValueRequest extends FormRequest
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
        return get_class(app(PlanModelValue::class))::getValidationRules();
    }

    /**
     * Dynamically set validator from 'required' to 'sometimes' if resource is being updated.
     *
     * @param  Validator  $validator
     */
    public function withValidator(Validator $validator)
    {
        $requiredOnCreate = ['plan_id', 'attribute', 'value'];

        $validator->sometimes($requiredOnCreate, 'sometimes', function () {
            return $this->plan_model_value !== null;
        });
    }
}
