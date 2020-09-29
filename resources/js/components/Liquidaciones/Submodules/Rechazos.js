import React, { useState, useEffect } from 'react';
import { Table } from 'antd';
import Axios from 'axios';

export const Rechazos = () => {
    const [rechazos, setRechazos] = useState(false);

    const columns = [
        {
            title: 'Tipo Pago',
            dataIndex: 'tipo_pago'
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'RUT',
            dataIndex: 'rut'
        },
        {
            title: 'Nombre Completo',
            dataIndex: 'nombre_completo',
            render: (_, record) => `${record.apellido_paterno} ${record.apellido_materno} ${record.nombre}`
        },
        {
            title: 'Fecha Pago',
            dataIndex: 'fecha_pago'
        },
        {
            title: 'Banco',
            dataIndex: 'banco'
        },
        {
            title: 'Número Cuenta',
            dataIndex: 'numero_cuenta'
        },
        {
            title: 'Monto',
            dataIndex: 'monto'
        },
        {
            title: 'Estado',
            dataIndex: 'estado',
            render: (value, record) => `hi`
        }
    ];

    useEffect(() => {
        Axios.get(`/api/pagos/get-rechazados?empresa_id=${9}`)
            .then(res => {
                setRechazos(res.data);
            })
            .catch(err => {
                console.error(err);
            })
    }, []);

    return (
        <>
            <h4>Historial Rechazos</h4>
            <br />
            <Table
                columns={columns} scroll={{ x: 500 }}
                dataSource={rechazos}
                size="small"
            />
        </>
    );
}
