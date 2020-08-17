import React, { useState, useEffect } from 'react';
import moment from 'moment';
import { Table, Checkbox, Tooltip, message } from 'antd';
import Axios from 'axios';

const { usuario } = JSON.parse(sessionStorage.getItem('data'));

const getColumns = (
    handleEliminar,
    handleMarcarFirmado,
    handleMarcarEnviado,
    handleMarcarRecepcionado,
    handleMarcarCargado,
) => {
    if (usuario.permisos == 1) {
        return [
            {
                title: 'Fecha Solicitud',
                dataIndex: 'fecha_solicitud'
            },
            {
                title: 'RUT',
                dataIndex: 'rut',

            },
            {
                title: 'Trabajador',
                dataIndex: 'nombre_completo',
            },
            {
                title: 'Empresa',
                dataIndex: 'empresa',
            },
            {
                title: 'Responsable',
                dataIndex: 'nombre_completo_jefe',
            },
            {
                title: 'Desde',
                dataIndex: 'desde'
            },
            {
                title: 'Hasta',
                dataIndex: 'hasta'
            },
            {
                title: 'H',
                dataIndex: 'horas'
            },
            {
                title: 'Motivo',
                dataIndex: 'motivo_permiso'
            },
            {
                title: 'Predio',
                dataIndex: 'zona_labor'
            },
            {
                title: 'Con Goce',
                dataIndex: 'goce_checkbox',
                render: (_, record) => <CheckboxGoce record={record} />
            },
            {
                title: 'Acciones',
                dataIndex: 'acciones',
                fixed: 'right',
                width: 120,
                render: (_, record) => (
                    <Acciones
                        record={record}
                        handleEliminar={handleEliminar}
                        handleMarcarFirmado={handleMarcarFirmado}
                        handleMarcarEnviado={handleMarcarEnviado}
                        handleMarcarRecepcionado={handleMarcarRecepcionado}
                        handleMarcarCargado={handleMarcarCargado}
                    />
                )
            }
        ];
    } else {
        return [
            {
                title: 'Fecha Solicitud',
                dataIndex: 'fecha_solicitud'
            },
            {
                title: 'RUT',
                dataIndex: 'rut',

            },
            {
                title: 'Trabajador',
                dataIndex: 'nombre_completo',
            },
            {
                title: 'Empresa',
                dataIndex: 'empresa',
            },
            {
                title: 'Responsable',
                dataIndex: 'nombre_completo_jefe',
            },
            {
                title: 'Desde',
                dataIndex: 'desde'
            },
            {
                title: 'Hasta',
                dataIndex: 'hasta'
            },
            {
                title: 'H',
                dataIndex: 'horas'
            },
            {
                title: 'Motivo',
                dataIndex: 'motivo_permiso'
            },
            {
                title: 'Predio',
                dataIndex: 'zona_labor'
            },
            {
                title: 'Con Goce',
                dataIndex: 'goce_checkbox',
                render: (_, record) => <CheckboxGoce record={record} />
            },
            {
                title: 'Cargador por',
                dataIndex: 'nombre_completo_usuario'
            },
            {
                title: 'Fecha Envío',
                dataIndex: 'fecha_hora_enviado'
            },
            {
                title: 'Acciones',
                dataIndex: 'acciones',
                fixed: 'right',
                width: 120,
                render: (_, record) => (
                    <Acciones
                        record={record}
                        handleEliminar={handleEliminar}
                        handleMarcarFirmado={handleMarcarFirmado}
                        handleMarcarEnviado={handleMarcarEnviado}
                        handleMarcarRecepcionado={handleMarcarRecepcionado}
                        handleMarcarCargado={handleMarcarCargado}
                    />
                )
            }
        ];
    }
}

