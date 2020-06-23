<?php

use App\Models\Empresa;
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
        $empresa = new Empresa();
        $empresa->id = 9;
        $empresa->name = 'SOCIEDAD AGRICOLA RAPEL SAC';
        $empresa->ruc = '20451779711';
        $empresa->save();

        $empresa = new Empresa();
        $empresa->id = 14;
        $empresa->name = 'SOCIEDAD EXPORTADORA VERFRUT SAC';
        $empresa->ruc = '20601438586';
        $empresa->save();
    }
}
