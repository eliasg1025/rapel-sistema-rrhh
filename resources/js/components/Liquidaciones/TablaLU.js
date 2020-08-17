import React, { useState, useEffect } from 'react';
import { Table } from 'antd';

const columns = [
    {
        title: 'Empresa',
        dataIndex: 'empresa',
    },
    {
        title: 'RUT',
        dataIndex: 'rut',
    },
    {
        title: 'Mes',
        dataIndex: 'mes',
    },
    {
        title: 'Año',
        dataIndex: 'ano'
    },
    {
        title: 'Monto',
        dataIndex: 'monto'
    },
    {
        title: 'Estado',
        dataIndex: 'estado'
    }
];

export const TablaLU = ({ data }) => {
    const [selectedRowKeys , setSelectedRowKeys] = useState([]);
    const [loading, setLoading] = useState(false);

    const reload = () => {
        setLoading(true);
        setTimeout(() => {
            setSelectedRowKeys([]);
            setLoading(false);
        }, 1500)
    }

    const onSelectChange = selectedRowKeys => {
        console.log('selectedRowKeys changed: ', selectedRowKeys);
        setSelectedRowKeys(selectedRowKeys);
    };

    const rowSelection = {
        selectedRowKeys,
        onChange: onSelectChange,
    };
    const hasSelected = selectedRowKeys.length > 0;

    return (
        <div>
            <div style={{ marginBottom: 16 }}>
                <button className="btn btn-primary" disabled={!hasSelected || loading} onClick={reload}>
                    {loading ? (
                        <>
                            <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span className="sr-only">Loading...</span>
                        </>
                    ) : 'Para Pago'}
                </button>
                <span style={{ marginLeft: 8 }}>
                    {hasSelected ? `${selectedRowKeys.length} item(s) seleccionados` : ''}
                </span>
            </div>
            <Table rowSelection={rowSelection} columns={columns} dataSource={data} />
        </div>
    );
}
