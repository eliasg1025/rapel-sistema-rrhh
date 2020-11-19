import React, { useState } from 'react';
import { Card } from 'antd';

export const ResumenBono = ({ bono }) => {

    const [disableForm, setDisableForm] = useState(true);

    return (
        <>
            <Card>
                <h5 style={{ textDecoration: 'underline' }}>Resumen Bono</h5>
                <br />
                <div className="row">
                    <div className="col-md-4">
                        Nombre:<br />
                        <input
                            type="text"
                            className="form-control"
                            value={bono.name}
                            disabled={disableForm}
                        />
                    </div>
                    <div className="col-md-4">
                        Empresa:<br />
                        <input
                            type="text"
                            className="form-control"
                            value={bono.empresa.shortname}
                            disabled={disableForm}
                        />
                    </div>
                    <div className="col-md-4">
                        Cargado Por:<br />
                        <input
                            type="text"
                            className="form-control"
                            value={bono.usuario.username}
                            disabled={true}
                        />
                    </div>
                    <div className="col-md-12">
                        Descripción:<br />
                        <textarea
                            className="form-control"
                            value={bono.descripcion}
                            disabled={disableForm}
                        />
                    </div>
                </div>
            </Card>
        </>
    );
}
