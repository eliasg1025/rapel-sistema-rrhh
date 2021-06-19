import React from 'react';
import { Table } from 'antd';

const xd = JSON.parse(sessionStorage.getItem('data'));

// console.log(usuario);

const columns = [
    {
        title: 'Empresa',
        dataIndex: 'empresa',
    },
    {
        title: 'Periodo',
        dataIndex: 'periodo',
    },
    {
        title: 'Desde',
        dataIndex: 'desde',
    },
    {
        title: 'Hasta',
        dataIndex: 'hasta'
    },
    {
        title: 'Duración (meses)',
        dataIndex: 'meses'
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
        title: 'Inciso',
        dataIndex: 'inciso'
    },
];

if (xd?.usuario?.modulo_rol?.tipo?.name !== 'SIN SUELDO') {
    columns.push({
        title: 'Sueldo',
        dataIndex: 'sueldo'
    });
}

export const Periodos = ({ periodos }) => {
    return (
        <Table
            rowClassName={(record, index) => record.indicador_vigencia == 1 && 'table-row-red'}
            columns={columns} dataSource={periodos} size="small"
            scroll={{ x: 1000 }}
        />
    );
}
