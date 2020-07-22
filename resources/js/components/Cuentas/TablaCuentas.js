import React, { useState, useEffect } from 'react';
import ReactDOM from "react-dom";
import { MDBDataTableV5 } from 'mdbreact';
import Axios from 'axios';

const TablaCuentas = props => {
    const { usuario, cuentas } = JSON.parse(sessionStorage.getItem('data'));

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
        const c = cuentas.map(item => {
            return {
                ...item,
                acciones: (
                    <div className="btn-group">
                        <a className="btn btn-primary btn-sm" href={`/ficha/cambio-cuenta/${item.id}`} target="_blank">
                            <i className="fas fa-search"/>
                        </a>
                        <a className="btn btn-primary btn-sm" href={`/cuentas/editar/${item.id}`} target="_blank">
                            <i className="far fa-edit" />
                        </a>
                        <button className="btn btn-danger btn-sm" onClick={() => eliminarCuenta(item.id)}>
                            <i className="fas fa-trash-alt" />
                        </button>
                    </div>
                )
            }
        });
        setDatatable({
            ...datatable,
            rows: c
        });
    }, []);
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
};

export default TablaCuentas;

if (document.getElementById("tabla-cuentas")) {
    const element = document.getElementById("tabla-cuentas");
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<TablaCuentas {...props} />, document.getElementById("tabla-cuentas"));
}
