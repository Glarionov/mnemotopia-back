<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChainUpdateOrCreateRequest extends AbstractUpdateOrCreateRequest
{
    protected array $updateRequestRules = [
        'group_id' => ['integer'],
        'text' => ['string'],
    ];

    protected array $requiredToCreateFields = ['group_id'];

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
