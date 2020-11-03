import React from 'react';
import { Button, Modal, Table, Tooltip, message } from 'antd';
import { DeleteOutlined, EditOutlined } from '@ant-design/icons';

const ListaTrabajadores = props => {

    const eliminarTrabajador = rut => {
        const { trabajadores, setTrabajadores } = props;
        Modal.confirm({
            title: 'Eliminar registro',
            content: `¿Está seguro que desea eliminar a ${rut}?`,
            okText: 'Eliminar',
            okType: 'danger',
            cancelText: 'Cancelar',
            onOk() {
                const new_trab = trabajadores.filter(t => t.rut !== rut);
                setTrabajadores(new_trab);
                message['success']({
                    content: `Trabajador ${rut} eliminado`
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
            title: 'Acciones',
            dataIndex: 'acciones',
            responsive: ['lg'],
            render: (_, record) => (
                <Button.Group>
                    {/*
                    <Tooltip title="Editar">
                        <Button type="primary" onClick={console.log}>
                            <EditOutlined />
                        </Button>
                    </Tooltip>
                     */}
                    <Tooltip title="Borrar">
                        <Button
                            type="danger"
                            onClick={() => eliminarTrabajador(record.rut)}
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
            dataSource={props.trabajadores}
        />
    );
}

export default ListaTrabajadores;
