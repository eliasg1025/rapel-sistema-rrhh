import React, { useState, useEffect } from 'react';
import moment from 'moment';
import ReactDOM from "react-dom";
import { DatePicker, message } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';

const TablaCuentasAdmin = props => {
    const data = JSON.parse(sessionStorage.getItem('data'));
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString()
    });

    return (
        <>
            <div>
                <DatePicker.RangePicker
                    placeholder={['Desde', 'Hasta']}
                    onChange={(date, dateString) => {
                        setFiltro({
                            ...filtro,
                            desde: dateString[0],
                            hasta: dateString[1],
                        });
                    }}
                    //value={[filtro.desde, filtro.hasta]}
                />
            </div>
            <Tabla {...data} {...filtro}/>
        </>
    );
};

const Tabla = props => {
    const { usuario, cuentas, desde, hasta } = props;

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
                label: 'Cargado por',
                field: 'nombre_completo_usuario',
                sort: 'disabled'
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
        rows: [
        ],
    });
    useEffect(() => {
        let intentos = 0;
        function fetchCuentas() {
            intentos++;
            Axios.post('/api/cuenta/get-all', {
                usuario_id: usuario.id,
                desde: desde,
                hasta: hasta,
            })
                .then(res => {
                    console.log(res.data);

                    message['success']({
                        content: `Se encontraron ${res.data.length} registros`
                    });

                    const cuentas = res.data.map(item => {
                        return {
                            ...item,
                            acciones: (
                                <div className="btn-group">
                                    <a className="btn btn-primary btn-sm" href={`/ficha/cambio-cuenta/${item.id}`} target="_blank">
                                        <i className="fas fa-search"/>
                                    </a>
                                    <button className="btn btn-primary btn-sm">
                                        <i className="far fa-edit" />
                                    </button>
                                    <button className="btn btn-danger btn-sm" onClick={() => eliminarCuenta(item.id)}>
                                        <i className="fas fa-trash-alt" />
                                    </button>
                                </div>
                            )
                        }
                    });

                    setDatatable({
                        ...datatable,
                        rows: cuentas
                    })
                })
                .catch(err => {
                    console.log(err);
                    if (intentos < 5) {
                        fetchCuentas();
                    }
                });
        }
        fetchCuentas();
    }, [desde, hasta]);

    return (
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
    );
}

export default TablaCuentasAdmin;

if (document.getElementById("tabla-cuentas-admin")) {
    const element = document.getElementById("tabla-cuentas-admin");
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<TablaCuentasAdmin {...props} />, document.getElementById("tabla-cuentas-admin"));
}
