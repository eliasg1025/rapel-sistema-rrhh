import React, { useState, useEffect } from "react";
import {
    CheckCircleOutlined,
    SyncOutlined,
    CloseCircleOutlined,
    ClockCircleOutlined
} from "@ant-design/icons";
import { DatePicker, Select, Table, Tag } from "antd";
import moment from "moment";

import { empresa } from "../../../data/default.json";
import Axios from "axios";
import { data } from "jquery";
import { forEach } from "lodash";

export const Pagados = () => {
    const [liquidaciones, setLiquidaciones] = useState([]);
    const [bancos, setBancos] = useState([]);
    const [filter, setFilter] = useState({
        banco: "TODOS",
        empresa_id: 9,
        fecha_pago: moment()
            .format("YYYY-MM-DD")
            .toString(),
        rut: ""
    });
    const [loading, setLoading] = useState(false);
    const [reloadData, setReloadData] = useState(false);
    const [selectedRowKeys, setSelectedRowKeys] = useState([]);

    const columns = [
        {
            title: "Tipo",
            dataIndex: "tipo_pago"
        },
        {
            title: "Empresa",
            dataIndex: "empresa"
        },
        {
            title: "Periodo",
            dataIndex: "periodo",
            render: (_, record) => `${record.mes} - ${record.ano}`
        },
        {
            title: "RUT",
            dataIndex: "rut"
        },
        {
            title: "Nombre Completo",
            dataIndex: "nombre_completo",
            render: (_, record) =>
                `${record.apellido_paterno} ${record.apellido_materno} ${record.nombre}`
        },
        {
            title: "Monto",
            dataIndex: "monto"
        },
        {
            title: "Banco",
            dataIndex: "banco"
        },
        {
            title: "Numero Cuenta",
            dataIndex: "numero_cuenta"
        },
        {
            title: "Estado",
            dataIndex: "estado",
            render: (_, record) => renderTags(record.estado)
        }
    ];

    useEffect(() => {
        Axios.get(
            `/api/pagos/get-pagados?empresa_id=${filter.empresa_id}&fecha_pago=${filter.fecha_pago}&rut=${filter.rut}&banco=${filter.banco}`
        )
            .then(res => {
                setLiquidaciones(res.data);
            })
            .catch(err => {
                console.error(err);
            });
    }, [filter, reloadData]);

    useEffect(() => {
        Axios.get(`/api/banco/${filter.empresa_id}`)
            .then(res => {
                // console.log(res);
                setBancos(res.data);
            })
            .catch(err => {
                console.error(err);
            });
    }, [filter.empresa_id]);

    function renderTags(estado) {
        switch (estado) {
            case 0:
                return (
                    <Tag color="default" icon={<ClockCircleOutlined />}>
                        PENDIENTE
                    </Tag>
                );
            case 1:
                return (
                    <Tag color="warning" icon={<ClockCircleOutlined />}>
                        FIRMADO
                    </Tag>
                );
            case 2:
                return (
                    <Tag color="processing" icon={<SyncOutlined spin />}>
                        PARA PAGO
                    </Tag>
                );
            case 3:
                return (
                    <Tag color="success" icon={<CheckCircleOutlined />}>
                        PAGADO
                    </Tag>
                );
            case 4:
                return (
                    <Tag color="error" icon={<CloseCircleOutlined />}>
                        RECHAZADO
                    </Tag>
                );
            default:
                return null;
        }
    }

    const onSelectChange = selectedRowKeys => {
        setSelectedRowKeys(selectedRowKeys);
    };

    const terminarProceso = () => {
        Axios.post(`/api/pagos/terminar-proceso`, {
            liquidaciones: liquidaciones
                .filter(e => e.tipo_pago === "LIQUIDACION")
                .map(e => e.id),
            utilidades: liquidaciones
                .filter(e => e.tipo_pago === "UTILIDAD")
                .map(e => e.id)
        })
            .then(res => {
                console.log(res);
                setReloadData(!reloadData);
                setSelectedRowKeys([]);

                Swal.fire("Proceso completado", "", "info");
            })
            .catch(err => {
                console.log(err);
            });
    };

    const handleMassiveTerminar = () => {
        Swal.fire({
            title: `Terminar proceso`,
            html: `
                Las liquidaciones con estado <b><u>PAGADO</u></b> pasarán a ser <b><u>ARCHIVADAS</u></b> y las que tienen estado <b><u>RECHAZADO</u></b> volverán a ser procesadas.
            `,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "Cancelar"
        })
            .then(res => {
                if (res.value) {
                    terminarProceso();
                }
            })
            .catch(err => {
                console.error(err);
            });
    };

    const toggleRechazo = (tipo = 0) => {
        const liq = liquidaciones
            .filter(e => e.tipo_pago === "LIQUIDACION")
            .map(e => e.id);
        const uti = liquidaciones
            .filter(e => e.tipo_pago === "UTILIDAD")
            .map(e => e.id);

        Axios.put(`/api/pagos/toggle-rechazo/${tipo}`, {
            liquidaciones: selectedRowKeys.filter(e => liq.includes(e)),
            utilidades: selectedRowKeys.filter(e => uti.includes(e))
        })
            .then(res => {
                console.log(res);
                setReloadData(!reloadData);
                setSelectedRowKeys([]);
            })
            .catch(err => {
                console.error(err);
            });
    };

    const handleMassiveDesmarcarRechazo = () => {
        toggleRechazo(0);
    };

    const handleMassiveMarcarRechazo = () => {
        toggleRechazo(1);
    };

    const rowSelection = {
        selectedRowKeys,
        onChange: onSelectChange
    };
    const hasSelected = selectedRowKeys.length > 0;

    return (
        <>
            <h4>Pagados</h4>
            <br />
            <div className="card">
                <div className="card-body">
                    <form>
                        <div className="form-row">
                            <div className="col-md-3 col-sm-4">
                                Empresa:
                                <br />
                                <Select
                                    value={filter.empresa_id}
                                    showSearch
                                    style={{ width: "100%" }}
                                    optionFilterProp="children"
                                    filterOption={(input, option) =>
                                        option.children
                                            .toLowerCase()
                                            .indexOf(input.toLowerCase()) >= 0
                                    }
                                    onChange={e =>
                                        setFilter({ ...filter, empresa_id: e })
                                    }
                                >
                                    {empresa.map(e => (
                                        <Select.Option value={e.id} key={e.id}>
                                            {`${e.id} - ${e.name}`}
                                        </Select.Option>
                                    ))}
                                </Select>
                            </div>
                            <div className="col-md-3 col-sm-4">
                                Fecha Pago:
                                <br />
                                <DatePicker
                                    style={{ width: "100%" }}
                                    placeholder={"Fecha Pago"}
                                    allowClear={false}
                                    onChange={(date, dateString) =>
                                        setFilter({
                                            ...filter,
                                            fecha_pago: dateString
                                        })
                                    }
                                    value={moment(filter.fecha_pago)}
                                />
                            </div>
                            <div className="col-md-3 col-sm-4">
                                Banco:
                                <br />
                                <Select
                                    value={filter.banco}
                                    showSearch
                                    style={{ width: "100%" }}
                                    optionFilterProp="children"
                                    filterOption={(input, option) =>
                                        option.children
                                            .toLowerCase()
                                            .indexOf(input.toLowerCase()) >= 0
                                    }
                                    onChange={e =>
                                        setFilter({ ...filter, banco: e })
                                    }
                                >
                                    <Select.Option value="TODOS" key="TODOS">
                                        {`TODOS`}
                                    </Select.Option>
                                    {bancos.map(e => (
                                        <Select.Option
                                            value={e.name}
                                            key={e.name}
                                        >
                                            {`${e.name}`}
                                        </Select.Option>
                                    ))}
                                </Select>
                            </div>
                            {/*
                            <div className="col-md-3">
                                Buscar por RUT:
                                <input
                                    className="form-control"
                                    value={filter.rut} onChange={e => setFilter({ ...filter, rut: e.target.value })}
                                />
                            </div>
                            */}
                        </div>
                    </form>
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col">
                    <h5><u>Detalle:</u></h5>
                    <TablaBancos filter={filter} />
                </div>
            </div>
            <br />
            <div style={{ marginBottom: 16 }}>
                <button
                    className="btn btn-danger"
                    disabled={!hasSelected}
                    onClick={handleMassiveMarcarRechazo}
                >
                    {loading ? (
                        <>
                            <span
                                className="spinner-border spinner-border-sm"
                                role="status"
                                aria-hidden="true"
                            ></span>
                            <span className="sr-only">Cargando...</span>
                        </>
                    ) : (
                        <span>
                            <i className="fas fa-times"></i> RECHAZO
                        </span>
                    )}
                </button>
                <button
                    className="btn btn-primary"
                    disabled={!hasSelected}
                    onClick={handleMassiveDesmarcarRechazo}
                >
                    {loading ? (
                        <>
                            <span
                                className="spinner-border spinner-border-sm"
                                role="status"
                                aria-hidden="true"
                            ></span>
                            <span className="sr-only">Cargando...</span>
                        </>
                    ) : (
                        <span>
                            <i className="fas fa-check"></i> NO RECHAZO
                        </span>
                    )}
                </button>
                <span style={{ marginLeft: 8 }}>
                    {hasSelected
                        ? `${selectedRowKeys.length} item(s) seleccionados`
                        : ""}
                </span>

                <button
                    className="btn btn-success"
                    onClick={handleMassiveTerminar}
                    style={{ float: "right" }}
                >
                    {loading ? (
                        <>
                            <span
                                className="spinner-border spinner-border-sm"
                                role="status"
                                aria-hidden="true"
                            ></span>
                            <span className="sr-only">Cargando...</span>
                        </>
                    ) : (
                        <span>
                            <i className="fas fa-flag-checkered"></i>{" "}
                            <b>TERMINAR PROCESO</b>
                        </span>
                    )}
                </button>
            </div>
            <Table
                dataSource={liquidaciones}
                rowSelection={rowSelection}
                pagination={{ pageSize: 25 }}
                columns={columns}
                scroll={{ x: 500 }}
                size="small"
            />
        </>
    );
};

