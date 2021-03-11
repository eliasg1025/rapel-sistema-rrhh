import React from 'react';
import { Table } from 'antd';

export const TablaRegistros = () => {

    const columns = [
        {
            title: 'Fecha',
            dataIndex: 'fecha_planilla',
        },
        {
            title: 'DNI',
            dataIndex: 'rut',
        },
        {
            title: 'Trabajador',
            dataIndex: 'trabajador',
        },
        {
            title: 'Hora Entrada',
            dataIndex: 'hora_entrada',
        },
        {
            title: 'Hora Salida',
            dataIndex: 'hora_salida'
        },
        {
            title: 'Motivo',
            dataIndex: 'motivo'
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones'
        }
    ];

    return (
        <>
            <Table
                bordered
                size="small"
                scroll={{ x: 1000 }}
                columns={columns}
            />
        </>
    );
}