const Acciones = ({
    record,
    handleMarcarFirmado,
    handleEliminar,
    handleMarcarEnviado,
    handleMarcarCargado,
    handleMarcarRecepcionado
}) => {
    return (
        <div className="btn-group">
            <Tooltip title="Ver documento">
                <a className="btn btn-primary btn-sm" href={`/ficha/formulario-permiso/${record.id}`} target="_blank">
                    <i className="fas fa-search"/>
                </a>
            </Tooltip>
            {record.estado == 0 && (
                <>
                    <Tooltip title="Editar Formulario">
                        <a className="btn btn-primary btn-sm" href={`/formularios-permisos/editar/${record.id}`} target="_blank">
                            <i className="far fa-edit" />
                        </a>
                    </Tooltip>
                    <Tooltip title="Marcar como FIRMADO">
                        <button className="btn btn-outline-primary btn-sm" onClick={() => handleMarcarFirmado(record.id)}>
                            <i className="fas fa-check" />
                        </button>
                    </Tooltip>
                    <button
                        className="btn btn-danger btn-sm"
                        disabled={moment(record.fecha_solicitud).format('DD/MM/YYYY') == moment().format('DD/MM/YYYY')}
                        onClick={() => handleEliminar(record.id)}
                    >
                        <i className="fas fa-trash-alt" />
                    </button>
                </>
            )}
            {(record.estado == 1) ? (
                <>
                    <Tooltip title="Editar Formulario">
                        <a className="btn btn-primary btn-sm" href={`/formularios-permisos/editar/${record.id}`} target="_blank">
                            <i className="far fa-edit" />
                        </a>
                    </Tooltip>
                    <Tooltip title="Marca como ENVIADO">
                        <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarEnviado(record.id)}>
                            <i className="fas fa-check" />
                        </button>
                    </Tooltip>
                </>
            ) : ''}
            {(record.estado == 2 & usuario.permisos == 2) ? (
                <>
                    <Tooltip title="Editar Formulario">
                        <a className="btn btn-primary btn-sm" href={`/formularios-permisos/editar/${record.id}`} target="_blank">
                            <i className="far fa-edit" />
                        </a>
                    </Tooltip>
                    <Tooltip title="Marca como RECEPCIONADO">
                        <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarRecepcionado(record.id)}>
                            <i className="fas fa-check" />
                        </button>
                    </Tooltip>
                </>
            ) : ''}
            {(record.estado == 3 & usuario.permisos == 2) ? (
                <>
                    <Tooltip title="Editar Formulario">
                        <a className="btn btn-primary btn-sm" href={`/formularios-permisos/editar/${record.id}`} target="_blank">
                            <i className="far fa-edit" />
                        </a>
                    </Tooltip>
                    <Tooltip title="Marca como SUBIDO EN EL SISTEMA">
                        <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarCargado(record.id)}>
                            <i className="fas fa-check" />
                        </button>
                    </Tooltip>
                </>
            ) : ''}
        </div>
    );
}

const CheckboxGoce = ({ record }) => {

    const [checked, setChecked] = useState(record.goce);

    const handleCheckGoce = id => {
        setChecked(!checked);
        Axios.put(`/api/formulario-permiso/toggle-goce/${id}`)
            .then(res => setChecked(res.data.goce));
    }

    return (
        <Checkbox
            checked={checked}
            disabled={record.estado !== 0}
            onChange={e => handleCheckGoce(record.id)}
        />
    )
}

export const TablaFP = ({
    data,
    filtro,
    handleEliminar,
    handleMarcarFirmado,
    handleMarcarEnviado,
    handleMarcarRecepcionado,
    handleMarcarCargado
}) => {
    const [selectedRowKeys , setSelectedRowKeys] = useState([]);
    const [loading, setLoading] = useState(false);

    const reload = () => {
        setLoading(true);
        setTimeout(() => {
            setSelectedRowKeys([]);
            setLoading(false);
        }, 1500)
    }

    const notAvalible = () => {
        message['warning']({
            content: 'Función aún no disponible'
        });
    }

    const onSelectChange = selectedRowKeys => {
        setSelectedRowKeys(selectedRowKeys);
    };

    const rowSelection = {
        selectedRowKeys,
        onChange: onSelectChange,
    };
    const hasSelected = selectedRowKeys.length > 0;

    return (
        <div>
            <div style={{ marginBottom: 16 }}>
                {(hasSelected && filtro.estado == 0) && (
                    <button className="btn btn-primary" onClick={notAvalible}>
                        Marcar como FIRMADO
                    </button>

                )}
                {(hasSelected && filtro.estado == 1) && (
                    <button className="btn btn-primary" onClick={notAvalible}>
                        Marcar como ENVIADO
                    </button>
                )}
                {(hasSelected && filtro.estado == 2 && usuario.permisos == 2) && (
                    <button className="btn btn-primary" onClick={notAvalible}>
                        Marcar como RECEPCIONADO
                    </button>
                )}
                {(hasSelected && filtro.estado == 3 && usuario.permisos == 2) && (
                    <button className="btn btn-primary" onClick={notAvalible}>
                        Marcar como SUBIDO AL SISTEMA
                    </button>
                )}
                <span style={{ marginLeft: 8 }}>
                    {hasSelected ? `${selectedRowKeys.length} item(s) seleccionados` : ''}
                </span>
            </div>
            <Table
                rowSelection={rowSelection}
                columns={getColumns(handleEliminar, handleMarcarFirmado, handleMarcarEnviado, handleMarcarRecepcionado, handleMarcarCargado)}
                dataSource={data}
                scroll={{ x: 1000 }}
                size="small"
            />
        </div>
    );
}
