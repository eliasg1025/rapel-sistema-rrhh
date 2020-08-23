import React from 'react';
import { Table } from 'antd';

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
        title: 'Sueldo',
        dataIndex: 'sueldo'
    },
    {
        title: 'Inciso',
        dataIndex: 'inciso'
    }
];

export const Periodos = ({ periodos }) => {
    return (
        <Table
            rowClassName={(record, index) => record.indicador_vigencia == 1 && 'table-row-red'}
            columns={columns} dataSource={periodos} size="small"
            scroll={{ x: 1300 }}
        />
    );
}
