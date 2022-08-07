<?php

namespace App\Services\Group;

use App\Interfaces\Group\ChainElementsServiceInterface;
use App\Interfaces\Group\GroupServiceInterface;
use App\Models\ChainElements;
use App\Models\Group;
use App\Models\Text;
use App\Models\TextByLanguage;
use App\Services\ModelWithText\TextAdder;

class ChainElementService extends AbstractService implements ChainElementsServiceInterface
{

    public function __construct(TextAdder $textAdder = new TextAdder())
    {
        parent::__construct(ChainElements::class, $textAdder);
    }

    public function list($params = [])
    {
        $result = ChainElements::query()->get();
        return $result;
    }

    public function store($request)
    {
        return $this->storeByParams($request->all());
    }

    public function storeByParams($params = [])
    {
        $chainId = $params['chain_id'] ?? null;

        $lastChainElementOrder = ChainElements::query()->where('chain_id', $chainId)->orderBy('order', 'desc')->pluck('order')->first();

        $params = [];
        if ($chainId) {
            $params['chain_id'] = $chainId;
        }

        $lastOrder = $lastChainElementOrder;

        $lastOrder++;

        $params['order'] = $lastOrder;

        $newChainElement = new ChainElements();
        $newChainElement->fill($params);
        $newChainElement->save();

        return $newChainElement;
    }
}
