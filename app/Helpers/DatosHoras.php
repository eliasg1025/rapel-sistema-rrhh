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

    public function getDias()
    {
        return $this->fecha_hora_regreso->diffInDays($this->fecha_hora_salida);
    }

    public function getHoras()
    {
        return $this->fecha_hora_regreso->diffInHours($this->fecha_hora_salida) - ($this->getDias() * 24);
    }

    public function getTotalHoras()
    {
        return ($this->getDias() * 8) + $this->getHoras() - $this->refrigerio;
    }
}
