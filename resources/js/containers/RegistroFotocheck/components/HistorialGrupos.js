import React, { useEffect, useState } from "react";
import { Card, Tag, Table, Tooltip, Modal as ModalAntd, notification, Select } from "antd";
import Axios from "axios";
import moment from "moment";

import Modal from '../../Modal';
import { isNull } from "lodash";

export const HistorialGrupos = () => {
    const [grupos, setGrupos] = useState([]);
    const [registros, setRegistros] = useState([]);
    const [viewModal, setViewModal] = useState(false);
    const [activeRecord, setActiveRecord] = useState(null);
    const [reload, setReload] = useState(false);

    const [filtro, setFiltro] = useState({
        estado_documento: 100,
    });

    const estados = [
        { id: 100, name: 'TODOS' },
        { id: 0, name: 'PENDIENTE' },
        { id: 1, name: 'ENVIADO' },
        { id: 2, name: 'RECEPCIONADO' },
    ];

    useEffect(() => {
        Axios.get("/api/cortes-renovaciones-fotocheck")
            .then(res => {
                setGrupos(res.data.data);
            })
            .catch(err => {
                console.log(err);
            });
    }, [reload]);

    useEffect(() => {
        if (activeRecord !== null) {
            Axios.get(`/api/cortes-renovaciones-fotocheck/${activeRecord.id}/registros`)
                .then(res => {
                    let regs = res.data.data;
                    if (filtro.estado_documento !== 100) {
                        regs = regs.filter(registro => registro.estado_documento === filtro.estado_documento);
                    }
                    setRegistros(regs);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }, [reload, activeRecord, filtro])

    const handleExportar = (record) => {
        const headings = [
            "EMPRESA",
            "FECHA SOLICITUD",
            "RUT",
            "TRABAJADOR",
            "REGIMEN",
            "FUNDO",
            "SOLICITANTE",
            "MOTIVO",
            "COSTO",
            "COLOR",
            "OBSERVACION",
            "ESTADO",
            "ESTADO DOCUMENTO",
        ];

        const d = record.registros.map(item => {
            return {
                empresa: item.empresa.name,
                fecha_solicitud: item.fecha_solicitud,
                dni: item.trabajador.rut,
                trabajador:
                    item.trabajador.apellido_paterno +
                    " " +
                    item.trabajador.apellido_materno +
                    " " +
                    item.trabajador.nombre,
                regimen: item?.regimen.name || "",
                fundo: item?.zona_labor.name || "",
                solicitante:
                    item?.usuario.trabajador.apellido_paterno +
                    " " +
                    item?.usuario.trabajador.apellido_materno +
                    " " +
                    item?.usuario.trabajador.nombre,
                motivo: item?.motivo.descripcion,
                costo: item?.motivo.costo,
                color: item?.color.color,
                observacion: item?.observacion || "",
                estado: item.estado === 0 ? 'SOLICITADO' : (
                    item.estado === 1 ? 'IMPRESO' : 'TERMINADO'
                ),
                estado_documento: !isNull(item.estado_documento) ? (
                    item.estado_documento == 0 ? 'PENDIENTE' : (
                        item.estado_documento == 1 ? 'ENVIADO' : 'RECEPCIONADO'
                    )
                ) : "-"
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
            link.download =
                "REGISTROS-FOTOCHECKS_GRUPO-" + record.id +  ".xlsx";
            link.click();
        });
    }

    const handleVerRegistros = (record) => {
        setViewModal(true);
        setFiltro({ estado_documento: 100 });
        setActiveRecord(record);
    }

    const confirmCambiarEstado = record => {
        ModalAntd.confirm({
            title: "Marcar RECEPCIONADO",
            content: "¿Desea marcar este registro como RECEPCIONADO?",
            okText: "Si, MARCAR COMO RECEPCIONADO",
            cancelText: "Cancelar",
            onOk: () => handleCambiarEstado(record, 2)
        });
    };

    const handleCambiarEstado = async (registro, estado) => {
        try {
            const res =  await Axios.put(`/api/renovacion-fotocheck/${registro.id}`, { estado_documento: estado })
            notification['success']({
                message: res.data.message
            });
            setReload(!reload);
        } catch (err) {
            notification['error']({
                message: 'Error al actualizar datos'
            });
        }
    }

    return (
        <>
            {grupos.map(grupo => {

                const recepcionados = grupo.registros.filter(registro => registro.estado_documento === 2).length;
                const paraRecepionar = grupo.registros.filter(registro => registro.estado_documento !== null).length;

                return (
                    <div key={grupo.id}>
                        <Card>
                            <div className="row">
                                <div className="col-md-6">
                                    <p>
                                        <b>Estado:</b>{" "}
                                        {grupo.activo ? (
                                            <Tag color="warning">ACTIVO</Tag>
                                        ) : (
                                            <Tag color="default">NO ACTIVO</Tag>
                                        )}
                                    </p>
                                    <p>
                                        <b>Codigo:</b> {grupo.id}
                                    </p>
                                    <p>
                                        <b>Fecha y hora:</b>{" "}
                                        {moment(grupo.fecha_hora_corte).format(
                                            "DD/MM/YYYY hh:mm"
                                        )}
                                    </p>
                                    <p>
                                        <b>Creado por:</b>{" "}
                                        {`${grupo.usuario.trabajador.apellido_paterno} ${grupo.usuario.trabajador.apellido_materno} ${grupo.usuario.trabajador.nombre}`}
                                    </p>
                                </div>
                                <div className="col-md-6">
                                    <p>
                                        <b># Registros:</b>{" "}
                                        {grupo.registros.length}
                                    </p>
                                    <p>
                                        <b># Recepcionados:</b>{" "}
                                        {
                                            recepcionados
                                        }{" "}
                                        de {
                                            paraRecepionar
                                        }&nbsp;&nbsp;{ paraRecepionar - recepcionados === 0 ? <span><i className="fas fa-check"></i></span> : <span><i className="fas fa-exclamation-triangle"></i></span> }
                                    </p>
                                    <div className="btn-group">
                                        <button className="btn btn-success" onClick={() => handleExportar(grupo)}>
                                            <i className="fas fa-file-excel"></i> Exportar
                                        </button>
                                        <button className="ml-2 btn btn-primary" onClick={() => handleVerRegistros(grupo)}>
                                            <i className="fas fa-eye"></i> Ver Registros
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </Card>
                        <br />
                    </div>
                );
            })}
            <Modal
                isVisible={viewModal}
                setIsVisible={setViewModal}
                width={1000}
                title={"Registros: GRUPO " + activeRecord?.id}
            >
                <div className="row">
                    <div className="col-md-4">
                        Estado Documento:<br />
                        <Select
                            value={filtro.estado_documento}
                            size="small"
                            showSearch
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setFiltro({ ...filtro, estado_documento: e })}
                            style={{
                                width: "100%"
                            }}
                        >
                            {estados.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {e.name}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                </div>
                <br />
                <Table
                    bordered
                    size="small"
                    pagination={{ pageSize: 8 }}
                    dataSource={registros.map(registro => {
                        return {
                            ...registro,
                            key: registro.id
                        }
                    })}
                    scroll={{ x: 900 }}
                    columns={[
                        {
                            title: "Empresa",
                            dataIndex: "empresa",
                            render: item => item.shortname
                        },
                        {
                            title: "Fecha",
                            dataIndex: "created_at",
                            render: item =>
                                moment(item)
                                    .format("DD/MM/YY hh:mm:ss")
                                    .toString()
                        },
                        {
                            title: "DNI",
                            dataIndex: "trabajador",
                            width: 70,
                            render: item => item.rut
                        },
                        {
                            title: "Apellidos y Nombres",
                            dataIndex: "trabajador",
                            width: 150,
                            render: item =>
                                item.apellido_paterno +
                                " " +
                                item.apellido_materno +
                                " " +
                                item.nombre
                        },
                        {
                            title: "Fundo",
                            dataIndex: "zona_labor",
                            render: item => item.name
                        },
                        {
                            title: "Solicitante",
                            dataIndex: "usuario",
                            width: 150,
                            render: item =>
                                item.trabajador.apellido_paterno +
                                " " +
                                item.trabajador.apellido_materno +
                                " " +
                                item.trabajador.nombre
                        },
                        /* {
                            title: "Motivo",
                            dataIndex: "motivo",
                            ellipsis: true,
                            render: item => item.descripcion
                        }, */
                        {
                            title: "Observación",
                            ellipsis: true,
                            dataIndex: "observacion"
                        },
                        {
                            title: "Estado",
                            dataIndex: "estado",
                            align: "center",
                            width: 130,
                            render: item =>
                                item === 0 ? (
                                    <Tag color="default">SOLICITADO</Tag>
                                ) : (
                                    item === 1 ? (
                                        <Tag color="blue">IMPRESO</Tag>
                                    ) : (
                                        <Tag color="green">TERMINADO</Tag>
                                    )
                                )
                        },
                        {
                            title: "Estado Documento",
                            dataIndex: "estado_documento",
                            ellipsis: true,
                            align: "center",
                            width: 130,
                            render: item =>
                                !isNull(item) ? (
                                    item == 0 ? (
                                        <Tag color="default">PENDIENTE</Tag>
                                    ) : (
                                        item == 1 ? (
                                            <Tag color="blue">ENVIADO</Tag>
                                        ) : (
                                            <Tag color="green">RECEPCIONADO</Tag>
                                        )
                                    )
                                ) : (
                                    "-"
                                )
                        },
                        {
                            title: "Acciones",
                            dataIndex: "acciones",
                            render: (_, record) => (
                                <div className="btn-group">
                                    {record.motivo.costo > 0 && (
                                        <Tooltip title="Ver CARTA DE DESCUENTO">
                                            <a
                                                className="btn btn-sm btn-primary"
                                                target="_blank"
                                                href={"/ficha/carta-descuento/" + record.id}
                                            >
                                                <i className="fas fa-search"></i>
                                            </a>
                                        </Tooltip>
                                    )}
                                    {!isNull(record.estado_documento) && record.estado_documento !== 2 && (
                                        <>
                                            <Tooltip title="Marcar como RECEPCIONADO">
                                                <button
                                                    className="btn btn-sm btn-warning"
                                                    onClick={() => confirmCambiarEstado(record)}
                                                >
                                                    <i className="fas fa-check"></i>
                                                </button>
                                            </Tooltip>
                                        </>
                                    )}
                                </div>
                            )
                        }
                    ]}
                />
            </Modal>
        </>
    );
};
