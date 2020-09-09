import React, { useState, useEffect } from 'react';

import { ImportarDocumentos, TablaDocumentos, FiltroTablaDocumentos } from './components'
import Axios from 'axios';
import { message } from 'antd';

export const Boletas = () => {
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
            Axios.get(`
                /api/documentos-turecibo?tipo_documento_turecibo_id=${2}&empresa_id=${filter.empresa_id}&estado=${filter.estado}&regimen_id=${filter.regimen_id}&zona_labor_id=${filter.zona_labor_id}
            `)
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
            <h4>Boletas <small>{usuario.estado_documentos === 2 ? '(Administrador)' : ''}</small></h4>
            <br />
            <div className="row">
                <div className="col">
                    {usuario.estado_documentos === 2 && (
                        <ImportarDocumentos
                            tipoDocumento={{ name: "BOLETA MENSUAL", id: 2 }}
                            reloadData={reloadData}
                            setReloadData={setReloadData}
                            loading={loading}
                            setLoading={setLoading}
                        />
                    )}
                </div>
            </div>
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
