@extends('pages.cuentas')

@section('tabla')
@if (!isset($data['cuenta']))
    <div class="pt2">
        <h4>Registros</h4>
        <br />
        <div id="tabla-cuentas-admin"></div>
    </div>
@endif
@endsection

