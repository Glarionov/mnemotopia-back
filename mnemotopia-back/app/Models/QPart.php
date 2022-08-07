<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class QPart extends Model
{
    use HasFactory;

    protected $table = 'qparts';

    protected $fillable = [
        'position',
        'question_id',
    ];

    /**
     * The options that belong to the question.
     */
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Qoptions::class, 'qparts_answers', 'qpart_id', 'qoption_id')->withPivot('correct');
    }

}
