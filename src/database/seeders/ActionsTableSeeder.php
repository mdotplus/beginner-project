<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'action' => 'work_start',
        ];
        DB::table('actions')->insert($param);
        $param = [
            'action' => 'work_end',
        ];
        DB::table('actions')->insert($param);
        $param = [
            'action' => 'break_start',
        ];
        DB::table('actions')->insert($param);
        $param = [
            'action' => 'break_end',
        ];
        DB::table('actions')->insert($param);
    }
}
