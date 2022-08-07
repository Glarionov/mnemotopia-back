<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChainElementUpdateOrCreateRequest extends AbstractUpdateOrCreateRequest
{
    protected array $updateRequestRules = [
        'chain_id' => ['integer'],
        'order' => ['integer'],
    ];

    protected array $requiredToCreateFields = ['chain_id'];

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
