<?php

namespace App\Helpers;

use Carbon\Carbon;

class DatosHoras
{
    public $fecha_hora_salida;
    public $fecha_hora_regreso;
    public $horario_entrada;
    public $horario_salida;
    public $refrigerio;

    public function __construct(
        $fecha_hora_salida,
        $fecha_hora_regreso,
        $horario_entrada,
        $horario_salida,
        $refrigerio
    )
    {
        $this->fecha_hora_salida = Carbon::parse($fecha_hora_salida);
        $this->fecha_hora_regreso = Carbon::parse($fecha_hora_regreso);
        $this->horario_entrada = Carbon::parse($horario_entrada);
        $this->horario_salida = Carbon::parse($horario_salida);
        $this->nocturno = false;
        $this->refrigerio = $refrigerio;
    }

    public function esValido(): bool
    {
        return $this->fecha_hora_regreso->greaterThan($this->fecha_hora_salida);
    }

    public function verificarHoras()
    {
        $hora_salida = Carbon::parse($this->fecha_hora_salida->toTimeString());
        $hora_regreso = Carbon::parse($this->fecha_hora_regreso->toTimeString());

        $v1 = $hora_salida->greaterThanOrEqualTo($this->horario_entrada) &&
            $hora_salida->lessThanOrEqualTo($this->horario_salida);

        $v2 = $hora_regreso->greaterThanOrEqualTo($this->horario_entrada) &&
            $hora_regreso->lessThanOrEqualTo($this->horario_salida);

        return $v1 && $v2;
    }

    public function validarNocturno()
    {
        if ($this->horario_entrada->greaterThan($this->horario_salida)) {
            $this->nocturno = true;
        }
    }

    public function getDias()
    {
        return $this->fecha_hora_regreso->addDays( $this->nocturno ? 1 : 0 )->diffInDays($this->fecha_hora_salida);
    }

    public function getHoras()
    {
        return $this->fecha_hora_regreso->addDays( $this->nocturno ? 1 : 0 )->floatDiffInHours($this->fecha_hora_salida) - ($this->getDias() * 24);
    }

    public function getTotalHoras()
    {
        $horas_sin_redondear = ($this->getDias() * 8) + $this->getHoras() - $this->refrigerio;

        return ceil($horas_sin_redondear / 0.25) * 0.25;
    }
}
