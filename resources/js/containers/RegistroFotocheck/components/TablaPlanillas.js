import React from 'react';
import { Table, Tag } from 'antd';

export const TablaPlanillas = ({ data, loading }) => {

    const columns = [
        {
            title: "Fecha",
            dataIndex: "fecha_solicitud",
        },
        {
            title: 'DNI',
            dataIndex: 'trabajador',
            render: item => item?.rut
        },
        {
            title: 'Trabajador',
            dataIndex: 'trabajador',
            render: item =>
                item?.apellido_paterno +
                " " +
                item?.apellido_materno +
                " " +
                item?.nombre
        },
        {
            title: 'Fecha Inicio',
            dataIndex: 'fecha_inicio'
        },
        {
            title: 'Fecha Fin',
            dataIndex: 'fecha_fin'
        },
        {
            title: 'Horas',
            dataIndex: 'horas',
        },
        {
            title: "Estado",
            dataIndex: "estado",
            render: item => (item === 0 ? <Tag color="blue">GENERADO</Tag> : <Tag color="green">ENVIADO</Tag>)
        },
        {
            title: 'Acciones',
            dataIndex: 'id',
            render: (id, record) => (
                <button className="btn btn-primary btn-sm">
                    <i className="fas fa-edit"></i>
                </button>
            )
        }
    ];

    return (
        <Table
            size="small"
            bordered
            columns={columns}
            dataSource={data}
            loading={loading}
        />
    );
}
