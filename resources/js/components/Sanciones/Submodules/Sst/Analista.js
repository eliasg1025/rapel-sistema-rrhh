import React, { useState, useEffect } from 'react';
import { Card, message, Select, Table, Tag, Tooltip } from 'antd';
import Axios from 'axios';
import { GraficoBarras } from '../components/GraficoBarras';

export const Analista = () => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [covid, setCovid] = useState([]);
    const [supervisores, setSupervisores] = useState([]);
    const [reloadData, setReloadData] = useState(false);
    const [loadingSupervisores, setLoadingSupervisores] = useState(false);
    const [loading, setLoading] = useState(false);
    const [estadoCarga, setEstadoCarga] = useState([]);
    const [filter, setFilter] = useState({
        usuario_id: 0,
    });

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

    useEffect(() => {
        fetchSupervisoresSst();
        fetchIncidencias();
    }, [filter, reloadData])

    const fetchIncidencias = () => {
        setLoading(true);
        Axios.get(`/api/covid/estados/analista?usuario_id=${filter.usuario_id}`)
            .then(res => {
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

    const fetchSupervisoresSst = () => {{
        setLoadingSupervisores(true);
        Axios.get('/api/covid/supervisores-sst')
            .then(res => {
                setSupervisores(res.data);
                setLoadingSupervisores(false);
            })
            .catch(err => {
                console.error(err);
            })
    }}

    function renderTags(estado) {
        switch (estado) {
            case 0:
                return <Tag color="processing" >PENDIENTE</Tag>;
            case 1:
                return <Tag color="error" >INVALIDO</Tag>;
            case 2:
                return <Tag color="error">ELIMINADO</Tag>;
            case 3:
                return <Tag color="processing" >PARA ANALISTA</Tag>;
            case 4:
                return <Tag color="error" >INVALIDO</Tag>;
            default:
                return null;
        }
    }

    const terminarProceso = () => {
        Swal.fire({
            title: 'Generando sanciones',
            text: 'Este proceso puede tardar unos minutos',
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });


        Axios.post(`/api/covid/generar-sanciones`, {
            data: covid
        })
            .then(res => {
                setEstadoCarga(res.data);
                Swal.fire('Proceso completado', '', 'info')
                    .then(res => {
                        fetchIncidencias();
                        setSelectedRowKeys([]);
                    });
            })
            .catch(err => {
                console.log(err);
            })
    }

    const toggleValido = tipo => {
        Axios.put(`/api/covid/toggle-valido/${tipo}`, {
            ids: selectedRowKeys,
        })
            .then(res => {
                fetchIncidencias();
                console.log(res.data);
                setSelectedRowKeys([]);
            })
            .catch(err => {
                console.error(err);
            })
    }

    const handleMassiveValidar = () => {
        toggleValido(3);
    }

    const handleMassiveInvalidar = () => {
        toggleValido(4);
    }


    const handleMassiveTerminar = () => {
        Swal.fire({
            title: `Terminar proceso`,
            html: `
                Estos registros pasarán a <b>RR.HH.</b>. Es proceso <b>NO ES REVERSIBLE</b> ¿Ésta seguro que desea realizarlo?
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
                    terminarProceso();
                }
            })
            .catch(err => {
                console.error(err);
            })
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
            <span style={{ marginLeft: 8 }}>
                {hasSelected ? `${selectedRowKeys.length} item(s) seleccionados` : ''}
            </span>

            <button className="btn btn-success" onClick={handleMassiveTerminar} style={{ float: 'right' }}>
                {loading ? (
                    <>
                        <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span className="sr-only">Cargando...</span>
                    </>
                ) : <span><i className="fas fa-flag-checkered"></i> ENVIAR A RR.HH.</span>}
            </button>
        </div>
    );

    return (
        <>
            <h4>Analista SST</h4>
            <div className="alert alert-primary" role="alert">
                <i className="fas fa-info"></i>&nbsp;&nbsp;Valide que registros <u>serán enviados a RR.HH.</u> Al terminar presione el botón <b>ENVIAR A RR.HH.</b>
            </div>
            <br />
            <Card>
                <div className="form">
                    <div className="form-row">
                        <div className="col-md-4">
                            Supervisor:<br />
                            <Select
                                loading={loadingSupervisores}
                                value={filter.usuario_id} showSearch
                                style={{ width: '100%' }} optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => setFilter({ ...filter, usuario_id: e })}
                                size="small"
                            >
                                <Select.Option value={0} key={0}>
                                    TODOS
                                </Select.Option>
                                {supervisores.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.trabajador.apellido_paterno} ${e.trabajador.apellido_materno} ${e.trabajador.nombre}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                    </div>
                </div>
            </Card>
            <br />
            <Buttons />
            {estadoCarga.length !== 0 && (
                <div className="alert alert-primary" role="alert">
                    <span style={{ fontWeight: 'bold' }}>Estado de Carga:</span>
                    <ol>
                        {estadoCarga.map(e => (
                            <li key={e.rut}><span style={{ fontWeight: 'bold' }}>{e.rut} - {e.error ? <i className="fas fa-times" style={{ color: 'red' }}></i> : <i className="fas fa-check" style={{ color: 'green' }}></i>}</span> {e.error ? `${e.error}` : e.message}</li>
                        ))}
                    </ol>
                </div>
            )}
            <Table
                loading={loading} scroll={{ x: 500 }} rowSelection={rowSelection}
                size="small" columns={columns}
                dataSource={covid}
            />
            <hr />
            <br />
            <h4>Reportes</h4>
            <div className="row">
                <div className="col-md-6">
                    <GraficoBarras />
                </div>
                <div className="col-md-6"></div>
            </div>
        </>
    );
}
