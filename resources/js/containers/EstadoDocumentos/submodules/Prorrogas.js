import React, { useState, useEffect } from 'react';
import Axios from 'axios';
import { message } from 'antd';

import { ImportarDocumentos, TablaDocumentos, FiltroTablaDocumentos, BuscarTrabajador, MostrarUltimaActualizacion } from '../components';

export const Prorrogas = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [reloadData, setReloadData] = useState(false);
    const [loading, setLoading] = useState(false);
    const [documentos, setDocumentos] = useState([]);
    const [filter, setFilter] = useState({
        empresa_id: 9,
        regimen_id: 1,
        zona_labor_id: usuario.estado_documentos === 2 ? '51' : '51',
        estado: 'NO FIRMADO'
    });

    useEffect(() => {
        let intentos = 0;
        function fetchTipoDocumentosTurecibo() {
            intentos++;
            setLoading(true);
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
                })
                .finally(() => setLoading(false));
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
            'Oficio',
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
                oficio: d.oficio,
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

    const banDocument = (id) => {
        Axios.put(`/api/documentos-turecibo/${id}`, {
            'estado': 'ANULADO'
        })
            .then(res => {
                console.log(res);
                setReloadData(!reloadData);
            })
            .catch(err => {
                console.error(err);
            });
    }

    return (
        <>
            <MostrarUltimaActualizacion />
            <h4>Prórrogas <small>{usuario.estado_documentos === 2 ? '(Administrador)' : ''}</small></h4>
            <br />
            <div className="row">
                <div className="col-md-6 col-sm-12">
                    <BuscarTrabajador
                        tipoDocumento={{ name: "PRORROGAS DE CONTRATO", id: 1 }}
                    />
                </div>
                <div className="col-md-3 col-sm-12">
                    {usuario.estado_documentos === 2 && (
                        <ImportarDocumentos
                            tipoDocumento={{ name: "PRORROGAS DE CONTRATO", id: 1 }}
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
                banDocument={banDocument}
                loading={loading}
                data={documentos}
            />
        </>
    );
}
