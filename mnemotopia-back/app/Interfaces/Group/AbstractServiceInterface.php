<?php

namespace App\Interfaces\Group;

use Illuminate\Http\Request;

interface AbstractServiceInterface
{
    public function destroy($modelInstance);

    public function store(Request $request);
    public function storeByParams($params);

    public function list($params = []);
}
