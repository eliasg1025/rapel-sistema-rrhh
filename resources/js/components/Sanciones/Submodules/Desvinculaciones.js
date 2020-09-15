import React from 'react';
import { Table } from 'antd';

export const Desvinculaciones = () => {

    const columns = [
        {
            title: 'Fecha Solicitud',
            dataIndex: 'fecha_solicitud'
        },
        {
            title: 'RUT',
            dataIndex: 'rut'
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Incidencia',
            dataIndex: 'incidencia'
        },
        {
            title: 'Fecha Incidencia',
            dataIndex: 'fecha_incidencia'
        },
        {
            title: 'Predio',
            dataIndex: 'predio'
        },
        {
            title: 'Observacion',
            dataIndex: 'observaciones'
        }
    ];

    return (
        <>
            <h4>Desvinculaciones</h4>
            <br />
            <Table
                columns={columns}
            />
        </>
    );
}
