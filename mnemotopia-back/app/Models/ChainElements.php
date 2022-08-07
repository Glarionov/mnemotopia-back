<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChainElements extends Model
{
    use HasFactory;

    protected $fillable = [
        'chain_id',
        'order',
    ];

    /**
     * The questions that belong to the chain_element.
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'chain_elements_questions', 'chain_elements_id', 'question_id');
    }
}
