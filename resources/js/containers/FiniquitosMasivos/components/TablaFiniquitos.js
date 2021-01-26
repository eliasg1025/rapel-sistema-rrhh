import React, { useState } from "react";
import { Button, notification, Table, Tooltip, Modal, Tag } from "antd";
import moment from "moment";
import Axios from "axios";

import ModalCustom from "../../Modal";

import { FiniquitosProvider } from "../../../providers";

const finiquitosProvider = new FiniquitosProvider();

export const TablaFiniquitos = ({ reload, setReload, informe }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem("data"));

    const [viewModal, setViewModal] = useState(false);
    const [form, setForm] = useState({
        justificacion: "",
        id: ""
    });

    const confirmDelete = id => {
        setForm({ id: id });
        setViewModal(true);
    };

    const deleteFiniquito = async e => {
        e.preventDefault();
        console.log(form);
        const { message, data } = await finiquitosProvider.delete(form.id, {
            justificacion: form.justificacion
        });

        setReload(!reload);

        notification["success"]({
            message: message
        });
    };

    const confirmChangeState = id => {
        Modal.confirm({
            title: "Marcar como Firmado",
            content: "¿Desea marcar como firmado este registro?",
            okText: "SI",
            cancelText: "Cancelar",
            onOk: () => changeState(id)
        });
    };

    const changeState = async id => {
        const { message, data } = await finiquitosProvider.changeState(id, {
            estado_id: 2
        });

        setReload(!reload);

        notification["success"]({
            message: message
        });
    };

    const handleExportar = () => {
        const headings = [
            "FECHA FINIQUITO",
            "ZONA LABOR",
            "EMPRESA",
            "RUT",
            "APELLIDOS Y NOMBRES",
            "REGIMEN",
            "OFICIO",
            "TIPO DOCUMENTO",
            "TIEMPO SERVICIO",
            "ULTIMO DIA LABORADO",
            "ESTADO",
            "CARGADO POR"
        ];

        const d = informe.finiquitos.map(item => {
            return {
                fecha_finiquito: informe.fecha_finiquito,
                zona_labor: informe.zona_labor,
                empresa: item.empresa.shortname,
                rut: item.persona_id,
                apellidos_nombres: `${item.persona.apellido_paterno} ${item.persona.apellido_materno} ${item.persona.nombre}`,
                regimen: item.regimen.name,
                oficio: item.oficio.name,
                tipo_documento: item.tipo_cese.name,
                tiempo_servicio:
                    moment(informe.fecha_finiquito).diff(
                        moment(item.fecha_inicio_periodo),
                        "months"
                    ) >= 0
                        ? moment(informe.fecha_finiquito).diff(
                              moment(item.fecha_inicio_periodo),
                              "months"
                          )
                        : 0,
                ultimo_dia_laborado: item.fecha_ultimo_dia_laborado || "",
                estado: item.estado.name,
                cargado_por: `${item.usuario.trabajador.apellido_paterno} ${item.usuario.trabajador.apellido_materno} ${item.usuario.trabajador.nombre}`
            };
        });

        Axios({
            url: "/descargar",
            data: { headings, data: d },
            method: "POST",
            responseType: "blob"
        }).then(response => {
            //console.log(response);
            let blob = new Blob([response.data], {
                type:
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = `FINIQUITOS_${
                informe.fecha_finiquito
            }_${informe?.ruta || ""}_${informe?.codigo_bus || ""}.xlsx`;
            link.click();
        });
    };

    const columns = [
        {
            title: "Empresa",
            dataIndex: "empresa",
            render: item => item.shortname
        },
        {
            title: "DNI",
            dataIndex: "persona_id"
        },
        {
            title: "Apellidos y Nombres",
            dataIndex: "persona",
            render: (_, value) =>
                `${_.apellido_paterno} ${_.apellido_materno} ${_.nombre}`
        },
        {
            title: "Regimen",
            dataIndex: "regimen",
            render: (item, value) => item.name
        },
        {
            title: "Oficio",
            dataIndex: "oficio",
            render: (item, value) => item.name
        },
        {
            title: "Tipo Documento",
            dataIndex: "tipo_cese",
            render: item => item.name
        },
        {
            title: "Tiempo Servicio",
            dataIndex: "tiempo_servicio",
            //render: (_, value) => moment(informe.fecha_finiquito).diff(moment(value.fecha_inicio_periodo), "months") >= 0 ? moment(informe.fecha_finiquito).diff(moment(value.fecha_inicio_periodo), "months") : 0,
            render: (_, value) => {
                let a = moment(informe.fecha_finiquito);
                let b = moment(value.fecha_inicio_periodo);

                const years = a.diff(b, 'year');
                b.add(years, 'years');

                const months = a.diff(b, 'months');
                b.add(months, 'months');

                const days = a.diff(b, 'days');

                return `${years} años ${months} meses ${days} días`;
            }
        },
        {
            title: "Último día laborado",
            dataIndex: "fecha_ultimo_dia_laborado",
            render: (_, value) => value.fecha_ultimo_dia_laborado
        },
        {
            title: "Estado",
            dataIndex: "estado",
            render: record => <Tag color={record.color}>{record.name}</Tag>
        },
        {
            title: "Cargado por",
            dataIndex: "usuario",
            render: record =>
                `${record.trabajador.apellido_paterno} ${record.trabajador.apellido_materno} ${record.trabajador.nombre}`
        },
        {
            title: "Acciones",
            dataIndex: "acciones",
            render: (item, value) => (
                <Button.Group size="small">
                    {/* <Tooltip title="Editar Registro">
                        <button className="btn btn-primary btn-sm">
                            <i className="fas fa-edit"></i>
                        </button>
                    </Tooltip> */}
                    <Tooltip title="Ver documento">
                        <a
                            href={`/ficha/cese/${value.id}`}
                            className="btn btn-primary btn-sm"
                            target="_blank"
                        >
                            <i className="fas fa-search"></i>
                        </a>
                    </Tooltip>
                    {!["TERMINADO", "ANULADO"].includes(
                        informe?.estado?.name
                    ) &&
                        usuario.modulo_rol.tipo.name !==
                            "ANALISTA DE GESTION" &&
                            value?.estado?.name === "NO FIRMADO" && (
                                <Tooltip title="Estado">
                                    <button
                                        className="btn btn-primary btn-sm"
                                        onClick={() =>
                                            confirmChangeState(value.id)
                                        }
                                    >
                                        <i className="fas fa-check"></i>
                                    </button>
                                </Tooltip>
                            )}
                    {!["TERMINADO", "ANULADO"].includes(
                        informe?.estado?.name
                    ) &&
                        (value?.estado?.name === "SIN EFECTO" ? (
                            usuario.modulo_rol.tipo.name ===
                                "ADMINISTRADOR" && (
                                <Tooltip title="Eliminar Registro">
                                    <button
                                        className="btn btn-danger btn-sm"
                                        onClick={() => confirmDelete(value.id)}
                                    >
                                        <i className="fas fa-trash"></i>
                                    </button>
                                </Tooltip>
                            )
                        ) : (
                            <Tooltip title="Anular registro">
                                <button
                                    className="btn btn-danger btn-sm"
                                    onClick={() => confirmDelete(value.id)}
                                >
                                    <i className="fas fa-ban"></i>
                                </button>
                            </Tooltip>
                        ))}
                </Button.Group>
            )
        }
    ];

    return (
        <>
            <b style={{ fontSize: "13px" }}>
                Cantidad: {informe.finiquitos.length} finiquitos&nbsp;
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
                size="small"
                rowClassName={(record, index) =>
                    record.regimen.id === 1 ? "table-row-warning" : null
                }
                bordered
                columns={columns}
                dataSource={
                    informe.finiquitos.map(item => ({
                        ...item,
                        key: item.id
                    })) || []
                }
                scroll={{ x: 1100 }}
            />
            <ModalCustom
                title="Eliminar Finiquito"
                isVisible={viewModal}
                setIsVisible={setViewModal}
            >
                <form className="row" onSubmit={deleteFiniquito}>
                    <div className="col-md-12">
                        <textarea
                            className="form-control"
                            style={{ fontSize: "1.2rem" }}
                            placeholder="Justificación de la anulación"
                            value={form.justificacion}
                            onChange={e =>
                                setForm({
                                    ...form,
                                    justificacion: e.target.value
                                })
                            }
                            rows="3"
                        ></textarea>
                    </div>
                    <div className="col-md-12">
                        <div className="btn-group btn-block mt-4">
                            <button
                                type="button"
                                className="btn btn-outline-secondary"
                                onClick={() => setViewModal(false)}
                            >
                                Cancelar
                            </button>
                            <button
                                type="submit"
                                className="btn btn-outline-danger"
                            >
                                Anular
                            </button>
                        </div>
                    </div>
                </form>
            </ModalCustom>
        </>
    );
};
