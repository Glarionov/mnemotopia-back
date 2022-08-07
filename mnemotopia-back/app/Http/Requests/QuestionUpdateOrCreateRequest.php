<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateOrCreateRequest extends AbstractUpdateOrCreateRequest
{
    protected array $updateRequestRules = [
        'chain_element_id' => ['integer'],
        'group_id' => ['integer'],
        'text' => ['string'],
    ];

    protected array $requiredToCreateFields = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
