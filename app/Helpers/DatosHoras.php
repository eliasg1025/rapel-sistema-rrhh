<?php

namespace App\Helpers;

use Carbon\Carbon;

class DatosHoras
{
    public $fecha_hora_salida;
    public $fecha_hora_regreso;
    public $horario_entrada;
    public $refrigerio;

    public function __construct(
        $fecha_hora_salida,
        $fecha_hora_regreso,
        $horario_entrada,
        $refrigerio
    )
    {
        $this->fecha_hora_salida = Carbon::parse($fecha_hora_salida);
        $this->fecha_hora_regreso = Carbon::parse($fecha_hora_regreso);
        $this->horario_entrada = $horario_entrada;
        $this->refrigerio = $refrigerio;
    }

    public function isValid(): bool
    {
        return $this->fecha_hora_regreso->greaterThan($this->fecha_hora_salida);
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
