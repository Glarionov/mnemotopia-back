<?php

namespace App\Services\Group;

use App\Interfaces\Group\AbstractServiceInterface;
use App\Services\ModelWithText\TextAdder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AbstractService implements AbstractServiceInterface
{
    public function __construct(public string $mainModel, public TextAdder $textAdder)
    {
    }

    public function show($modelInstance)
    {
        return $modelInstance;
    }

    public function destroy($modelInstance): bool
    {
        $modelInstance->delete();
        return true;
    }

    public function store(Request $request)
    {
        // TODO: Implement store() method.
    }

    public function storeByParams($params)
    {
        // TODO: Implement storeByParams() method.
    }

    public function list($params = [])
    {
        // TODO: Implement list() method.
    }

    public function update(Request $request, $modelInstance)
    {
        return$modelInstance->fill($request->all())->save();
    }
}
