<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupUpdateOrCreateRequest extends AbstractUpdateOrCreateRequest
{
    protected array $updateRequestRules = [
        'text' => ['string'],
        'shared_options' => ['boolean'],
        'strict_order' => ['boolean'],
    ];

    protected array $requiredToCreateFields = ['text'];

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
