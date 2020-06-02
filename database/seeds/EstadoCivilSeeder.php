<?php

use App\Models\EstadoCivil;
use Illuminate\Database\Seeder;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado_civil = new EstadoCivil();
        $estado_civil->code = 'C';
        $estado_civil->name = 'CASADO(A)';
        $estado_civil->save();

        $estado_civil = new EstadoCivil();
        $estado_civil->code = 'S';
        $estado_civil->name = 'SOLTERO(A)';
        $estado_civil->save();

        $estado_civil = new EstadoCivil();
        $estado_civil->code = 'D';
        $estado_civil->name = 'DIVORCIADO(A)';
        $estado_civil->save();

        $estado_civil = new EstadoCivil();
        $estado_civil->code = 'O';
        $estado_civil->name = 'CONVIVIENTE';
        $estado_civil->save();

        $estado_civil = new EstadoCivil();
        $estado_civil->code = 'V';
        $estado_civil->name = 'VIUDO(A)';
        $estado_civil->save();
    }
}
