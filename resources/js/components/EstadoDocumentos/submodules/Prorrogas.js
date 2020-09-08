import React from 'react';
import { ImportarDocumentos, TablaDocumentos } from './components'

export const Prorrogas = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <>
            <h4>Prórrogas <small>{usuario.estado_documentos === 2 ? '(Administrador)' : ''}</small></h4>
            <br />
            {usuario.estado_documentos === 2 && (
                <div className="row">
                    <div className="col">
                        <ImportarDocumentos
                            tipoDocumento="PRORROGAS DE CONTRATO"
                        />
                    </div>
                </div>
            )}
            <hr />
            <br />
            <h6>Pendientes</h6>
            <TablaDocumentos />
        </>
    );
}
