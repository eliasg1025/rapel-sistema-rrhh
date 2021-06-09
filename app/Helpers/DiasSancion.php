<?php

namespace App\Helpers;

use Carbon\Carbon;

class DiasSancion
{
    public $fecha_incidencia;
    public $duracion;
    public $mismo_dia;

    public function __construct($fecha_incidencia, int $duracion, bool $mismo_dia)
    {
        $this->fecha_incidencia = Carbon::parse($fecha_incidencia);
        $this->duracion = $duracion;
        $this->mismo_dia = $mismo_dia;
    }

    public function getDiaIncio()
    {
        $desc = $this->mismo_dia ? 1 : 0;
        $dia_inicio = Carbon::parse($this->fecha_incidencia)->addDays(1 - $desc);
        return $dia_inicio->isSunday() ? $dia_inicio->addDays(1 - $desc) : $dia_inicio;
    }

    private function getCantidadDomingos()
    {
        $start = $this->getDiaIncio();
        $end = $this->getDiaIncio()->addDays($this->duracion);
        $days = $start->diff($end, true)->days;

        return intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
    }

    public function getDiaTermino()
    {
        $dia_termino = $this->getDiaIncio()->addDays($this->duracion + $this->getCantidadDomingos() - 1);
        return $dia_termino;
    }


    public function getCantidadHotasEfectivas()
    {
        return ($this->getDiaTermino()->diffInDays($this->getDiaIncio()) - $this->getCantidadDomingos() + 1) * 8;
    }
}
