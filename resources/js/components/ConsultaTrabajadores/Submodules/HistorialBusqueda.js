import React, { useState, useEffect } from 'react';
import { Table, Tag } from 'antd';
import Axios from 'axios';

const columns = [
    {
        title: 'Fecha y hora',
        dataIndex: 'created_at',
    },
    {
        title: 'RUT buscado',
        dataIndex: 'rut',
    },
    {
        title: 'Activo',
        dataIndex: 'activo'
    },
    {
        title: 'Usuario',
        dataIndex: 'usuario',
    }
];

export const HistorialBusqueda = () => {

    const [consultas, setConsultas] = useState([]);

    useEffect(() => {
        Axios.get('/api/consulta-trabajador')
            .then(res => {
                setConsultas(res.data.map(c => {
                    return {
                        ...c,
                        key: c.id,
                        activo: c.activo ? <Tag color="warning">ACTIVO</Tag> : <Tag color="default">NO ACTIVO</Tag>
                    }
                }));
            })
            .catch(err => console.error(err));
    }, []);

    return (
        <>
            <h4>Historial</h4>
            <br />
            <div className="row">
                <div className="col">
                    <Table
                        columns={columns} dataSource={consultas} size="small"
                        scroll={{ x: 1300 }}
                    />
                </div>
            </div>
        </>
    );
}
