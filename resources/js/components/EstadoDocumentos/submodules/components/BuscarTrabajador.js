import React, { useState } from 'react';
import Axios from 'axios';

import Modal from '../../../Modal';
import { Table } from 'antd';

export const BuscarTrabajador = ({ tipoDocumento }) => {

    const [rut, setRut] = useState('');
    const [trabajador, setTrabajador] = useState(null);
    const [documentos, setDocumentos] = useState([]);
    const [isVisible, setIsVisible] = useState(false);
    const [loading, setLoading] = useState(false);

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Periodo',
            dataIndex: 'periodo',
            render: (_, record) => `${record.mes} - ${record.ano}`
        },
        {
            title: 'Tipo',
            dataIndex: 'tipo_documento'
        },
        {
            title: 'Regimen',
            dataIndex: 'regimen'
        },
        {
            title: 'Fecha Carga',
            dataIndex: 'fecha_carga'
        },
        {
            title: 'Fecha Firma',
            dataIndex: 'fecha_firma'
        },
        {
            title: 'Estado',
            dataIndex: 'estado'
        }
    ]

    const handleSubmit = e => {
        e.preventDefault();

        setLoading(true);
        fetchTrabajador();
    }

    const fetchTrabajador = () => {
        Axios.get(`http://192.168.60.16/api/trabajador/${rut}?activo=false`)
            .then(res => {
                console.log(res);

                const { trabajador } = res.data.data;
                setTrabajador(trabajador);

                fetchDocumentos();
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
            })
    }

    const fetchDocumentos = () => {
        Axios.get(`/api/documentos-turecibo/${rut}?tipo_documento_turecibo_id=${tipoDocumento.id}`)
            .then(res => {
                console.log(res);

                setDocumentos(res.data);
                setIsVisible(true);
                setLoading(false);
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
            })
    }

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="row">
                    <div className="input-group mb-3 col">
                        {!loading ? (
                            <>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="_rut"
                                    autoComplete="off"
                                    placeholder="Consultar por RUT"
                                    value={rut}
                                    onChange={e => setRut(e.target.value)}
                                />
                                <div className="input-group-append">
                                    <button className="btn btn-primary" type="submit" disabled={(rut.length < 8 || rut.length > 11)}>
                                        <i className="fas fa-search" />
                                    </button>
                                </div>
                            </>
                        ) : (
                            <div className="spinner-grow text-primary" role="status">
                                <span className="sr-only">Cargando...</span>
                            </div>
                        )}
                    </div>
                </div>
            </form>
            <Modal
                isVisible={isVisible}
                setIsVisible={setIsVisible}
                title="Detalle Trabajador"
                width={800}
            >
                <form>
                    <div className="form-row">
                        <div className="col">
                            Nombre Completo: <br />
                            <input
                                className="form-control" readOnly={true}
                                value={`${trabajador?.apellido_paterno || ''} ${trabajador?.apellido_materno || ''} ${trabajador?.nombre || ''}`}
                            />
                        </div>
                    </div>
                </form>
                <br />
                <Table
                    columns={columns} size="small"
                    dataSource={documentos}
                />
            </Modal>
        </>
    );
}
