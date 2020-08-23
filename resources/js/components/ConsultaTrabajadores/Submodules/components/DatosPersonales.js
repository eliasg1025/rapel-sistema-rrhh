import React from 'react';

export const DatosPersonales = ({ trabajador }) => {

    const handleSubmit = e => {
        e.preventDefault();

    }

    return (
        <div className="card">
            <div className="card-body">
                <form onSubmit={handleSubmit}>
                    <div className="form-group">
                        RUT:<br />
                        <input
                            type="text" placeholder="RUT" className="form-control"
                            value={trabajador?.rut || ''} readOnly={true}
                        />
                    </div>
                    <div className="form-group">
                        Nombre y Apellidos:<br />
                        <input
                            type="text" placeholder="Nombre y Apellidos" className="form-control"
                            value={trabajador ? `${trabajador.nombre} ${trabajador.apellido_paterno} ${trabajador.apellido_materno}` : ''}
                            readOnly={true}
                        />
                    </div>
                    <div className="form-row">
                        <div className="col-md-6 col-sm-6">
                            <div className="form-group">
                                Fecha Nacimiento:<br />
                                <input
                                    type="date" className="form-control"
                                    value={trabajador?.fecha_nacimiento || ''}
                                    readOnly={true}
                                />
                            </div>
                        </div>
                        <div className="col-md-6 col-sm-6">
                            <div className="form-group">
                                Edad:<br />
                                <input
                                    type="number" className="form-control"
                                    value={trabajador?.edad || 0}
                                    readOnly={true}
                                />
                            </div>
                        </div>
                    </div>
                    <div className="form-group">
                        Dirección<br />
                        <input
                            type="text" placeholder="Dirección" className="form-control"
                            value={trabajador?.direccion || ''}
                            readOnly={true}
                        />
                    </div>
                    <div className="form-row">
                        <div className="col-md-3 col-sm-3">
                            <div className="form-group">
                                Sexo:<br />
                                <input
                                    type="text" className="form-control"
                                    value={trabajador?.sexo || ''}
                                    readOnly={true}
                                />
                            </div>
                        </div>
                        <div className="col-md-3 col-sm-3">
                            <div className="form-group">
                                Estado Civil:<br />
                                <input
                                    type="text" className="form-control"
                                    value={trabajador?.estado_civil || ''}
                                    readOnly={true}
                                />
                            </div>
                        </div>
                        <div className="col-md-6 col-sm-6">
                            <div className="form-group">
                                Nacionalidad:<br />
                                <input
                                    type="text" className="form-control"
                                    value={trabajador?.nacionalidad || ''}
                                    readOnly={true}
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
}
