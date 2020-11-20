import React, { useState, useEffect } from 'react';

import { Button, Table, Tooltip } from 'antd';
import Axios from 'axios';

export const TablaGrupo = ({ reload }) => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const [grupos, setGrupos] = useState([]);
    const [loading, setLoading] = useState(false);

    const columns = [
        {
            title: 'Código',
            dataIndex: 'id'
        },
        {
            title: 'Fecha Finiquito',
            dataIndex: 'fecha_finiquito'
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor'
        },
        {
            title: 'Ruta',
            dataIndex: 'ruta'
        },
        {
            title: 'Código Bus',
            dataIndex: 'codigo_bus'
        },
        {
            title: 'Creado Por',
            dataIndex: 'usuario',
            render: (_, value) => `${_.username}`
        },
        {
            title: 'Estado',
            dataIndex: 'estado'
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (_, value) => (
                <Button.Group
                    size="small"
                >
                    <Tooltip title="Editar Informe">
                        <Button type="primary" onClick={e => redirectToDetail(value.id)}>
                            <i className="fas fa-edit"></i>
                        </Button>
                    </Tooltip>
                    <Tooltip title="Exportar Registros">
                        <Button type="success" style={{ backgroundColor: '#3FB618', borderColor: '#3FB618', color: 'white' }}>
                            <i className="fas fa-file-excel"></i>
                        </Button>
                    </Tooltip>
                    <Tooltip title="Anular Informe">
                        <Button type="danger">
                            <i className="fas fa-ban"></i>
                        </Button>
                    </Tooltip>
                </Button.Group>
            )
        },
    ];

    const redirectToDetail = (id) => {
        window.location.replace(`/finiquitos/${id}`);
    };

    useEffect(() => {
        setLoading(true);
        Axios.get(`/api/grupos-finiquitos?usuario_id=${usuario.id}`)
            .then(res => {
                setGrupos(res.data.data.map(item => {
                    return { ...item, key: item.id };
                }));
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => setLoading(false));
    }, [reload]);

    return (
        <Table
            bordered
            columns={columns}
            size="small"
            scroll={{ x: 1100 }}
            dataSource={grupos}
            loading={loading}
        />
    );
}
