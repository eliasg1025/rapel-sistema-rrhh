import React, { useState, useEffect } from 'react';
import Axios from 'axios';

import { ImportarDocumentos, TablaDocumentos } from './components';

export const Prorrogas = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [reloadData, setReloadData] = useState(false);
    const [loading, setLoading] = useState(false);
    const [documentos, setDocumentos] = useState([]);

    useEffect(() => {
        let intentos = 0;
        function fetchTipoDocumentosTurecibo() {
            intentos++;
            Axios.get(`/api/documentos-turecibo?tipo_documento_turecibo_id=${1}`)
                .then(res => {
                    console.log(res);
                    setDocumentos(res.data);
                })
                .catch(err => {
                    console.error(err);

                    if (intentos < 5) {
                        fetchTipoDocumentosTurecibo();
                    }
                });
        }

        fetchTipoDocumentosTurecibo();
    }, [])

    return (
        <>
            <h4>Prórrogas <small>{usuario.estado_documentos === 2 ? '(Administrador)' : ''}</small></h4>
            <br />
            {usuario.estado_documentos === 2 && (
                <div className="row">
                    <div className="col">
                        <ImportarDocumentos
                            tipoDocumento={{ name: "PRORROGAS DE CONTRATO", id: 1 }}
                            reloadData={reloadData}
                            setReloadData={setReloadData}
                            loading={loading}
                            setLoading={setLoading}
                        />
                    </div>
                </div>
            )}
            <hr />
            <br />
            <h6><i className="fas fa-user-clock"></i>&nbsp;Pendientes</h6>
            <TablaDocumentos
                reloadData={reloadData}
                loading={loading}
                data={documentos}
            />
        </>
    );
}
