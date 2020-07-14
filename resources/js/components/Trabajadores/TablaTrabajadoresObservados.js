/* eslint-disable eqeqeq */
import React, { useState, useEffect } from 'react';
import { Table, Button, Modal, Tag, Space, Tooltip, notification } from 'antd';
import {DeleteOutlined, WarningTwoTone} from '@ant-design/icons';
import moment from 'moment';

const TablaTrabajadoresObservados = ({
    trabajadoresObservados,
    reload,
    setReload,
    usuario,
    eliminarContrato
}) => {
    const [showModal, setShowModal] = useState(false);
    const [observaciones, setObservaciones] = useState([]);

    const mostrarObservaciones = rut => {
        setShowModal(true);
        const trabajadores = trabajadoresObservados.filter(
            // eslint-disable-next-line eqeqeq
            t => t.rut == rut
        )[0];
        setObservaciones(trabajadores.observaciones);
    };

    const habilitarTrabajador = (rut, id) => {
        console.log(id);
        Modal.confirm({
            title: 'Habilitar trabajador',
            content: `¿Está seguro que desea habilitar a ${rut}?`,
            okText: 'Habilitar',
            okType: 'success',
            cancelText: 'Cancelar',
            onOk() {
                axios.put(`/api/trabajador/${id}/habilitar`)
                    .then(res => {
                        console.log(res);
                        const state = res.status < 300 ? 'sucess' : 'error';
                        notification[state]({
                            text: res.data.message
                        });
                    })
                    .catch(err => {
                        console.log(err);
                    })
                    .finally(() => {
                        setReload(!reload);
                    })
            },
        });
    };

    const handleCancel = () => {
        setShowModal(false);
        setObservaciones([]);
    };

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa_name',
            key: 'empresa_name'
        },
        {
            title: 'RUT',
            dataIndex: 'rut',
            key: 'rut',
        },
        {
            title: 'Apellidos',
            dataIndex: 'apellidos',
            key: 'apellidos',
        },
        {
            title: 'Nombre',
            dataIndex: 'nombre',
            key: 'nombre',
        },
        {
            title: 'Fecha Ingreso',
            dataIndex: 'c',
            key: 'fecha_inicio'
        },
        {
            title: 'Grupo',
            dataIndex: 'grupo',
        },
        {
            title: 'Observación',
            dataIndex: 'observacion',
            render: (_, record) => {
                const contrato_activo = record.observaciones.filter(
                    o => o.contrato_activo === 1
                );
                return (
                    <Space>
                        {record.observaciones.length > contrato_activo.length ? (
                            <Button
                                onClick={() => mostrarObservaciones(record.rut)}
                                size="small"
                                disabled={usuario.rol !== 'admin'}
                            >
                                <WarningTwoTone twoToneColor="#ffcc00" /> Alerta
                            </Button>
                        ) : (
                            ''
                        )}
                        {contrato_activo.length >= 1 ? (
                            <Tooltip
                                disabled={usuario.rol !== 'admin'}
                                title={`${contrato_activo[0].observacion} -  Empresa: ${contrato_activo[0].empresa_id}`}
                            >
                                <Tag color="warning">Contrato activo: {contrato_activo[0].empresa_id}</Tag>
                            </Tooltip>
                        ) : (
                            ''
                        )}
                    </Space>
                );
            },
        },
        {
            title: 'Acciones',
            key: 'acciones',
            render: (_, record) => {
                return (
                    <Button.Group>
                        <Tooltip title="Habilitar trabajador">
                            <Button
                                type="primary"
                                onClick={() =>
                                    habilitarTrabajador(record.rut, record.contrato_id)
                                }
                                disabled={usuario.rol !== 'admin'}
                            >
                                Habilitar
                            </Button>
                        </Tooltip>
                        <Tooltip title="Borrar trabajador">
                            <Button type="danger" onClick={() => eliminarContrato(record.contrato_id)}>
                                <DeleteOutlined />
                            </Button>
                        </Tooltip>
                    </Button.Group>
                );
            },
        },
    ];

    return (
        <div>
            <Modal
                title="Observaciones"
                visible={showModal}
                onCancel={handleCancel}
            >
                <ul>
                    {observaciones.map(o => {
                        if (o.contrato_activo) {
                            return (
                                <li key={o.id}>
                                    <b>Contrato activo:</b>
                                    <br />
                                    {o.observacion}
                                    <br />
                                    Fecha inicio:{' '}
                                    {moment(o.fecha_inicio).format(
                                        'YYYY-MM-DD'
                                    )}{' '}
                                    -- Fecha termino:{' '}
                                    {moment(o.fecha_termino_c).format(
                                        'YYYY-MM-DD'
                                    )}
                                    <br />
                                    Zona Labor: {o.zona_labor_id}
                                </li>
                            );
                        } else {
                            return (
                                <li key={o.id}>
                                    <b>Alerta:</b>
                                    <br />
                                    {o.observacion}
                                    <br />
                                    Fecha:{' '}
                                    {o.fecha
                                        ? moment(o.fecha).format('YYYY-MM-DD')
                                        : 'Sin fecha'}
                                    <br />
                                    Dígito: {o.digito ? o.digito : 'Sin dígito'}
                                </li>
                            );
                        }
                    })}
                </ul>
            </Modal>
            <Table
                columns={columns}
                dataSource={trabajadoresObservados}
                size="small"
            />
        </div>
    );
};

export default TablaTrabajadoresObservados;
