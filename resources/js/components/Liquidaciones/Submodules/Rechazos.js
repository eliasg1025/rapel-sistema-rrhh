import React, { useState, useEffect } from 'react';
import { Table, Tag, Tooltip } from 'antd';
import { CheckCircleOutlined, SyncOutlined, CloseCircleOutlined, ClockCircleOutlined } from '@ant-design/icons';
import Axios from 'axios';
import { ModalRepogramarPago } from '../components/ModalReprogramarPago';

export const Rechazos = () => {
    const [rechazos, setRechazos] = useState(false);
    const [isVisible, setIsVisible] = useState(false);
    const [pago, setPago] = useState(null);
    const [reloadData, setReloadData] = useState(false);

    const reprogramarPago = pago => {
        setPago(pago);
        setIsVisible(true);
    }

    const columns = [
        {
            title: 'Tipo Pago',
            dataIndex: 'tipo_pago'
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'RUT',
            dataIndex: 'rut'
        },
        {
            title: 'Nombre Completo',
            dataIndex: 'nombre_completo',
            render: (_, record) => `${record.apellido_paterno} ${record.apellido_materno} ${record.nombre}`
        },
        {
            title: 'Fecha Pago',
            dataIndex: 'fecha_pago'
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
            title: 'Monto',
            dataIndex: 'monto'
        },
        {
            title: 'Estado',
            dataIndex: 'estado',
            render: (_, record) => renderTags(record.estado)
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (_, record) => {
                return record.estado === 1 ? (
                    <Tooltip title="Reprogramar Fecha de Pago">
                        <button className="btn btn-light btn-sm" onClick={() => reprogramarPago(record)}>
                            <i className="far fa-clock"></i>
                        </button>
                    </Tooltip>
                ) : null
            }
        }
    ];

    useEffect(() => {
        Axios.get(`/api/pagos/get-rechazados?empresa_id=${9}`)
            .then(res => {
                setRechazos(res.data.map(item => {
                    return {
                        ...item,
                        id: item.liquidacion_id,
                        key: item._id
                    }
                }));
            })
            .catch(err => {
                console.error(err);
            })
    }, [reloadData]);

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

    return (
        <>
            <h4>Historial Rechazos</h4>
            <br />
            <Table
                columns={columns} scroll={{ x: 500 }}
                dataSource={rechazos}
                size="small"
            />
            <ModalRepogramarPago
                liquidacion={pago}
                isVisible={isVisible}
                setIsVisible={setIsVisible}
                reloadData={reloadData}
                setReloadData={setReloadData}
            />
        </>
    );
}
