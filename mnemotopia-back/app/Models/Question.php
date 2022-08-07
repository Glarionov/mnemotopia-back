<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends AbstractModelWithText
{
    use HasFactory;

    protected $fillable = [
        'type',
        'text_id',
    ];

    /**
     * The groups that belong to the question.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'questions_groups', 'question_id', 'group_id');
    }

    /**
     * The options that belong to the question.
     */
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Qoptions::class, 'question_answers', 'qoption_id', 'question_id')->withPivot('correct');
    }

}
