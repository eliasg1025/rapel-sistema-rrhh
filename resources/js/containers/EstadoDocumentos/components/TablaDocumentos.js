import React from 'react';
import { Table, Tooltip, Spin } from 'antd';
import Swal from 'sweetalert2';
import Axios from 'axios';

export const TablaDocumentos = ({ data, reloadData, loading, banDocument }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const confirmBan = (id) => {
        Swal.fire({
            title: '¿Deseas anular este documento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, anularlo',
            cancelButtonText: 'Cancelar'
        })
            .then(res => {
                banDocument(id);
            })
            .catch(err => {
                console.error(err);
            });
    }

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Periodo',
            dataIndex: 'periodo',
        },
        {
            title: 'RUT',
            dataIndex: 'rut'
        },
        {
            title: 'Nombre Completo',
            dataIndex: 'nombre_completo'
        },
        {
            title: 'Regimen',
            dataIndex: 'regimen'
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor'
        },
        {
            title: 'Oficio',
            dataIndex: 'oficio'
        },
        {
            title: 'Estado',
            dataIndex: 'estado'
        },
        {
            title: 'Acciones',
            render: (_, record) => (
                <div className="btn-group">
                    {usuario.modulo_rol.tipo.name === 'ADMINISTRADOR' && (
                        <>
                            <Tooltip title="Anular documento">
                                <button className="btn btn-danger btn-sm" onClick={() => confirmBan(record.id)}>
                                    <i className="fas fa-ban"></i>
                                </button>
                            </Tooltip>
                        </>
                    )}
                </div>
            )
        }
    ];

    return (
        <Spin
            spinning={loading}
            tip="Obteniendo datos"
        >
            <Table
                columns={columns} dataSource={data} size="small"
                scroll={{ x: 500 }}
            />
        </Spin>
    );
}
