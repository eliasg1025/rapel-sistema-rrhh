import React, { useState } from "react";
import { Table, DatePicker, Input, Select, Modal, Tag, Tooltip } from "antd";
import moment from "moment";
import Axios from "axios";
import { isNull } from "lodash";

export const TablaRegistros = ({
    data,
    setData,
    filtro,
    setFiltro,
    loading,
    handleCambiarEstado,
    handleEliminar,
    handleGenerarPlanillaManual
}) => {
    const [selectedRowKeys, setSelectedRowKeys] = useState([]);

    const columns = [
        {
            title: "Empresa",
            dataIndex: "empresa",
            width: 60,
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
            ellipsis: true,
            render: item =>
                item.apellido_paterno +
                " " +
                item.apellido_materno +
                " " +
                item.nombre
        },
        {
            title: "Régimen",
            dataIndex: "regimen",
            ellipsis: true,
            render: item => item.name
        },
        {
            title: "Fundo",
            dataIndex: "zona_labor",
            ellipsis: true,
            render: item => item.name
        },
        {
            title: "Solicitante",
            dataIndex: "usuario",
            ellipsis: true,
            render: item =>
                item.trabajador.apellido_paterno +
                " " +
                item.trabajador.apellido_materno +
                " " +
                item.trabajador.nombre
        },
        {
            title: "Motivo",
            dataIndex: "motivo",
            ellipsis: true,
            render: item => item.descripcion
        },
        {
            title: "Costo",
            dataIndex: "motivo",
            width: 50,
            render: item => item.costo
        },
        {
            title: "Color",
            dataIndex: "color",
            width: 70,
            render: item => item.color
        },
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
                    {record.estado === 0 && (
                        <>
                            {!isNull(record.estado_documento) &&
                                record.estado_documento === 0 && (
                                    <Tooltip title="Marcar DOCUMENTO como ENVIADO">
                                        <button
                                            className="btn btn-sm btn-outline-primary"
                                            onClick={() =>
                                                confirmCambiarEstado(record)
                                            }
                                        >
                                            <i className="fas fa-check"></i>
                                        </button>
                                    </Tooltip>
                                )}
                            <Tooltip title="Eliminar Registro">
                                <button
                                    className="btn btn-sm btn-danger"
                                    onClick={() => confirmEliminar(record)}
                                >
                                    <i className="fas fa-trash"></i>
                                </button>
                            </Tooltip>
                        </>
                    )}
                </div>
            )
        }
    ];

    const handleExportar = () => {
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
            "ESTADO DOCUMENTO"
        ];

        const d = data.map(item => {
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
                "REGISTROS-FOTOCHECKS_" +
                filtro.desde +
                "_" +
                filtro.hasta +
                ".xlsx";
            link.click();
        });
    };

    const confirmGenerarPlanillaManual = () => {
        Modal.confirm({
            title: "Generar Planilla Manual",
            content: `¿Desea generar planilla manual a estos ${selectedRowKeys.length} registros?`,
            okText: "Si, GENERAR",
            cancelText: "Cancelar",
            onOk: () => handleGenerarPlanillaManual(selectedRowKeys)
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

    const confirmCambiarEstado = record => {
        Modal.confirm({
            title: "Marcar Enviado",
            content: "¿Desea marcar este registro como enviado?",
            okText: "Si, MARCAR COMO ENVIADO",
            cancelText: "Cancelar",
            onOk: () => handleCambiarEstado(record.id, 1)
        });
    };

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
                    Tipo:
                    <br />
                    <Select
                        value={filtro.tipo}
                        showSearch
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setFiltro({ ...filtro, tipo: e })}
                        style={{
                            width: "100%"
                        }}
                    >
                        {[
                            { id: "TODOS" },
                            { id: "CON DESCUENTO" },
                            { id: "SIN DESCUENTO" }
                        ].map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id}`}
                            </Select.Option>
                        ))}
                    </Select>
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
                {selectedRowKeys.length > 0 &&
                    `(${selectedRowKeys.length} seleccionados)`}
                &nbsp;
                <button
                    className="btn btn-success btn-sm"
                    onClick={handleExportar}
                >
                    <i className="fas fa-file-excel" /> Exportar
                </button>
                {selectedRowKeys.length > 0 && (
                    <button
                        className="ml-2 btn btn-primary btn-sm"
                        onClick={confirmGenerarPlanillaManual}
                    >
                        <i className="fas fa-file" /> Generar planilla manual
                    </button>
                )}
            </b>
            <br />
            <br />
            <Table
                rowSelection={{
                    onChange: selectedRowKeys =>
                        setSelectedRowKeys(selectedRowKeys)
                    /*                    getCheckboxProps: (record) => ({
                        disabled: record.
                    }) */
                }}
                size="small"
                scroll={{ x: 1200 }}
                bordered
                columns={columns}
                dataSource={data}
                loading={loading}
            />
        </>
    );
};
