<?php

namespace Database\Seeders;

use App\Services\Group\ChainService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChainsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chainService = new ChainService();
        $chainService->storeByParams(['group_id' => 1, 'text' => 'chain1']);
    }
}
