import React, { useState, useEffect } from 'react';

import { ImportarDocumentos, TablaDocumentos, FiltroTablaDocumentos, BuscarTrabajador, MostrarUltimaActualizacion } from './components'
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
        zona_labor_id: usuario.estado_documentos === 2 ? 0 : '51',
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
    }, [filter, reloadData]);

    const exportar = () => {
        console.log(documentos);
        const headings = [
            'Empresa',
            'Periodo',
            'RUT',
            'Nombre Completo',
            'Regimen',
            'Zona Labor',
            'Estado'
        ];

        const data = documentos.map(d => {
            return {
                empresa: d.empresa,
                periodo: d.periodo,
                rut: d.rut,
                nombre_completo: d.nombre_completo,
                regimen: d.regimen,
                zona_labor: d.zona_labor,
                estado: d.estado
            }
        });

        Axios({
            url: '/descargar',
            data: {headings, data},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `${filter.estado}.xlsx`
                link.click();
            })
    }

    return (
        <>
            <MostrarUltimaActualizacion />
            <h4>Boletas <small>{usuario.estado_documentos === 2 ? '(Administrador)' : ''}</small></h4>
            <br />
            <div className="row">
                <div className="col-md-6 col-sm-12">
                    <BuscarTrabajador
                        tipoDocumento={{ name: "BOLETA MENSUAL", id: 2}}
                    />
                </div>
                <div className="col-md-3 col-sm-12">
                    {usuario.estado_documentos === 2 && (
                        <ImportarDocumentos
                            tipoDocumento={{ name: "BOLETA MENSUAL", id: 2 }}
                            reloadData={reloadData}
                            setReloadData={setReloadData}
                            loading={loading}
                            setLoading={setLoading}
                        />
                    )}
                    <button className="btn btn-success" onClick={() => exportar()}>
                        <i className="fas fa-file-export"></i> Exportar Registros
                    </button>
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