const TablaBancos = ({ filter }) => {
    const [tabla, setTabla] = useState([]);

    useEffect(() => {
        Axios.get(
            `/api/pagos/get-pagados/tabla?empresa_id=${filter.empresa_id}&fecha_pago=${filter.fecha_pago}&banco=${filter.banco}`
        )
            .then(res => {
                const { liquidaciones, utilidades } = res.data;

                const bancosNoRepetidosSet = new Set([
                    ...liquidaciones.map(item => item.banco),
                    ...utilidades.map(item => item.banco)
                ]);

                const bancosNoRepetidos = Array.from(bancosNoRepetidosSet);

                const data = bancosNoRepetidos.map(item => {
                    const l = liquidaciones.find(p => p.banco === item);
                    const u = utilidades.find(p => p.banco === item);

                    //console.log(l, u);
                    return {
                        banco: item,
                        monto: Math.round( ((l?.monto || 0) + (u?.monto || 0)) * 100) / 100,
                        cantidad: (l?.cantidad || 0) + (u?.cantidad || 0),
                    }
                });

                setTabla(data);
            })
            .catch(err => {
                console.error(err);
            });
    }, [filter]);

    return (
        <div className="table-responsive">
            <table className="table table-bordered table-sm">
                <thead className="thead-dark">
                    <tr>
                        <th>Bancos</th>
                        <th>Cantidad</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    {tabla.map(item => (
                        <tr key={item.banco}>
                            <td>{ item.banco }</td>
                            <td>{ item.cantidad }</td>
                            <td>{ item.monto }</td>
                        </tr>
                    ))}
                    <tr className="table-primary">
                        <td><b>TOTAL</b></td>
                        <td><b>{ tabla.reduce((acc, cur) => acc + cur.cantidad, 0) }</b></td>
                        <td><b>{ tabla.reduce((acc, cur) => acc + cur.monto, 0) }</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    );
};
