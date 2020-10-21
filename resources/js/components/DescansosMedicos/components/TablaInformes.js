import React from 'react';

import { Table, Tag } from 'antd';

const columns = [
    {
        title: 'Informe',
        dataIndex: 'informe'
    },
    {
        title: 'Empresa',
        dataIndex: 'empresa'
    },
    {
        title: 'Fecha Informe',
        dataIndex: 'fecha_inicio'
    },
    {
        title: '# Descansos',
        dataIndex: 'cantidad_registros',
        render: (_, record) => record.cantidad_registros ? record.cantidad_registros : 0,
    },
    {
        title: 'Estado',
        dataIndex: 'estado',
        render: (_, record) => renderTag(_)
    },
    {
        title: 'Acciones',
        dataIndex: 'acciones',
        render: (_, record) => {
            return (
                <div className="btn-group">
                    <button type="button" className="btn btn-primary btn-sm" onClick={() => redirectToDetail(record.id)}>
                        <i className="fas fa-edit"></i>
                    </button>
                    <a type="button" className="btn btn-primary btn-sm" target="_blank" href={`/ficha/descanso-medico/${record.id}`}>
                        <i className="fas fa-file-alt"></i>
                    </a>
                </div>
            );
        }
    }
];

const redirectToDetail = (id) => {
    window.location.replace(`/descansos-medicos/registrar-informes/${id}`);
};

const renderTag = estado => {
    switch (estado) {
        case 0:
            return <Tag color="processing">PENDIENTE</Tag>

        default:
            return <Tag color="success">ENVIADO</Tag>
    }
}

export const TablaInformes = ({ informes }) => {
    return (
        <Table
            size="small"
            columns={columns}
            dataSource={informes}
            bordered
        />
    );
}
