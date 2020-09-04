import React, { useState } from 'react';
import { Table, Tag } from 'antd';
import { CheckCircleOutlined, SyncOutlined, CloseCircleOutlined, ClockCircleOutlined } from '@ant-design/icons';

const getColumns = (data, estado) => {

    const getFechasFirmado = liquidaciones => {
        const fechas_repetidas = liquidaciones.map(l => l.fecha_firmado);
        const fechas = new Set(fechas_repetidas);

        return Array.from(fechas).map(f => ({ text: f, value: f }));
    }

    switch ( parseInt(estado) ) {
        case 0:
            return [
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
                },
            ];

        case 1:
            return [
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
                    title: 'Fecha Firmado',
                    dataIndex: 'fecha_firmado',
                },
                {
                    title: 'Estado',
                    dataIndex: 'estado',
                    render: (_, record) => renderTags(record.estado)
                },
            ];

        case 2:
            return [
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
                    title: 'Fecha Firmado',
                    dataIndex: 'fecha_firmado',
                },
                {
                    title: 'Fecha Pago',
                    dataIndex: 'fecha_pago'
                },
                {
                    title: 'Banco',
                    dataIndex: 'banco',
                },
                {
                    title: 'Número Cuenta',
                    dataIndex: 'numero_cuenta'
                },
                {
                    title: 'Estado',
                    dataIndex: 'estado',
                    render: (_, record) => renderTags(record.estado)
                },
            ];

        case 3:
            return [
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
                    title: 'Fecha Firmado',
                    dataIndex: 'fecha_firmado',
                },
                {
                    title: 'Banco',
                    dataIndex: 'banco',
                },
                {
                    title: 'Número Cuenta',
                    dataIndex: 'numero_cuenta'
                },
                {
                    title: 'Estado',
                    dataIndex: 'estado',
                    render: (_, record) => renderTags(record.estado)
                },
            ];

        case 4:
            return [
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
                    title: 'Fecha Firmado',
                    dataIndex: 'fecha_firmado',
                },
                {
                    title: 'Estado',
                    dataIndex: 'estado',
                    render: (_, record) => renderTags(record.estado)
                },
            ];

        default:
            return [
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
                },
            ];
    }
}

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

export const TablaLU = ({ data, loading, estado }) => {
    const [selectedRowKeys , setSelectedRowKeys] = useState([]);
    const [all, setAll] = useState(false);

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

    const toggleSeleccionarTodos = () => {
        if (all) {
            setAll(false);
            setSelectedRowKeys([]);

            return;
        }

        const x = data.map(l => l.id);
        setAll(true);
        setSelectedRowKeys(x);
    }

    const rowSelection = {
        selectedRowKeys,
        onChange: onSelectChange,
    };
    const hasSelected = selectedRowKeys.length > 0;

    return (
        <Table
            columns={getColumns(data, estado)} dataSource={data} size="small" scroll={{ x: 500 }}
            pagination={{ pageSize: 20 }} loading={loading}
        />
    );
}
