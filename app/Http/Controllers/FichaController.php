<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FichaController extends Controller
{
    public function test()
    {
        $pdf = \PDF::loadView('fichas-ingresos-obreros.rapel.contrato');

        return $pdf->stream('contrato-rapel.pdf');
    }

    public function test2()
    {
        $pdf = \PDF::loadView('fichas-ingresos-obreros.rapel.contrato2');

        return $pdf->stream('contrato-rapel.pdf');
    }
}
