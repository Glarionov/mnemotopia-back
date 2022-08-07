<?php

namespace Database\Seeders;

use App\Services\Group\ChainElementService;
use App\Services\Group\ChainService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChainElementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chainService = new ChainElementService();
        $chainService->storeByParams(['chain_id' => 1]);
    }
}
