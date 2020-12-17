import React, { useEffect, useState } from 'react';
import { notification, Table, Tooltip, Modal } from 'antd';
import Axios from 'axios';

export const TableUsuarioZona = ({ reload, setReload }) => {

    const [usuarios, setUsuarios] = useState([]);

    useEffect(() => {
        Axios.get('/api/grupos-finiquitos/usuarios-zonas')
            .then(res => {
                const { data, message } = res.data;

                setUsuarios(data.map(item => ({ ...item, key: item.usuario_id })));
            })
            .catch(err => {
                console.log(err);

                notification['error']({
                    message: 'Error al obtener los datos'
                });
            });
    }, [reload]);

    const confirmDelete = record => {
        Modal.confirm({
            title: "Borrar registro",
            content: "El registor ha sido borrado",
            okText: "Si, BORRAR",
            cancelText: "Cancelar",
            onOk: () => deleteRecord(record)
        });
    }

    const deleteRecord = record => {
        Axios.delete(`/api/grupos-finiquitos/usuarios-zonas/${record.usuario_id}/${record.zona_labor_id}`)
            .then(res => {
                const { data, message } = res.data;

                setReload(!reload);
                notification['success']({
                    message
                });
            })
            .catch(err => {
                console.error(err);

                notification['error']({
                    message: err.response.data.message
                });
            })
    }

    const columns = [
        {
            title: 'ID',
            dataIndex: 'usuario_id'
        },
        {
            title: 'Usuario',
            dataIndex: 'usuario',
            render: (item, record) => `${item.trabajador.apellido_paterno} ${item.trabajador.apellido_materno} ${item.trabajador.nombre}`
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor',
            render: (item, record) => item.name
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (item, record) => (
                <Tooltip title="Borrar registro">
                    <button className="btn btn-danger btn-sm" onClick={() => confirmDelete(record)}>
                        <i className="fas fa-trash"></i>
                    </button>
                </Tooltip>
            )
        }
    ];

    return (
        <Table
            size="small"
            bordered
            columns={columns}
            dataSource={usuarios}
        />
    );
}