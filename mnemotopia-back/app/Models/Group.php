<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends AbstractModelWithText
{
    use HasFactory;

    /**
     * The questions that belong to the group.
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'questions_groups', 'group_id', 'question_id');
    }

    /**
     * The chains that belong to the group.
     */
    public function chains(): BelongsToMany
    {
        return $this->belongsToMany(Chains::class, 'chains_groups', 'group_id', 'chain_id');
    }
}
