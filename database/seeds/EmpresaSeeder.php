<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
            'id' => '9',
            'name' => 'SOCIEDAD AGRICOLA RAPEL SAC',
            'ruc' => '20451779711'
        ]);

        DB::table('empresas')->insert([
            'id' => '14',
            'name' => 'SOCIEDAD EXPORTADORA VERFRUT SAC',
            'ruc' => '20601438586'
        ]);
    }
}
