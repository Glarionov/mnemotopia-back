<?php

namespace App\Scopes;

use App\Models\TextByLanguage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TextWithCurrentLanguageScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $languageId = session('language_id') ?? 1;
        $table = $model->getTable();
//        /*s*/echo '$table= <pre>' . print_r($table, true). '</pre>'; //todo r
//        exit;//todo r
        $builder->leftJoin('text_by_languages AS tbl', "$table.text_id", '=', 'tbl.text_id')
        ->selectRaw("`$table`.*, `tbl`.text")->where('tbl.language_id', $languageId);
//        $builder->where('language_id', $languageId);
    }
}
