import React, { useState, useEffect } from 'react';
import { Table, Tag } from 'antd';
import { CheckCircleOutlined, SyncOutlined, CloseCircleOutlined, ClockCircleOutlined } from '@ant-design/icons';
import Axios from 'axios';

export const Rechazos = () => {
    const [rechazos, setRechazos] = useState(false);

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
        }
    ];

    useEffect(() => {
        Axios.get(`/api/pagos/get-rechazados?empresa_id=${9}`)
            .then(res => {
                setRechazos(res.data.map(item => {
                    return {
                        ...item,
                        key: item._id
                    }
                }));
            })
            .catch(err => {
                console.error(err);
            })
    }, []);

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
        </>
    );
}
