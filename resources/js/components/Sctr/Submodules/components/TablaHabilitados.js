import React from 'react';
import { Table } from 'antd';

export const TablaHabilitados = ({ columns, data }) => {
    return (
        <>
            <Table
                columns={columns} dataSource={data} size="small"
            />
        </>
    );
}
