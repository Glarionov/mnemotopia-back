<?php

namespace App\Services\Group;

use App\Factories\ModelWithTextFactory;
use App\Interfaces\Group\ChainServiceInterface;
use App\Interfaces\Group\GroupServiceInterface;
use App\Models\ChainElements;
use App\Models\Chains;
use App\Models\Group;
use App\Models\Text;
use App\Models\TextByLanguage;
use App\Services\ModelWithText\TextAdder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ChainService extends AbstractServiceWithText implements ChainServiceInterface
{

    public function __construct(TextAdder $textAdder = new TextAdder())
    {
        parent::__construct(Chains::class, $textAdder);
    }

    public function list($params = [])
    {
        $result = Chains::query()->get();
        return $result;
    }

    public function storeByParams($params)
    {
        $groupId = $params['group_id'] ?? null;
        $text = $params['text'] ?? null;

        $newChain = ModelWithTextFactory::create(Chains::class, $text);

        $newChainId = $newChain->id;

        if ($groupId) {
            $insetData = ['chain_id' => $newChainId, 'group_id' => $groupId];
            DB::table('chains_groups')->insert($insetData);
        }

        $chainElement = new ChainElements();
        $chainElement->chain_id = $newChainId;
        $chainElement->save();

        return $newChain;
    }

    public function store($request = null)
    {
        return $this->storeByParams($request->all());
    }

}
