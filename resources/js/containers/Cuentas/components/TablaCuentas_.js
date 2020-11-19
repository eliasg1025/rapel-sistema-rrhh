import React, { useState, useEffect } from 'react';
import ReactDOM from "react-dom";
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';
import moment from 'moment';
import { DatePicker, message } from 'antd';

const TablaCuentas = ({ reloadData, setReloadData }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString()
    });
    const [cuentas, setCuentas] = useState([]);

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
                            .then(() => location.reload());
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
        let intentos = 0;
        function fetchCuentas() {
            intentos++;
            Axios.post('/api/cuenta/get-all', {
                usuario_id: usuario.id,
                desde: filtro.desde,
                hasta: filtro.hasta
            })
                .then(res => {
                    console.log(res.data);

                    message['success']({
                        content: `Se encontraron ${res.data.length} registros`
                    });

                    const cuentas = res.data.map(item => {
                        return {
                            ...item,
                            tipo: item.apertura ? 'APERTURA' : 'CAMBIO',
                            acciones: (
                                <div className="btn-group">
                                    <a className="btn btn-primary btn-sm" href={`/ficha/cambio-cuenta/${item.id}`} target="_blank">
                                        <i className="fas fa-search"/>
                                    </a>
                                    {item.fecha_solicitud === moment().format('YYYY-MM-DD') && (
                                        <>
                                            <a className="btn btn-primary btn-sm" href={`/cuentas/editar/${item.id}`} target="_blank">
                                                <i className="far fa-edit" />
                                            </a>
                                            <button className="btn btn-danger btn-sm" onClick={() => eliminarCuenta(item.id)}>
                                                <i className="fas fa-trash-alt" />
                                            </button>
                                        </>
                                    )}
                                </div>
                            )
                        }
                    });

                    setDatatable({
                        ...datatable,
                        rows: cuentas
                    });
                    setCuentas(cuentas);
                })
                .catch(err => {
                    console.log(err);
                    if (intentos < 5) {
                        fetchCuentas();
                    }
                })
        }
        fetchCuentas();
    }, [filtro.desde, filtro.hasta]);

    const [datatable, setDatatable] = useState({
        columns: [
            {
                label: 'Fecha Solicitud',
                field: 'fecha_solicitud',
                sort: 'disabled',
                width: 150
            },
            {
                label: 'RUT',
                field: 'rut',
                sort: 'disabled',
            },
            {
                label: 'Trabajador',
                field: 'nombre_completo',
                sort: 'disabled',
                width: 270,
            },
            {
                label: 'Tipo',
                field: 'tipo',
            },
            {
                label: 'Banco',
                field: 'banco_name',
                width: 200,
            },
            {
                label: 'Numero Cuenta',
                field: 'numero_cuenta',
                sort: 'asc',
                width: 100,
            },
            {
                label: 'Empresa',
                field: 'empresa',
                sort: 'disabled',
                width: 150,
            },
            {
                label: 'Acciones',
                field: 'acciones',
                sort: 'disabled'
            }
        ],
        rows: [],
    });

    const handleExportar = () => {
        const data = cuentas.map(item => {
            return {
                fecha_solicitud: item.fecha_solicitud,
                dni: item.rut,
                trabajador: item.nombre_completo,
                banco: item.banco_name,
                cuenta:  item.numero_cuenta?.toString() || '',
                empresa: item.empresa,
                usuario: item.nombre_completo_usuario || '',
                apertura: item.apertura ? 'SI' : ''
            }
        });
        Axios({
            url: '/descargar/cuentas',
            data: {data},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/pdf' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `CUENTAS-${filtro.desde}-${filtro.hasta}.xlsx`
                link.click()
            });
    };
    return (
        <>
            <div className="row">
                <div className="col-md-4">
                    <DatePicker.RangePicker
                        placeholder={['Desde', 'Hasta']}
                        style={{ width: '100%' }}
                        onChange={(date, dateString) => {
                            setFiltro({
                                ...filtro,
                                desde: dateString[0],
                                hasta: dateString[1],
                            });
                        }}
                        value={[moment(filtro.desde), moment(filtro.hasta)]}
                    />
                </div>
                <div className="col-md-2">
                    <button className="btn btn-success btn-sm" onClick={handleExportar}>
                        <i className="fas fa-file-excel"></i> Exportar
                    </button>
                </div>
            </div>
            <br />
            <MDBDataTableV5
                hover
                responsive
                entriesOptions={[10, 20, 25]}
                entries={10}
                pagesAmount={10}
                data={datatable}
                searchTop
                searchBottom={false}
            />
        </>
    );
}

const Tabla = props => {

}

export default TablaCuentas;

if (document.getElementById("tabla-cuentas")) {
    const element = document.getElementById("tabla-cuentas");
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<TablaCuentas {...props} />, document.getElementById("tabla-cuentas"));
}
