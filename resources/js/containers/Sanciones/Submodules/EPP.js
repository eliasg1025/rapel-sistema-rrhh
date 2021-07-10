import React from 'react';
import { Card, Table } from 'antd';

export const EPP = () => {

    const columns = [
        {
            title: 'RUR',
            dataIndex: 'rut',
        },
        {
            title: 'Nombre',
            dataIndex: 'trabajador',
        },
        {
            title: 'Regimen',
            dataIndex: 'regimen'
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor'
        },
    ];

    return (
        <>
            <div className="mb-3">
                <h4>EPP</h4>
            </div>
            <br />
            <Card>
                hi
            </Card>
            <br />
            <Table
                columns={columns}
            />
        </>
    );
}
