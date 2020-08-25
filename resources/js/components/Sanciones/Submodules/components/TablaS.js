import React, { useState } from 'react';
import {Table, Tooltip} from 'antd';
import moment from "moment";

export const TablaS = ({
    sanciones,
    filtro,
    handleEliminar,
    handleMarcarEnviado,
    handleMarcarSubido,
}) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [selectedRowKeys , setSelectedRowKeys] = useState([]);
    const [loading, setLoading] = useState(false);

    const getColumns = (
        usuario,
        handleEliminar,
        handleMarcarEnviado,
        handleMarcarSubido
    ) => {
        if (usuario.sanciones === 1) {
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
                    title: 'Incidencia',
                    dataIndex: 'incidencia'
                },
                {
                    title: 'Fecha Incidencia',
                    dataIndex: 'fecha_incidencia'
                },
                {
                    title: 'Tipo',
                    dataIndex: 'documento'
                },
                {
                    title: 'Predio',
                    dataIndex: 'zona_labor'
                },
                {
                    title: 'Observación',
                    dataIndex: 'observacion'
                },
                {
                    title: 'Acciones',
                    dataIndex: 'acciones',
                    render: (_, record) => (
                        <Acciones
                            usuario={usuario}
                            record={record}
                            handleEliminar={handleEliminar}
                            handleMarcarEnviado={handleMarcarEnviado}
                            handleMarcarSubido={handleMarcarSubido}
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
                    title: 'Incidencia',
                    dataIndex: 'incidencia'
                },
                {
                    title: 'Fecha Incidencia',
                    dataIndex: 'fecha_incidencia'
                },
                {
                    title: 'Tipo',
                    dataIndex: 'documento'
                },
                {
                    title: 'Predio',
                    dataIndex: 'zona_labor'
                },
                {
                    title: 'Cargado por',
                    dataIndex: 'nombre_completo_usuario'
                },
                {
                    title: 'Observación',
                    dataIndex: 'observacion'
                },
                {
                    title: 'Acciones',
                    dataIndex: 'acciones',
                    render: (_, record) => (
                        <Acciones
                            usuario={usuario}
                            record={record}
                            handleEliminar={handleEliminar}
                            handleMarcarEnviado={handleMarcarEnviado}
                            handleMarcarSubido={handleMarcarSubido}
                        />
                    )
                }
            ];
        }
    }

    const handleMassiveMarcaEnnviado = () => {
        console.log('massive');
    }

    const onSelectChange = selectedRowKeys => {
        console.log(selectedRowKeys)
        setSelectedRowKeys(selectedRowKeys);
    };

    const rowSelection = {
        selectedRowKeys,
        onChange: onSelectChange,
    };
    const hasSelected = selectedRowKeys.length > 0;

    return (
        <>
            <div style={{ marginBottom: 16 }}>
                {(hasSelected && filtro.estado === 0 && usuario.sanciones === 2) && (
                    <button className="btn btn-primary" disabled={loading} onClick={handleMassiveMarcaEnnviado}>
                        {loading ? (
                            <>
                                <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true" />
                                <span className="sr-only">Cargando...</span>
                            </>
                        ) : 'Marcar como ENVIADO'}
                    </button>
                )}
                <span style={{ marginLeft: 8 }}>
                    {hasSelected ? `${selectedRowKeys.length} item(s) seleccionados` : ''}
                </span>
            </div>
            <Table
                rowSelection={rowSelection}
                columns={getColumns(usuario, handleEliminar, handleMarcarEnviado, handleMarcarSubido)}
                dataSource={sanciones}
                scroll={{ x: 1000 }}
                size="small"
            />
        </>
    );
}


const Acciones = ({
    usuario,
    record,
    handleEliminar,
    handleMarcarEnviado,
    handleMarcarSubido,
}) => {
    return (
        <div className="btn-group">
            <Tooltip title="Ver documento">
                <a className="btn btn-primary btn-sm" href={`/ficha/sancion/${record.id}`} target="_blank">
                    <i className="fas fa-search"/>
                </a>
            </Tooltip>
            {record.estado === 0 && (
                <>
                    <Tooltip title="Editar Sancion">
                        <a className="btn btn-primary btn-sm" href={`/sanciones/editar/${record.id}`} target="_blank">
                            <i className="far fa-edit" />
                        </a>
                    </Tooltip>
                    <Tooltip title="Marca como ENVIADO">
                        <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarEnviado(record.id)}>
                            <i className="fas fa-check" />
                        </button>
                    </Tooltip>
                    {record.fecha_solicitud === moment().format('DD/MM/YYYY') && (
                        <Tooltip title="Eliminar">
                            <button className="btn btn-danger btn-sm" onClick={() => handleEliminar(record.id)}>
                                <i className="fas fa-trash-alt" />
                            </button>
                        </Tooltip>
                    )}
                </>
            )}
            {(record.estado === 1 && usuario.sanciones === 2) && (
                <Tooltip title="Marca como SUBIDO">
                    <button className="btn btn-outline-warning btn-sm" onClick={() => handleMarcarSubido(record.id)}>
                        <i className="fas fa-check" />
                    </button>
                </Tooltip>
            )}
        </div>
    );
}
