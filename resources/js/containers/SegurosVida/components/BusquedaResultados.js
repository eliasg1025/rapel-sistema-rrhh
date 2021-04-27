import React from 'react';
import moment from 'moment';
import { Table } from 'antd';

export const BusquedaResultados = ({ dataSource, loading }) => {

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa',
            render: (value) => value.name
        },
        {
            title: 'DNI',
            dataIndex: 'trabajador',
            render: (value) => value.rut
        },
        {
            title: 'Apellidos y Nombres',
            dataIndex: 'trabajador',
            render: (value) => `${value.apellido_paterno} ${value.apellido_materno} ${value.nombre}`
        },
        {
            title: 'Fecha registro',
            dataIndex: 'created_at',
            render: (value) => moment(value).format('YYYY-MM-DD hh:mm A').toString(),
        },
    ];

    return (
        <>
            <Table
                size="small"
                bordered
                dataSource={dataSource}
                loading={loading}
                columns={columns}
            />
        </>
    );
}
