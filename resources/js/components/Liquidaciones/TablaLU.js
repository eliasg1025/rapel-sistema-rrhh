import React, { useState, useEffect } from 'react';
import { Table, Tag } from 'antd';
import { CheckCircleOutlined, SyncOutlined, CloseCircleOutlined, ClockCircleOutlined } from '@ant-design/icons';

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
        dataIndex: 'estado',
        render: (_, record) => renderTags(record.estado)
    }
];

function renderTags(estado) {
    switch (estado) {
        case 0:
            return <Tag color="default" icon={<ClockCircleOutlined />}>PENDIENTE</Tag>;
        case 1:
            return <Tag color="warning" icon={<ClockCircleOutlined />}>FIRMADO</Tag>;
        case 2:
            return <Tag color="processing" icon={<SyncOutlined spin/>}>PARA PAGO</Tag>;
        case 3:
            return <Tag color="success" icon={<CheckCircleOutlined />}>PAGADO</Tag>;
        case 4:
            return <Tag color="error" icon={<CloseCircleOutlined />}>RECHAZADO</Tag>;
        default:
            return null;
    }
}

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
                {hasSelected && (
                    <button className="btn btn-primary" disabled={!hasSelected || loading} onClick={reload}>
                        {loading ? (
                            <>
                                <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span className="sr-only">Loading...</span>
                            </>
                        ) : 'Para Pago'}
                    </button>
                )}
                <span style={{ marginLeft: 8 }}>
                    {hasSelected ? `${selectedRowKeys.length} item(s) seleccionados` : ''}
                </span>
            </div>
            <Table rowSelection={rowSelection} columns={columns} dataSource={data} />
        </div>
    );
}
