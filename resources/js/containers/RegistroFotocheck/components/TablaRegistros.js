import React from 'react';
import { Table } from 'antd';

export const TablaRegistros = () => {

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa',
        },
        {
            title: 'Fecha',
            dataIndex: 'fecha'
        },
        {
            title: 'DNI',
            dataIndex: 'rut'
        },
        {
            title: 'Apellidos y Nombres',
            dataIndex: 'nombre_completo_trabajador'
        },
        {
            title: 'Régimen',
            dataIndex: 'regimen'
        },
        {
            title: 'Fundo',
            dataIndex: 'zona_labor'
        },
        {
            title: 'Solicitante',
            dataIndex: 'nombre_completo_usuario'
        },
        {
            title: 'Motivo',
            dataIndex: 'motivo',
        },
        {
            title: 'Costo',
            dataIndex: 'costo'
        },
        {
            title: 'Color',
            dataIndex: 'color'
        },
        {
            title: 'Observación',
            dataIndex: 'observacion'
        },
    ];

    return (
        <>
            <Table
                bordered
                columns={columns}
                dataSource={[]}
            />
        </>
    );
}
