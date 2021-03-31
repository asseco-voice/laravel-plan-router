<?php

namespace Asseco\PlanRouter\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PlanRequest extends FormRequest
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
            'name'           => 'required|string',
            'description'    => 'nullable|string',
            'priority'       => 'integer',
            'match_either'   => 'boolean',
            'template_id'    => 'nullable|integer|exists:plan_templates,id',
            'skill_group_id' => 'required|integer|exists:skill_groups,id',
        ];
    }

    /**
     * Dynamically set validator from 'required' to 'sometimes' if resource is being updated
     *
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $requiredOnCreate = ['name', 'skill_group_id'];

        $validator->sometimes($requiredOnCreate, 'sometimes', function () {
            return $this->plan !== null;
        });
    }
}
