import React, { useState, useEffect } from 'react';
import { Table, Button, Modal, message } from 'antd';
import Axios from 'axios';
import moment from 'moment';

export const Historial = ({ bono, reload, setReload }) => {

    const [cargasBonos, setCargasBonos] = useState([]);

    useEffect(() => {
        Axios.get(`/api/cargas-bonos?bono_id=${bono.id}`)
            .then(res => {
                setCargasBonos(res.data.data.map(item => {
                    return {
                        ...item,
                        key: item.id
                    }
                }));
            })
            .catch(err => {
                console.error(err);
            });
    }, [reload]);

    const confirmDelete = id => {
        Modal.confirm({
            title: "Eliminar",
            content: "¿Desea eliminar este registro?",
            okText: "Si, Eliminar",
            cancelText: "Cancelar",
            onOk: () => deleteRecord(id)
        });
    }

    const deleteRecord = id => {
        
        Axios.delete(`/api/cargas-bonos/${id}`)
            .then(res => {
                // console.log(res);
                message['success']({
                    content: res.data.message
                });
                setReload(!reload);
            })
            .catch(err => {
                console.log(err);
            });
    }

    const columns = [
        {
            title: 'Nombre',
            dataIndex: 'name'
        },
        {
            title: 'Generado',
            dataIndex: 'updated_at',
            render: (_, value) => moment(_).format('DD/MM/YYYY hh:mm:ss')
        },
        {
            title: 'Ver',
            dataIndex: 'link',
            render: (_, value) => (
                <>
                    <a href={`/storage${value.link}`} className="btn btn-primary" target="_blank">
                        <i className="fas fa-download"></i>
                    </a>
                    <button className="btn btn-danger" onClick={() => confirmDelete(value.id)}>
                        <i className="fas fa-trash-alt"></i>
                    </button>
                </>
            )
        }
    ];

    return (
        <>
            <Table
                size="small"
                columns={columns}
                dataSource={cargasBonos}
            />
        </>
    );
}
