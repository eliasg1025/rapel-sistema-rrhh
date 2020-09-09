import React, { useState, useEffect } from 'react';
import Axios from 'axios';
import { message } from 'antd';

import { ImportarDocumentos, TablaDocumentos, FiltroTablaDocumentos } from './components';

export const Prorrogas = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [reloadData, setReloadData] = useState(false);
    const [loading, setLoading] = useState(false);
    const [documentos, setDocumentos] = useState([]);
    const [filter, setFilter] = useState({
        empresa_id: 9,
        regimen_id: 1,
        zona_labor_id: 0,
        estado: 'NO FIRMADO'
    });

    useEffect(() => {
        let intentos = 0;
        function fetchTipoDocumentosTurecibo() {
            intentos++;
            Axios.get(`/api/documentos-turecibo?tipo_documento_turecibo_id=${1}&empresa_id=${filter.empresa_id}&estado=${filter.estado}&regimen_id=${filter.regimen_id}&zona_labor_id=${filter.zona_labor_id}`)
                .then(res => {
                    console.log(res);

                    message['success']({
                        content: `Se encontraton ${res.data.length} registros`
                    });

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
    }, [filter, reloadData])

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
            <FiltroTablaDocumentos
                reloadData={reloadData}
                setReloadData={setReloadData}
                filter={filter}
                setFilter={setFilter}
            />
            <br />
            <TablaDocumentos
                reloadData={reloadData}
                loading={loading}
                data={documentos}
            />
        </>
    );
}
