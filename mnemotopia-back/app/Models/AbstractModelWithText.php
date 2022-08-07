<?php

namespace App\Models;

use App\Scopes\CurrentLanguageScope;
use App\Scopes\TextWithCurrentLanguageScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbstractModelWithText extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'text_id',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
//        todo r
//        static::addGlobalScope(new TextWithCurrentLanguageScope);
    }

    /**
     * Get the text for the blog Item.
     */
    public function text(): object
    {
        return $this->hasMany(TextByLanguage::class, 'text_id', 'text_id');
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName(): string
    {
//        return "questions.id";
//        $key = $this->getTable() . '.' . $this->primaryKey;
        $key = $this->primaryKey;
//        /*s*/echo '$key= <pre>' . print_r($key, true). '</pre>'; //todo r

        return $key;
    }
}
