import React, { useEffect, useState } from "react";
import Axios from "axios";
import { Table } from "antd";

import Modal from '../../Modal';
import { isEmpty } from "lodash";

export const GenerarArchivoBanco = ({
    d,
    data,
    filtro,
    reloadData,
    setReloadData,
    setIsVisibleParent,
    reloadDataAB,
    setReloadDataAB
}) => {
    const [loading, setLoading] = useState(false);
    const [loadingTable, setLoadingTable] = useState(false);
    const [bancos, setBancos] = useState([]);
    const [canGenerate, setCanGenerate] = useState(false);
    const [isVisibleErrors, setIsVisibleErrors] = useState(false);
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        const arr = [];
        for (const key in data) {
            const group = data[key];
            arr.push({
                key,
                banco: key,
                cantidad: group.length,
                monto: obtenerMonto(group)
            });
        }

        setBancos(arr);
    }, []);

    const generarArchivosBanco = () => {
        Swal.fire({
            title: "Generando archivos",
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        setLoading(true);
        Axios.post("/api/pagos/generar-archivos-banco", { filtro, data })
            .then(res => {
                console.log(res);

                const { bcp, banbif, scotiabank, bbva, interbank } = res.data;

                setLoading(false);
                Swal.fire({
                    title: "Proceso completado",
                    icon: "info",
                    html: `
                        <ul>
                            <li><b>BCP: </b> ${bcp.message}</li>
                            <li><b>INTERBANK: </b> ${interbank.message}</li>
                            <li><b>BBVA: </b> ${bbva.message}</li>
                            <li><b>SCOTIABANK: </b> ${scotiabank.message}</li>
                            <li><b>BANBIF: </b> ${banbif.message}</li>
                        </ul>
                    `
                }).then(res => {
                    setIsVisibleParent(false);
                    setReloadDataAB(!reloadDataAB);
                });
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
                Swal.fire("Error al actualizar el estado", "", "error");
            });
    };

    const generarArchivosTXT = () => {
        setLoading(true);
    };

    const obtenerMonto = arr => {
        const reducer = (p, c) => p + c.monto;
        const monto = arr.reduce(reducer, 0);

        return Math.round(monto * 100) / 100;
    };

    const validar = () => {
        setLoadingTable(true);
        Axios.post("/api/pagos/archivos-banco/validar", { filtro, data })
            .then(res => {
                const result = res.data;

                setBancos(bancos.map(item => {
                    return {
                        ...item,
                        resultados: result[item.banco],
                        errors: result[item.banco]?.errors
                    }
                }));

                setLoadingTable(false);
                setCanGenerate(true);
            })
            .catch(err => console.error(err));
    };

    const columns = [
        {
            title: "Banco",
            dataIndex: "banco",
            render: (value) => `${value.toUpperCase()}`
        },
        {
            title: "Cantidad",
            dataIndex: "cantidad",
            align: "right"
        },
        {
            title: "Monto",
            dataIndex: "monto",
            render: (value, record) => `S/. ${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ','),
            align: "right"
        },
        {
            title: "Resultados",
            dataIndex: "resultados",
            align: "right",
            render: (value, record) => {
                return (
                    <span>
                        {value?.errors.length === 0 ? (
                            <i className="fas fa-check" style={{ color: 'green' }}></i>
                        ) : (
                            <>
                                <i className="fas fa-times" style={{ color: 'red' }}></i>
                            </>
                        )}{" "}{value?.message || ''}{" "}
                        {value?.errors.length > 0 && (
                            <button className="btn btn-sm btn-light" type="button" onClick={e => {
                                e.preventDefault();
                                setErrors(record.errors);
                                setIsVisibleErrors(true);
                            }}>
                                <b>+</b>
                            </button>
                        )}
                    </span>
                );
            }
        }
    ];

    return (
        <>
            <form>
                <div className="form-row">
                    <div className="col m-auto">
                        <Table
                            size="small"
                            bordered
                            columns={columns}
                            dataSource={bancos}
                            pagination={false}
                            loading={loadingTable}
                            footer={() => (
                                <small>
                                    <b>
                                        <u>Nota:</u>
                                    </b>{" "}
                                    No se cuentan las liquidaciones/utilidades con
                                    monto igual a 0
                                </small>
                            )}
                        />
                        {/*
                            <tr className="table-primary">
                                <td>
                                    <b>TOTAL</b>
                                </td>
                                <td>
                                    <b>
                                        {data.banbif.length +
                                            data.bbva.length +
                                            data.bcp.length +
                                            data.scotiabank.length +
                                            data.interbank.length}
                                    </b>
                                </td>
                                <td className="">
                                    <b>
                                        {Math.round(
                                            (obtenerMonto(data.bcp) +
                                                obtenerMonto(
                                                    data.interbank
                                                ) +
                                                obtenerMonto(
                                                    data.scotiabank
                                                ) +
                                                obtenerMonto(data.bbva) +
                                                obtenerMonto(data.banbif)) *
                                                100
                                        ) / 100}
                                    </b>
                                </td>
                            </tr>
                        */}
                    </div>
                </div>
                <br />
                <div className="form-row">
                    <div className="col text-center">
                        {filtro.desde !== filtro.hasta && (
                            <span style={{ fontWeight: "bold", color: "red" }}>
                                Sólo se puede procesar 1 fecha de pago a la vez
                            </span>
                        )}
                        <div className="btn-group" style={{ width: "100%" }}>
                            <button
                                className="btn btn-primary"
                                type="button"
                                disabled={filtro.desde !== filtro.hasta || loading}
                                onClick={validar}
                            >
                                {!loading ? (
                                    <span>
                                        <i className="fas fa-tasks"></i> Validar pagos
                                    </span>
                                ) : (
                                    <>
                                        <i className="fas fa-spinner fa-spin" />
                                        &nbsp;Cargando
                                    </>
                                )}
                            </button>
                            <button
                                className="btn btn-primary"
                                type="button"
                                disabled={filtro.desde !== filtro.hasta || loading || !canGenerate}
                                onClick={generarArchivosBanco}
                            >
                                {!loading ? (
                                    <span>
                                        <i className="far fa-file-excel"></i>{" "}
                                        Generar archivos
                                    </span>
                                ) : (
                                    <>
                                        <i className="fas fa-spinner fa-spin" />
                                        &nbsp;Cargando
                                    </>
                                )}
                            </button>
                            <button
                                className="btn btn-primary"
                                type="button"
                                disabled={filtro.desde !== filtro.hasta || loading || !canGenerate}
                                onClick={validar}
                            >
                                {!loading ? (
                                    <span>
                                        <i className="far fa-file-alt"></i> Generar
                                        TXT
                                    </span>
                                ) : (
                                    <>
                                        <i className="fas fa-spinner fa-spin" />
                                        &nbsp;Cargando
                                    </>
                                )}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <Modal
                title="Errores"
                isVisible={isVisibleErrors}
                setIsVisible={setIsVisibleErrors}
            >
                <TableErrors
                    errors={errors}
                />
            </Modal>
        </>
    );
};

const TableErrors = ({ errors }) => {

    const columns = [
        {
            title: 'RUT',
            dataIndex: 'rut'
        },
        {
            title: 'Mes',
            dataIndex: 'mes'
        },
        {
            title: 'Año',
            dataIndex: 'año'
        },
        {
            title: 'Número Cuenta',
            dataIndex: 'numero_cuenta'
        }
    ];

    return (
        <Table
            columns={columns}
            dataSource={errors}
            pagination={false}
            size="small"
        />
    );
}
