<?php

namespace App\Helpers;

use Carbon\Carbon;

class DiasSancion
{
    public $fecha_incidencia;
    public $duracion;
    public $dias_en_hacer_efectivo;

    public function __construct($fecha_incidencia, $duracion, $dias_en_hacer_efectivo=1)
    {
        $this->fecha_incidencia = $fecha_incidencia;
        $this->duracion = $duracion;
        $this->dias_en_hacer_efectivo;
    }

    public function getDiaIncio()
    {
        return Carbon::parse($this->fecha_incidencia)->addDays($this->dias_en_hacer_efectivo);
    }

    private function getCantidadDomingos()
    {
        $start = $this->getDiaIncio();
        $end = $this->getDiaIncio()->addDays($this->dias_en_hacer_efectivo + $this->duracion);
        $days = $start->diff($end, true)->days;

        return intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
    }

    public function getDiaTermino()
    {
        return Carbon::parse($this->fecha_incidencia)->addDays($this->dias_en_hacer_efectivo + $this->duracion + $this->getCantidadDomingos());
    }


    public function getCantidadHotasEfectivas()
    {
        return ($this->getDiaTermino()->diffInDays($this->getDiaIncio()) - $this->getCantidadDomingos() + 1) * 8;
    }
}
