import React, { useState, useEffect } from 'react';
import { Table, DatePicker, Input, Tooltip, Modal } from 'antd';
import Axios from 'axios';
import moment from 'moment';

export const TablaRegistros = ({ reload, setReload, handleEliminar }) => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [loading, setLoading] = useState(false);
    const [data, setData] = useState([]);

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
                        {((usuario.modulo_rol.tipo.name === "ADMINISTRADOR") || moment(record.fecha_planilla).isSameOrBefore(moment())) && (
                            <div className="btn-group">
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
        </>
    );
}
