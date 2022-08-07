<?php

namespace App\Models;

use App\Scopes\CurrentLanguageScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextByLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'text_id',
        'language_id',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CurrentLanguageScope);
    }
}
