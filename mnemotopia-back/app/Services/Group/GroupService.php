<?php

namespace App\Services\Group;

use App\Interfaces\Group\GroupServiceInterface;
use App\Models\Group;
use App\Models\Text;
use App\Models\TextByLanguage;
use App\Services\ModelWithText\TextAdder;

class GroupService extends AbstractServiceWithText implements GroupServiceInterface
{

    public function __construct(TextAdder $textAdder = new TextAdder())
    {
        parent::__construct(Group::class, $textAdder);
    }

    public function list($params = [])
    {
        $result = Group::query()->get();
        return $result;
    }

    public function store($request = [])
    {
        // TODO: Implement store() method.
    }
}
