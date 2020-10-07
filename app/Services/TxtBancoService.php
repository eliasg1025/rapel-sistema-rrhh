<?php

namespace App\Services;

use App\Models\Empresa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use stdClass;

class TxtBancoService
{
    public Empresa $empresa;
    public $fecha_pago;
    public array $data;
    public string $cuentaBbva;
    public string $cuentaBcp;

    public function __construct(Empresa $empresa, $fecha_pago, $data)
    {
        $this->fecha_pago = Carbon::parse($fecha_pago);
        $this->empresa = $empresa;
        $this->data = $data;
        $this->cuentaBbva = $this->empresa->id === 9 ? '00110245880100004456' : '00110278000100019135';
        $this->cuentaBcp = $this->empresa->id === 9 ? '4752274893094' : '4752467084018';
    }

    private function getTotal($arr)
    {
        return round(
            array_reduce($arr, fn($acc, $item) => $acc + $item['monto'], 0), 2
        );
    }

    private function getCantidad(array $arr)
    {
        return sizeof($arr);
    }

    public function bbva()
    {
        $data = $this->data['bbva'];

        sizeof( $data ) === 0 && [
            'message' => 'No hay registros para este banco'
        ];

        // Cabecera
        $codigoInicial       = '700';
        $numeroCuentaEmpresa = $this->cuentaBbva;
        $tipoMoneda          = 'PEN';
        $monto               = substr( '000000000000000' . $this->getTotal($data) * 100, -15 );
        $tipoProceso         = 'A';
        $referencia          = '         ' . $this->fecha_pago->format('d/m/Y');
        $cantidad            = '               ' . substr( '000000' . $this->getCantidad($data), -6 ) . 'N000000000000000000';

        $datosCabecera = [
            $codigoInicial,
            $numeroCuentaEmpresa,
            $tipoMoneda,
            $monto,
            $tipoProceso,
            $referencia,
            $cantidad
        ];
        $cabecera = array_reduce( $datosCabecera, fn($acc, $item) => $acc . $item, '' );

        function getRow( $row )
        {
            $tipoDOI = strlen($row['rut']) === 8 ? 'L' : 'E';
            $DOI = $row['rut'];
            $tipoAbono = 'P';
            $cuentaAbonar = $row['numero_cuenta'];
            $nombreBenefinicario = $row['apellido_paterno'] . ' ' . $row['apellido_materno'] . ' ' . $row['nombre'];
            $cantidad = substr( '000000000000000' . round($row['monto'], 2) * 100, -15 );

            $datos = '002' . $tipoDOI . $DOI . '    ' .
                substr( $tipoAbono . $cuentaAbonar . $nombreBenefinicario . '                                                 ', 0, 61 ) .
                $cantidad;

            return $datos;
        }

        $result = array_reduce( $data, fn($acc, $item) => $acc . getRow( $item ) . "\n", $cabecera . "\n" );

        Storage::disk('public')->put('/archivos-banco/' . $this->empresa->shortname . '_BBVAHABE_' . $this->fecha_pago->format('Y-m-d') . '.txt', $result);

        return $result;
    }

    public function validar(string $banco)
    {
        $arr = $this->data[$banco];
        $validator = fn() => false;

        switch ( $banco ) {
            case 'bcp':
                $validator = function($item) {
                    return !(
                        (
                            strlen($item['numero_cuenta']) === 14
                        ) && (
                            substr( $item['numero_cuenta'], strlen( $item['numero_cuenta'] ) - 3, 1 ) == 0 ||
                            substr( $item['numero_cuenta'], strlen( $item['numero_cuenta'] ) - 3, 1 ) == 1
                        )
                    );
                };
                break;
            case 'interbank':
                $validator = function($item) {
                    return !(
                        (
                            (int) substr( $item['numero_cuenta'], 3, strlen($item['numero_cuenta']) - 1 ) >= 100000000
                        )
                    );
                };
                break;
            case 'bbva':
                $validator = function($item) {
                    return !(
                        (
                            strlen($item['numero_cuenta']) === 18 || strlen($item['numero_cuenta']) === 20
                        ) && (
                            substr($item['numero_cuenta'], 0, 4) === '0011'
                        )
                    );
                };
                break;
            case 'banbif':
                $validator = function($item) {
                    return !(
                        strlen($item['numero_cuenta']) >= 10 && strlen($item['numero_cuenta']) <= 20
                    );
                };
                break;
            case 'scotiabank':
                $validator = function($item) {
                    return !(
                        strlen($item['numero_cuenta']) === 10
                    );
                };
                break;
        }

        $errors = array_filter($arr, $validator);
        $result = array_values(array_map(fn($item) => [
            'key' => $item['rut'],
            'rut' => $item['rut'], 'mes' => $item['mes'], 'año' => $item['ano'], 'numero_cuenta' => $item['numero_cuenta']
        ], $errors));

        return [
            'message' => sizeof( $result ) === 0 ? 'Válido' : 'Hay ' . sizeof( $result ) . ' error(es) de validación',
            'amount' => sizeof( $result ),
            'errors' => $result,
        ];
    }
}
