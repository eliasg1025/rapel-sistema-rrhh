@extends('layout')

@section('titutlo')
    Cuentas | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5 text-center">
        <h3>Cuentas</h3>
        <div class="py-5">
            <form id="form-buscar-trabajador">
                <div class="row">
                    <div class="input-group mb-3 col">
                        <input type="text" class="form-control" name="_rut" id="_rut" placeholder="Buscar por RUT">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr />
            <form id="form-agregar-cuenta">
                <div class="row">
                    <div class="form-group col-md-4">
                        <input
                            type="date"
                            name="fecha_solicitud"
                            id="fecha_solicitud"
                            placeholder="Fecha solicitud"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            disabled
                        >
                    </div>
                    <div class="form-group col-md-4">
                        <select name="empresa_id" id="empresa_id" class="form-control" required>
                            <option disabled selected>Elige Empresa</option>
                            @foreach ($data['empresas'] as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->id }} - {{ $empresa->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" name="rut" id="rut" placeholder="DNI / RUT" class="form-control" disabled required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <input type="text" name="trabajador" id="trabajador" placeholder="Trabajador" class="form-control" disabled required>
                    </div>
                    <div class="form-group col-md-4">
                        <select name="banco_id" id="banco_id" class="form-control" required>
                            <option disabled selected>Elige Banco</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" name="numero_cuenta" id="numero_cuenta" placeholder="N° Cuenta" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary btn-block">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
        <hr />
        <div class="pt-2">
            <h4>Registrados del {{ date('d/m/Y') }}</h4>
            <br />
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha de solicitud</th>
                        <th>DNI</th>
                        <th>Trabajador</th>
                        <th>Banco</th>
                        <th>Cuenta</th>
                        <th>Empresa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['cuentas'] as $cuenta)
                        <tr>
                            <td>{{ $cuenta->fecha_solicitud }}</td>
                            <td>{{ $cuenta->trabajador->rut }}</td>
                            <td>{{ $cuenta->trabajador->name }}</td>
                            <td>{{ $cuenta->banco->name }}</td>
                            <td>{{ $cuenta->numero_cuenta }}</td>
                            <td>{{ $cuentas->empresa->id === 9 ? 'RAPEL' : 'VERFRUT' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const formAgregarCuenta = document.getElementById('form-agregar-cuenta');
        const formBuscarTrabajador = document.getElementById('form-buscar-trabajador');
        const selectEmpresa = document.getElementById('empresa_id');

        function validForm() {
            return document.getElementById('rut').value !== '' &&
                document.getElementById('trabajador').value !== '' &&
                document.getElementById('banco_id').value !== '' &&
                document.getElementById('empresa_id').value !== '' &&
                document.getElementById('numero_cuenta').value !== ''
        }

        formBuscarTrabajador.addEventListener('submit', e => {
            e.preventDefault();
            const _rut = document.getElementById('_rut').value;

            axios.get(`http://192.168.60.16/api/trabajador/${_rut}`)
                .then(res => {
                    const { trabajador, message } = res.data.data;

                    document.getElementById('rut').value = trabajador.rut;
                    document.getElementById('trabajador').value = `${trabajador.apellido_paterno} ${trabajador.apellido_materno}, ${trabajador.nombre}`;
                })
                .catch(err => console.log(err));
        });

        selectEmpresa.addEventListener('change', e => {
            const empresa_id = e.target.value;
            axios.get(`http://192.168.60.16/api/banco/${empresa_id}`)
                .then(res => {
                    const { data, message } = res.data;
                    let select = $('form select[name=banco_id]');
                    select.empty();
                    $.each(data, function(key, value) {
                        select.append(`<option ${value.id == '59' && 'selected'} value=${value.id}>${value.id} - ${value.name}</option>`);
                    });
                })
                .catch(err => console.log(err));
        });

        formAgregarCuenta.addEventListener('submit', e => {
            e.preventDefault();

            if (validForm()) {
                console.log(e.target)
                return;
            }
            console.log('invalid');
        });
    </script>
@endsection
