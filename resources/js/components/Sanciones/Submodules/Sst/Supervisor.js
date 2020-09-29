import { Card, message, Spin, Table, Tag, Tooltip } from 'antd';
import Axios from 'axios';
import React, { useEffect, useState } from 'react';

export const Supervisor = () => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [sync, setSync] = useState(false);
    const [loading, setLoading] = useState(false);
    const [covid, setCovid] = useState([]);

    const [selectedRowKeys , setSelectedRowKeys] = useState([]);

    const onSelectChange = selectedRowKeys => {
        setSelectedRowKeys(selectedRowKeys);
    };

    const rowSelection = {
        selectedRowKeys,
        onChange: onSelectChange,
    };
    const hasSelected = selectedRowKeys.length > 0;

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa_id',
            render: (value, record) => parseInt(value) === 9 ? 'RAPEL' : 'VERFRUT'
        },
        {
            title: 'RUT',
            dataIndex: 'rut',
        },
        {
            title: 'Nombre Completo',
            dataIndex: 'nombre_completo'
        },
        {
            title: 'Incidencia',
            dataIndex: 'incidencia',
            render: (value) => value.trim()
        },
        {
            title: 'Fecha hora incidencia',
            dataIndex: 'fecha_incidencia',
            render: (value, record) => `${value} ${record.hora_incidencia}`
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor'
        },
        {
            title: 'Usuario',
            dataIndex: 'usuario',
            render: (value, record) => (
                <Tooltip placement="top" title={`${record.rut_usuario} - ${record.apellido_paterno_usuario} ${record.apellido_materno_usuario} ${record.nombre_usuario}`}>
                    <span style={{ textDecoration: 'underline', color: '#1890FF' }}>{value}</span>
                </Tooltip>
            )
        },
        {
            title: 'Observación',
            dataIndex: 'observacion',
            ellipsis: {
                showTitle: false,
            },
            render: value => (
                <Tooltip placement="top" title={value}>
                    {value}
                </Tooltip>
            ),
        },
        {
            title: 'Estado',
            dataIndex: 'estado',
            render: value => renderTags(value)
        }
    ]

    function renderTags(estado) {
        switch (estado) {
            case 0:
                return <Tag color="processing" >PENDIENTE</Tag>;
            case 1:
                return <Tag color="error" >INVALIDO</Tag>;
            default:
                return null;
        }
    }

    const sincronizar = () => {
        let times = 0;
        setSync(true);

        const query = () => {
            times++;
            Axios.post('/api/covid/sincronizar', {
                usuario,
            })
                .then(res => {
                    //console.log(res.data);
                    message['success']({
                        content: `Se actualizaron ${res.data} registros`
                    })
                    setSync(false);

                    fetchIncidencias();
                })
                .catch(err => {
                    console.error(err);
                    time < 3 && sincronizar();
                });
        }

        query();
    }

    const fetchIncidencias = () => {
        setLoading(true);
        Axios.get(`/api/covid/estados?usuario_id=${usuario.sanciones === 2 ? 0 : usuario.id}`)
            .then(res => {
                //console.log(res);
                message['success']({
                    content: `Se encontrado ${res.data.length} registros`
                });
                setCovid(res.data.map(c => {
                    return {
                        ...c.covid,
                        estado: c.estado,
                        usuario_id: c.usuario_id,
                        key: c.id
                    }
                }));
                setLoading(false);
            })
            .catch(err => {
                console.error(err);
            })
    }

    useEffect(() => {
        sincronizar();
    }, []);

    const toggleValido = tipo => {
        Axios.put(`/api/covid/toggle-valido/${tipo}`, {
            ids: selectedRowKeys,
        })
            .then(res => {
                console.log(res);
                fetchIncidencias();
                setSelectedRowKeys([]);
            })
            .catch(err => {
                console.error(err);
            })
    }

    const terminarProceso = todos => {
        const sendedKeys = todos ? covid.map(e => e.key) : selectedRowKeys;

        Axios.post(`/api/covid/terminar-proceso`, {
            ids: sendedKeys
        })
            .then(res => {
                Swal.fire('Proceso completado', '', 'info')
                .then(res => {
                        fetchIncidencias();
                        setSelectedRowKeys([]);
                    });
            })
            .catch(err => {
                console.log(err);
            });
    }

    const handleMassiveTerminar = todos => {
        Swal.fire({
            title: `Terminar proceso`,
            html: `
                Estos registros pasarán al <b>ANALISTA DE SST</b> antes de enviarlos a <b>RR.HH.</b>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        })
            .then(res => {
                if (res.value) {
                    terminarProceso(todos);
                }
            })
            .catch(err => {
                console.error(err);
            })
    }

    const handleMassiveValidar = () => {
        toggleValido(0);
    }

    const handleMassiveInvalidar = () => {
        toggleValido(1);
    }

    const Buttons = () => (
        <div style={{ marginBottom: 16 }}>
            <button className="btn btn-primary" disabled={!hasSelected} onClick={handleMassiveValidar}>
                {loading ? (
                    <>
                        <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span className="sr-only">Cargando...</span>
                    </>
                ) : <span><i className="fas fa-check"></i> Validar</span>}
            </button>
            <button className="btn btn-danger" disabled={!hasSelected} onClick={handleMassiveInvalidar}>
                {loading ? (
                    <>
                        <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span className="sr-only">Cargando...</span>
                    </>
                ) : <span><i className="fas fa-times"></i> Invalidar</span>}
            </button>
            {hasSelected && (
                <button className="btn btn-success" onClick={() => handleMassiveTerminar(false)}>
                    {loading ? (
                        <>
                            <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span className="sr-only">Cargando...</span>
                        </>
                    ) : <span><i className="fas fa-flag-checkered"></i> Enviar SELECCIONADOS</span>}
                </button>
            )}
            <span style={{ marginLeft: 8 }}>
                {hasSelected ? `${selectedRowKeys.length} item(s) seleccionados` : ''}
            </span>

            <button className="btn btn-success" onClick={() => handleMassiveTerminar(true)} style={{ float: 'right' }}>
                {loading ? (
                    <>
                        <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span className="sr-only">Cargando...</span>
                    </>
                ) : <span><i className="fas fa-flag-checkered"></i> ENVIAR <b><u>TODOS</u></b> AL ANALISTA</span>}
            </button>
        </div>
    );

    return (
        <>
            <Spin spinning={sync} size="large" tip="Sincronizando con los registros de la app...">
                <h4>Supervisor SST</h4>
                {usuario.sanciones === 2 && (
                    <div className="alert alert-warning" role="alert">
                        Como es usuario <b>ADMINISTRADOR</b> puede visualizar <b>todos</b> los registros de los Supervisores de SST
                    </div>
                )}
                <div className="alert alert-primary" role="alert">
                    <i className="fas fa-info"></i>&nbsp;&nbsp;Valide que registros <u>serán enviados al Analista de SST.</u> Al terminar presione el botón <b>ENVIAR AL ANALISTA</b>
                </div>
                <br />

                <Buttons />
                <Table
                    loading={loading} scroll={{ x: 500 }} rowSelection={rowSelection}
                    size="small" columns={columns}
                    dataSource={covid}
                />
            </Spin>
        </>
    );
}
