@extends('pages.cuentas')

@section('tabla')
@if (!isset($data['cuenta']))
    <div class="pt-2">
        <div id="tabla-cuentas"></div>
    </div>
@endif
@endsection
