<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chains extends AbstractModelWithText
{
    use HasFactory;

    /**
     * Get the chain_element associated with the chain.
     */
    public function chainElements(): object
    {
        return $this->hasMany(ChainElements::class, 'chain_id', 'id');
    }
}
