import React, { useState } from "react";
import { Table, DatePicker, Input, Select, Modal, Tag, Tooltip } from "antd";
import moment from "moment";
import Axios from "axios";

export const TablaRegistros = ({
    data,
    setData,
    filtro,
    setFiltro,
    loading,
    handleCambiarEstado,
    handleEliminar
}) => {

    const [selectedRowKeys, setSelectedRowKeys] = useState([]);

    const columns = [
        {
            title: "Empresa",
            dataIndex: "empresa",
            render: item => item.shortname
        },
        {
            title: "Fecha",
            dataIndex: "fecha_solicitud"
        },
        {
            title: "DNI",
            dataIndex: "trabajador",
            render: item => item.rut
        },
        {
            title: "Apellidos y Nombres",
            dataIndex: "trabajador",
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
            render: item => item.name
        },
        {
            title: "Fundo",
            dataIndex: "zona_labor",
            render: item => item.name
        },
        {
            title: "Solicitante",
            dataIndex: "usuario",
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
            render: item => item.descripcion
        },
        {
            title: "Costo",
            dataIndex: "motivo",
            render: item => item.costo
        },
        {
            title: "Color",
            dataIndex: "color",
            render: item => item.color
        },
        {
            title: "Observación",
            dataIndex: "observacion"
        },
        {
            title: "Estado",
            dataIndex: "estado",
            render: item => (item === 0 ? <Tag color="blue">GENERADO</Tag> : <Tag color="green">ENVIADO</Tag>)
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
                                <i className="fas fa-file-alt"></i>
                            </a>
                        </Tooltip>
                    )}
                    {record.estado === 0 && (
                        <>
                            <Tooltip title="Marcar como ENVIADO">
                                <button
                                    className="btn btn-sm btn-primary"
                                    onClick={() => confirmCambiarEstado(record)}
                                >
                                    <i className="fas fa-check"></i>
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
            "OBSERVACION"
        ];

        const d = data.map(item => {
            return {
                empresa: item.empresa.name,
                fecha_solicitud: item.fecha_solicitud,
                dni: item.trabajador.rut,
                trabajador:
                    item.trabajador.apellido_materno +
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
                observacion: item?.observacion || ""
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
            title: 'Marcar Enviado',
            content: '¿Desea marcar este registro como enviado?',
            okText: 'Si, MARCAR COMO ENVIADO',
            cancelText: 'Cancelar',
            onOk: () => handleCambiarEstado(record.id, 1)
        });
    }

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
                Cantidad: {data.length} registros {selectedRowKeys.length > 0 && `(${selectedRowKeys.length} seleccionados)`}&nbsp;
                <button
                    className="btn btn-success btn-sm"
                    onClick={handleExportar}
                >
                    <i className="fas fa-file-excel" /> Exportar
                </button>
                {selectedRowKeys.length > 0 && (
                    <button
                        className="ml-2 btn btn-primary btn-sm"
                    >
                        <i className="fas fa-file" /> Generar planilla manual
                    </button>
                )}
            </b>
            <br />
            <br />
            <Table
                rowSelection={{
                    onChange: selectedRowKeys => setSelectedRowKeys(selectedRowKeys),
 /*                    getCheckboxProps: (record) => ({
                        disabled: record.
                    }) */
                }}
                size="small"
                scroll={{ x: 1000 }}
                bordered
                columns={columns}
                dataSource={data}
                loading={loading}
            />
        </>
    );
};
