import React, { useState, useEffect } from "react";
import { Table, DatePicker, Tag, Tooltip } from "antd";
import Axios from "axios";
import moment from 'moment';

export const TablaCuentas = ({ reloadData, setReloadData }) => {
    const { usuario, editar, submodule } = JSON.parse(
        sessionStorage.getItem("data")
    );
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString()
    });
    const [cuentas, setCuentas] = useState([]);

    const getColumns = () => {
        let columns = [
            {
                title: "Fecha Solicitud",
                dataIndex: "fecha_solicitud"
            },
            {
                title: "Empresa",
                dataIndex: "empresa"
            },
            {
                title: "RUT",
                dataIndex: "rut"
            },
            {
                title: "Trabajador",
                dataIndex: "nombre_completo"
            },
            {
                title: "Tipo",
                dataIndex: "apertura",
                render: (value) => value ? <Tag color="green">APERTURA</Tag> : <Tag color="blue">CAMBIO</Tag>
            },
            {
                title: "Banco",
                dataIndex: "banco_name"
            },
            {
                title: "Numero de Cuenta",
                dataIndex: "numero_cuenta",
                render: (_, record) => !record.apertura ? _ : <Tag color="default">-</Tag>
            }
        ]

        if (usuario.cuentas === 2) {
            columns.push({
                title: 'Cargado Por',
                dataIndex: 'nombre_completo_usuario'
            })
        }

        columns.push({
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (_, record) => (
                <div className="btn-group">
                        {!record.apertura && (
                            <Tooltip title="Ver documento">
                                <a className="btn btn-primary btn-sm" href={`/ficha/cambio-cuenta/${record.id}`} target="_blank">
                                    <i className="fas fa-search"/>
                                </a>
                            </Tooltip>
                        )}
                        <Tooltip title="Editar registro">
                            <a className="btn btn-primary btn-sm" href={`/cuentas/editar/${record.id}`} target="_blank">
                                <i className="far fa-edit" />
                            </a>
                        </Tooltip>
                        <Tooltip title="Borrar registro">
                            <button className="btn btn-danger btn-sm" onClick={() => eliminarCuenta(record.id)}>
                                <i className="fas fa-trash-alt" />
                            </button>
                        </Tooltip>
                    </div>
            )
        });

        return columns;
    }

    const eliminarCuenta = id => {
        Swal.fire({
            title: '¿Deseas eliminar este registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                Axios.delete(`/api/cuenta/${id}`)
                    .then(res => {
                        Swal.fire({
                            title: res.data.message,
                            icon: res.status < 400 ? 'success' : 'error'
                        })
                            .then(() => setReloadData(!reloadData));
                    })
                    .catch(err => {
                        console.log(err);
                        Swal.fire({
                            title: 'Error al borrar el registro',
                            icon: 'error'
                        });
                    });
            }
        })
    };

    useEffect(() => {
        const fetchCuentas = () => {
            Axios.post('/api/cuenta/get-all', {
                usuario_id: usuario.id,
                desde: filtro.desde,
                hasta: filtro.hasta,
            })
                .then(res => {
                    console.log(res);
                    setCuentas(res.data);
                })
                .catch(err => {
                    console.log(err);
                });
        }

        fetchCuentas();
    }, [filtro, reloadData]);

    const handleExportar = () => {
        const data = cuentas.map(item => {
            return {
                fecha_solicitud: item.fecha_solicitud,
                dni: item.rut,
                trabajador: item.nombre_completo,
                banco: item.banco_name,
                cuenta: item.numero_cuenta?.toString() || "",
                empresa: item.empresa,
                usuario: item.nombre_completo_usuario || "",
                apertura: item.apertura ? "SI" : ""
            };
        });
        Axios({
            url: "/descargar/cuentas",
            data: { data },
            method: "POST",
            responseType: "blob"
        }).then(response => {
            console.log(response);
            let blob = new Blob([response.data], { type: "application/pdf" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = `CUENTAS-${filtro.desde}-${filtro.hasta}.xlsx`;
            link.click();
        });
    };

    return (
        <>
            <div className="row">
                <div className="col-md-4">
                    <DatePicker.RangePicker
                        size="small"
                        allowClear={false}
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
                <div className="col-md-2">
                    <button
                        className="btn btn-success btn-sm"
                        onClick={handleExportar}
                    >
                        <i className="fas fa-file-excel"></i> Exportar
                    </button>
                </div>
            </div>
            <br />
            <Table columns={getColumns()} dataSource={cuentas} size="small" scroll={{ x: 500 }} />
        </>
    );
};
