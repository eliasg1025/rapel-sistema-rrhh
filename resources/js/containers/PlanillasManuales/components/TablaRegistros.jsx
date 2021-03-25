import React, { useState, useEffect } from 'react';
import { Table, DatePicker, Input, Tooltip, Modal, Select, Button, notification } from 'antd';
import Axios from 'axios';
import moment from 'moment';

import ModalCustom from '../../Modal';

export const TablaRegistros = ({ reload, setReload, handleEliminar }) => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const initialState = {
        id: '',
        hora_entrada: '',
        hora_salida: '',
        motivo_planilla_manual_id: '',
    };

    const [submiting, setSubmiting] = useState(false);
    const [loading, setLoading] = useState(false);
    const [data, setData] = useState([]);
    const [viewModal, setViewModal] = useState(false);
    const [activeRecord, setActiveRecord] = useState(null);

    const [form, setForm] = useState(initialState);
    const [motivos, setMotivos] = useState([]);

    const [filtro, setFiltro] = useState({
        desde: moment().subtract(7, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        rut: '',
    });

    const columns = [
        {
            title: 'Fecha Planilla',
            dataIndex: 'fecha_planilla',
        },
        {
            title: 'Fecha Hora Cargado',
            dataIndex: 'created_at',
            render: item => moment(item).format('YYYY-MM-DD hh:mm:ss').toString()
        },
        {
            title: 'DNI',
            dataIndex: 'trabajador',
            render: item => item.rut
        },
        {
            title: 'Trabajador',
            dataIndex: 'trabajador',
            render: item => `${item.apellido_paterno} ${item.apellido_materno} ${item.nombre}`
        },
        {
            title: 'Hora Entrada',
            dataIndex: 'hora_entrada',
        },
        {
            title: 'Hora Salida',
            dataIndex: 'hora_salida'
        },
        {
            title: '# Registros',
            dataIndex: 'cantidad_registros'
        },
        {
            title: 'Motivo',
            dataIndex: 'motivo',
            render: item => item.descripcion
        },
        {
            title: 'Cargado Por',
            dataIndex: 'usuario',
            render: item => `${item.trabajador.apellido_paterno} ${item.trabajador.apellido_materno} ${item.trabajador.nombre}`
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (_, record) => {
                return (
                    <>
                        {((usuario.modulo_rol.tipo.name === "ADMINISTRADOR") || moment(record.fecha_planilla).add(1, 'days').isSameOrAfter(moment(new Date()))) && (
                            <div className="btn-group">
                                <Tooltip title="Editar Registro">
                                    <button
                                        className="btn btn-sm btn-primary"
                                        onClick={() => handleEditar(record)}
                                    >
                                        <i className="fas fa-edit"></i>
                                    </button>
                                </Tooltip>
                                <Tooltip title="Eliminar Registro">
                                    <button
                                        className="btn btn-sm btn-danger"
                                        onClick={() => confirmEliminar(record)}
                                    >
                                        <i className="fas fa-trash"></i>
                                    </button>
                                </Tooltip>
                            </div>
                        )}
                    </>
                );
            }
        }
    ];

    const handleExportar = () => {
        const headings = [
            "EMPRESA",
            "FECHA",
            "RUT",
            "TRABAJADOR",
            "HORA ENTRADA",
            "HORA SALIDA",
            "PATENTE",
            "MOTIVO"
        ];

        const d = data.map(item => {
            return {
                empresa: item.empresa.name,
                fecha_solicitud: item.fecha_planilla,
                dni: item.trabajador.rut,
                trabajador:
                    item?.trabajador.apellido_paterno +
                    " " +
                    item?.trabajador.apellido_materno +
                    " " +
                    item?.trabajador.nombre,
                hora_entrada: item.hora_entrada,
                hora_salida: item.hora_salida,
                patente: "",
                motivo: item.motivo.descripcion,
            };
        });

        Axios({
            url: "/descargar",
            data: { headings, data: d },
            method: "POST",
            responseType: "blob"
        }).then(response => {
            let blob = new Blob([response.data], {
                type:
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "PLANILLAS-MANUALES.xlsx";
            link.click();
        });
    };

    const confirmEliminar = record => {
        Modal.confirm({
            title: "Eliminar registro",
            content: "¿Desea eliminar el registro?",
            okText: "Si, ELIMINAR",
            cancelText: "Cancelar",
            onOk: () => handleEliminar(record.id)
        });
    };

    const handleEditar = record => {
        setActiveRecord(null);
        setViewModal(true);
        setActiveRecord(record);
    }

    const handleSubmit = e => {
        e.preventDefault();

        setSubmiting(true);
        Axios.put(`/api/planillas-manuales/${form.id}`, {
            hora_entrada: form.hora_entrada,
            hora_salida: form.hora_salida,
            motivo_planilla_manual_id: form.motivo_planilla_manual_id
        })
            .then(res => {
                notification['success']({
                    message: res.data.message
                });

                setReload(!reload);
            })
            .catch(err => {
                console.log(err);

                notification['error']({
                    message: err.response.data.message
                });
            })
            .finally(() => setSubmiting(false));
    }

    useEffect(() => {
        function fetchMotivosFotocheck() {
            Axios.get("/api/motivos-planillas-manuales")
                .then(res => setMotivos(res.data.data))
                .catch(err => {});
        }

        fetchMotivosFotocheck();
    }, []);

    useEffect(() => {
        setForm({
            id: activeRecord?.id || '',
            hora_entrada: activeRecord?.hora_entrada ? activeRecord?.hora_entrada : undefined,
            hora_salida: activeRecord?.hora_salida ? activeRecord?.hora_salida : undefined,
            motivo_planilla_manual_id: activeRecord?.motivo_planilla_manual_id
        });
    }, [activeRecord]);

    useEffect(() => {
        const fetchPlanillas = () => {
            setLoading(true);
            Axios.get(`/api/planillas-manuales?estado=${1}&desde=${filtro.desde}&hasta=${filtro.hasta}&rut=${filtro.rut}&usuario_id=${usuario.id}`)
                .then(res => {
                    const _data = res.data.data.map(item => {
                        return {
                            ...item,
                            key: item.id,
                        }
                    });

                    setData(_data);
                })
                .catch(err => {})
                .finally(() => setLoading(false))
        }

        if (filtro.rut === '' || filtro.rut.length >= 8) {
            fetchPlanillas();
        }
    }, [reload, filtro.desde, filtro.hasta, filtro.rut]);

    return (
        <>
            <br />
            <div className="row">
                <div className="col-md-4 col-sm-6 col-xs-12">
                    Desde - Hasta:
                    <br />
                    <DatePicker.RangePicker
                        placeholder={["Desde", "Hasta"]}
                        style={{ width: "100%" }}
                        onChange={(date, dateString) => {
                            setFiltro({
                                ...filtro,
                                desde: dateString[0],
                                hasta: dateString[1]
                            });
                        }}
                        value={[moment(filtro.desde), moment(filtro.hasta)]}
                    />
                </div>
                <div className="col-md-4 col-sm-6 col-xs-12">
                    Búsqueda por DNI:
                    <br />
                    <Input
                        placeholder="Mínimo 8 caracteres"
                        value={filtro.rut}
                        onChange={e =>
                            setFiltro({ ...filtro, rut: e.target.value })
                        }
                        allowClear
                    />
                </div>
            </div>
            <br />
            <b style={{ fontSize: "13px" }}>
                Cantidad: {data.length} registros{" "}
                &nbsp;
                <button
                    className="btn btn-success btn-sm"
                    onClick={handleExportar}
                >
                    <i className="fas fa-file-excel" /> Exportar
                </button>
            </b>
            <br />
            <br />
            <Table
                bordered
                size="small"
                scroll={{ x: 1000 }}
                columns={columns}
                dataSource={data}
                loading={loading}
            />
            <ModalCustom
                title="Editar Registro"
                isVisible={viewModal}
                setIsVisible={setViewModal}
                width={700}
            >
                <form onSubmit={handleSubmit}>
                    <div className="row">
                        <div className="col-md-4">
                            RUT:<br />
                            <input
                                className="form-control"
                                value={activeRecord?.trabajador.rut}
                                readOnly
                            />
                        </div>
                        <div className="col-md-8">
                            Trabajador:<br />
                            <input
                                className="form-control"
                                value={`${activeRecord?.trabajador.apellido_paterno} ${activeRecord?.trabajador.apellido_materno} ${activeRecord?.trabajador.nombre}`}
                                readOnly
                            />
                        </div>
                        <div className="col-md-4">
                            Fecha Planilla:<br />
                            <input
                                className="form-control"
                                value={`${activeRecord?.fecha_planilla}`}
                                readOnly
                            />
                        </div>
                        <div className="col-md-4">
                            Hora Entrada:<br />
                            <input
                                className="form-control"
                                value={form.hora_entrada || ''}
                                onChange={e => setForm({ ...form, hora_entrada: e.target.value })}
                                type="time"
                            />
                        </div>
                        <div className="col-md-4">
                            Hora Salida:<br />
                            <input
                                className="form-control"
                                value={form.hora_salida || ''}
                                onChange={e => setForm({ ...form, hora_salida: e.target.value })}
                                type="time"
                            />
                        </div>
                        <div className="col-md-8">
                            Motivo: <br />
                            <Select
                                value={form.motivo_planilla_manual_id}
                                showSearch
                                size="small"
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e => setForm({ ...form, motivo_planilla_manual_id: e })}
                                style={{
                                    width: "100%"
                                }}
                            >
                                {motivos.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.id} - ${e.descripcion}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                    </div>
                    <br />
                    <div className="row">
                        <div className="col-md-12">
                            <Button type="primary" htmlType="submit" loading={submiting} block>
                                Actualizar
                            </Button>
                        </div>
                    </div>
                </form>
            </ModalCustom>
        </>
    );
}
