import React from 'react';

export const InfoTrabajador = ({ trabajador }) => {
    return (
        <div className="card">
            <div className="card-body">
                <form>
                    <div className="form-row">
                        <div className="col-md-4">
                            RUT:<br />
                            <input
                                className="form-control"
                                value={trabajador?.rut || ''}
                                readOnly={true}
                            />
                        </div>
                        <div className="col-md-4">
                            Nombre Completo:<br />
                            <input
                                className="form-control"
                                value={`${trabajador?.apellido_paterno || ''} ${trabajador?.apellido_materno || ''} ${trabajador?.nombre || ''}`}
                                readOnly={true}
                            />
                        </div>
                    </div>
                    <div className="form-row">
                        <div className="col"></div>
                        <div className="col"></div>
                    </div>
                </form>
            </div>
        </div>
    );
}
