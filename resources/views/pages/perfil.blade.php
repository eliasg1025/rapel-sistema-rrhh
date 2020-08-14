@extends('layout')

@section('titulo')
    Mi Perfil | Grupo Verfrut
@endsection

@section('contenido')
    <div class="container p-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $data['usuario']->trabajador->nombre_completo }}<br /><small>{{ $data['usuario']->username }}</small></h3>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#cambiarContra">
                            Cambiar contraseña
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="text-center">
                    <h3>Estadísticas</h3>
                    <br />
                    <div id="estadisticas-usuarios"></div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="cambiarContra">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cambiar contraseña</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            @csrf
                            <div class="form-group">
                                Nueva Contraseña:<br />
                                <input type="password" class="form-control" />
                            </div>
                            <div class="form-group">
                                Repetir Contraseña:<br />
                                <input type="password" class="form-control" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary">Cancel</button>
                        <button class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
