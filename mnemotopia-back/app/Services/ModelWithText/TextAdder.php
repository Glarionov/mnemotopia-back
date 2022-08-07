<?php

namespace App\Services\ModelWithText;

use App\Models\TextByLanguage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TextAdder
{
    public function __construct(private $objectsNeedingTexts = [], private $textIds = [])
    {
    }

    public function addObjectsNeedingTexts(Collection|array &$objects)
    {
        if (is_array($objects) == 'array') {
            $textIds = array_column($objects, 'text_id');
            $this->textIds = array_merge($textIds, $this->textIds);
        } else {
            $textIds = $objects->pluck('text_id');
            $this->textIds = array_merge($textIds->toArray(), $this->textIds);
        }

        $this->objectsNeedingTexts[] = &$objects;
    }



    public function addTexts(&$objects = null)
    {
        if ($objects) {
            $this->addObjectsNeedingTexts($objects);
        }



        try {
            $languageId = session('language_id') ?? '1';

            $texts = TextByLanguage::query()
                ->where('language_id', '=', $languageId)
                ->whereIn('text_id', $this->textIds)
                ->get()->keyBy('text_id');

            foreach ($this->objectsNeedingTexts as $index => $objectsNeedingText) {
                foreach ($objectsNeedingText as $objectIndex => $objectNeedingText) {
                    if (is_array($objectNeedingText)) {
                        $this->objectsNeedingTexts[$index][$objectIndex]['text'] = $texts[$objectNeedingText['text_id']]->text;
                    } else {
                        $objectNeedingText->text = $texts[$objectNeedingText->text_id]->text;
                    }
                }
                unset($this->objectsNeedingTexts[$index]);
            }

        } catch (\Exception $exception) {
            return 1;
        }

    }

    public static function addTextToSingleInstance(&$object)
    {
        $languageId = session('language_id') ?? '1';

        $text = TextByLanguage::query()
            ->where('language_id', '=', $languageId)
            ->where('text_id', $object->text_id)
            ->pluck('text')
            ->first();

        $object->text = $text;
    }
}
