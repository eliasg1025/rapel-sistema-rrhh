@extends('pages.cuentas')

@section('tabla')
<div class="pt-2">
    <h4>Registrados del {{ date('d/m/Y') }}</h4>
    <br />
    <div id="tabla-cuentas"></div>
</div>
@endsection
