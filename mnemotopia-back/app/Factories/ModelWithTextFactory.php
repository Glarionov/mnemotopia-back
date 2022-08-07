<?php

namespace App\Factories;

use App\Models\AbstractModelWithText;
use App\Models\Text;
use App\Models\TextByLanguage;
use Illuminate\Support\Facades\DB;

class ModelWithTextFactory
{
    /**
     * Creates an object by model, adding it proper text id
     * @param string $model
     * @param string $text
     * @return AbstractModelWithText
     */
    public static function create(string $model, string $text = '', $params = [])
    {
        $languageId = session('language_id') ?? 1;
        $alreadyExistingText = TextByLanguage::query()->where([['text', $text], ['language_id', $languageId]])->first();

        if (!empty($alreadyExistingText)) {
            $textId = $alreadyExistingText->text_id;
        } else {
            $textObject = new Text();
            $textObject->save();
            $textId = $textObject->id;

            $textByLanguageObject = new TextByLanguage();
            $textByLanguageObject->text_id = $textId;
            $textByLanguageObject->language_id = $languageId;
            $textByLanguageObject->text = $text;
            $textByLanguageObject->save();
        }

//        $instance = $model->newInstance(['text_id' => $textId]);
        $instance = new $model();
        $instance->text_id = $textId;
        foreach ($params as $param => $value) {
            $instance->{$param} = $value;
        }
//        $instance = $model->newInstance();
        $instance->save();
        $instance->text = $text;

        $table = $instance->getTable();
//        return $model::find($instance->id);
        return $model::where("$table.id", '=', $instance->id)->first();
//        return $model::where('questions.id', '=', $instance->id)->first();;
    }

    /**
     * @param string $model
     * @param array $params
     * @return AbstractModelWithText
     */
    public static function createByRequestText(string $model, array $params = [])
    {
        return static::create($model, request()->input('text'), $params);
    }
}
