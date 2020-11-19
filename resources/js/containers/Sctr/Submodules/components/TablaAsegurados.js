import React from 'react';
import { Table } from 'antd';

const columns = [
    {
        title: 'Apellido Paterno',
        dataIndex: 'apellido_paterno'
    },
    {
        title: 'Apellidos Materno',
        dataIndex: 'apellido_materno'
    },
    {
        title: 'Nombres',
        dataIndex: 'nombres'
    },
    {
        title: 'Sexo',
        dataIndex: 'sexo'
    },
    {
        title: 'Fecha Nac.',
        dataIndex: 'fecha_nacimiento',
    },
    {
        title: 'Tipo Doc.',
        dataIndex: 'tipo_documento'
    },
    {
        title: 'Número Doc.',
        dataIndex: 'rut'
    },
    {
        title: 'Cargo',
        dataIndex: 'cargo'
    },
    {
        title: 'Sueldo',
        dataIndex: 'sueldo'
    },
    {
        title: 'Fecha Ingreso',
        dataIndex: 'fecha_ingreso'
    }
];

export const TablaAsegurados = ({ asegurados }) => {
    return (
        <>
            <Table
                columns={columns} dataSource={asegurados} size="small"
                scroll={{ x: 800 }}
            />
        </>
    );
}
