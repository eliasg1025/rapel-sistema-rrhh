import React, { useState } from 'react';
import { Table, Tag, Tooltip } from 'antd';
import Modal from '../Modal';
import { CheckCircleOutlined, SyncOutlined, CloseCircleOutlined, ClockCircleOutlined } from '@ant-design/icons';
import { ModalRepogramarPago } from './components/ModalReprogramarPago';

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

export const TablaLU = ({ data, loading, estado, reloadData, setReloadData }) => {
    const [selectedRowKeys , setSelectedRowKeys] = useState([]);
    const [all, setAll] = useState(false);
    const [isVisible, setIsVisible] = useState(false);
    const [liquidacion, setLiquidacion] = useState(null);

    const reprogramarPago = liquidacion => {
        setLiquidacion(liquidacion);
        setIsVisible(true);
    }

    const getColumns = (data, estado) => {
        switch ( parseInt(estado) ) {
            case 0:
                return [
                    {
                        title: 'Tipo',
                        dataIndex: 'tipo_pago'
                    },
                    {
                        title: 'Empresa',
                        dataIndex: 'empresa',
                    },
                    {
                        title: 'RUT',
                        dataIndex: 'rut',
                    },
                    {
                        title: 'Nombre Completo',
                        dataIndex: 'nombre_completo',
                        render: (_, record) => `${record.apellido_paterno} ${record.apellido_materno} ${record.nombre}`
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
                        title: 'Tipo',
                        dataIndex: 'tipo_pago'
                    },
                    {
                        title: 'Empresa',
                        dataIndex: 'empresa',
                    },
                    {
                        title: 'RUT',
                        dataIndex: 'rut',
                    },
                    {
                        title: 'Nombre Completo',
                        dataIndex: 'nombre_completo',
                        render: (_, record) => `${record.apellido_paterno} ${record.apellido_materno} ${record.nombre}`
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
                        title: 'Tipo',
                        dataIndex: 'tipo_pago'
                    },
                    {
                        title: 'Empresa',
                        dataIndex: 'empresa',
                    },
                    {
                        title: 'RUT',
                        dataIndex: 'rut',
                    },
                    {
                        title: 'Nombre Completo',
                        dataIndex: 'nombre_completo',
                        render: (_, record) => `${record.apellido_paterno} ${record.apellido_materno} ${record.nombre}`
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
                    {
                        title: 'Acciones',
                        dataIndex: 'acciones',
                        render: (value, record) => (
                            <Tooltip title="Reprogramar Fecha de Pago">
                                <button className="btn btn-light btn-sm" onClick={() => reprogramarPago(record)}>
                                    <i className="far fa-clock"></i>
                                </button>
                            </Tooltip>
                        )
                    }
                ];

            case 3:
                return [
                    {
                        title: 'Tipo',
                        dataIndex: 'tipo_pago'
                    },
                    {
                        title: 'Empresa',
                        dataIndex: 'empresa',
                    },
                    {
                        title: 'RUT',
                        dataIndex: 'rut',
                    },
                    {
                        title: 'Nombre Completo',
                        dataIndex: 'nombre_completo',
                        render: (_, record) => `${record.apellido_paterno} ${record.apellido_materno} ${record.nombre}`
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
                        title: 'Tipo',
                        dataIndex: 'tipo_pago'
                    },
                    {
                        title: 'Empresa',
                        dataIndex: 'empresa',
                    },
                    {
                        title: 'RUT',
                        dataIndex: 'rut',
                    },
                    {
                        title: 'Nombre Completo',
                        dataIndex: 'nombre_completo',
                        render: (_, record) => `${record.apellido_paterno} ${record.apellido_materno} ${record.nombre}`
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
                        title: 'Tipo',
                        dataIndex: 'tipo_pago'
                    },
                    {
                        title: 'Empresa',
                        dataIndex: 'empresa',
                    },
                    {
                        title: 'RUT',
                        dataIndex: 'rut',
                    },
                    {
                        title: 'Nombre Completo',
                        dataIndex: 'nombre_completo',
                        render: (_, record) => `${record.apellido_paterno} ${record.apellido_materno} ${record.nombre}`
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
        <>
            <ModalRepogramarPago
                liquidacion={liquidacion}
                isVisible={isVisible}
                setIsVisible={setIsVisible}
                reloadData={reloadData}
                setReloadData={setReloadData}
            />
            <Table
                columns={getColumns(data, estado)} dataSource={data} size="small" scroll={{ x: 500 }}
                pagination={{ pageSize: 20 }} loading={loading}
                bordered
            />
        </>
    );
}
