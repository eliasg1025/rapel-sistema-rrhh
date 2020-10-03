import React from 'react';
import { Table, Tag } from 'antd';
import { CheckCircleOutlined, SyncOutlined, CloseCircleOutlined, ClockCircleOutlined } from '@ant-design/icons';

export const TablaConsulta = ({ data, loading }) => {

    const columns = [
        {
            title: 'Tipo',
            dataIndex: 'tipo_pago'
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Periodo',
            dataIndex: 'periodo',
            render: (_, record) => `${record.mes} -  ${record.ano}`
        },
        {
            title: 'Monto',
            dataIndex: 'monto'
        },
        {
            title: 'Fecha Firmado',
            dataIndex: 'fecha_firmado'
        },
        {
            title: 'Fecha Pago',
            dataIndex: 'fecha_pago',
        },
        {
            title: 'Banco',
            dataIndex: 'banco'
        },
        {
            title: 'Número Cuenta',
            dataIndex: 'numero_cuenta'
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
            case 5:
                return <Tag color="success" icon={<CheckCircleOutlined />}>PAGADO</Tag>;
            default:
                return null;
        }
    }

    return (
        <>
            <h5>Pagos</h5>
            <Table
                columns={columns}
                size="small"
                dataSource={data}
                bordered
                loading={loading}
            />
        </>
    );
}
