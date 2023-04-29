<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            ['name' => '家事'],
            ['name' => '勉強'],
            ['name' => '運動'],
            ['name' => '食事'],
            ['name' => '移動'],
        ];

        DB::table('tags')->insert($tags);
    }
}
