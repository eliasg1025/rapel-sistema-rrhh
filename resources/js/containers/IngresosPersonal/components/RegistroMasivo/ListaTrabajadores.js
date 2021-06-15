import React from 'react';
import { Button, Modal, Table, Tooltip, message, Tag } from 'antd';
import { DeleteOutlined, EditOutlined } from '@ant-design/icons';

const ListaTrabajadores = props => {

    const eliminarTrabajador = trabajador => {
        const { dispatchNewTrabajadores } = props;
        Modal.confirm({
            title: 'Eliminar registro',
            content: `¿Está seguro que desea eliminar a ${trabajador.rut}?`,
            okText: 'Eliminar',
            okType: 'danger',
            cancelText: 'Cancelar',
            onOk() {
                dispatchNewTrabajadores({
                    type: 'remove',
                    value: {
                        trabajador,
                    }
                })
                message['success']({
                    content: `Trabajador ${trabajador.rut} eliminado`
                });
            },
        });
    };

    const columns = [
        {
            title: 'RUT',
            dataIndex: 'rut',
            key: 'rut',
        },
        {
            title: 'Grupo',
            dataIndex: 'grupo',
            key: 'grupo',
        },
        {
            title: 'Fecha Ingreso',
            dataIndex: 'fecha_ingreso',
            key: 'fecha_ingreso',
            responsive: ['md'],
        },
        {
            title: 'Estado',
            dataIndex: 'estado',
            render: (value) => <Tag color={value.color}>{ value.descripcion }</Tag>
        },
        {
            title: 'Resultado',
            dataIndex: 'resultado'
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            responsive: ['lg'],
            render: (_, record) => (
                <Button.Group>
                    <Tooltip title="Borrar">
                        <Button
                            type="danger"
                            size="small"
                            onClick={() => eliminarTrabajador(record)}
                        >
                            <DeleteOutlined />
                        </Button>
                    </Tooltip>
                </Button.Group>
            ),
        },
    ];

    return (
        <Table
            size="small"
            loading={props.loading}
            columns={columns}
            dataSource={props.newTrabajadores}
        />
    );
}

export default ListaTrabajadores;
