import React, { useState, useEffect } from 'react';
import { DatePicker, message } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import moment from 'moment';
import Axios from 'axios';
import Swal from 'sweetalert2';

const TablaAfps = props => {

    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString()
    });
    const [eleccionesAfp, setEleccionesAfp] = useState([]);

    const handleExportar = () => {
        const data = eleccionesAfp.map(item => {
            return {
                fecha_solicitud: item.fecha_solicitud,
                dni: item.rut,
                trabajador: item.nombre_completo,
                empresa: item.empresa
            }
        });
        Axios({
            url: '/descargar/elecciones-afp',
            data: {data},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `ELECIONES-AFP-${filtro.desde}-${filtro.hasta}.xlsx`
                link.click()
            })
    };

    return (
        <>
            <div className="row">
                <div className="col-md-4">
                    <DatePicker.RangePicker
                        placeholder={['Desde', 'Hasta']}
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
            <Tabla
                {...props}
                {...filtro}
                setEleccionesAfp={setEleccionesAfp}
            />
        </>
    );
};

export default TablaAfps;


const Tabla = props => {

    const { usuario, desde, hasta, setEleccionesAfp } = props;

    const eliminarEleccionAfp = id => {
        Swal.fire({
            title: '¿Deseas eliminar este registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrarlo',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.delete(`/api/eleccion-afp/${id}`)
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

    let _columns = [];
    if (usuario.afp === 1) {
        _columns = [
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
        ];
    } else if (usuario.afp === 2) {
        _columns = [
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
                label: 'Empresa',
                field: 'empresa',
                sort: 'disabled',
                width: 150,
            },
            {
                label: 'Cargado por',
                field: 'nombre_completo_usuario',
                sort: 'disabled'
            },
            {
                label: 'Acciones',
                field: 'acciones',
                sort: 'disabled'
            }
        ];
    } else {

    }

    const [datatable, setDatatable] = useState({
        columns: _columns,
        rows: []
    });

    useEffect(() => {
        let intentos = 0;
        function fetchEleccionesAfp() {
            intentos++;
            Axios.post('/api/eleccion-afp/get-all', {
                usuario_id: usuario.id,
                desde,
                hasta,
            })
                .then(res => {
                    const { data } = res;
                    console.log(data);

                    message['success']({
                        content: `Se encontraron ${data.length} registros`
                    });

                    const eleccion_afp = data.map(item => {
                        return {
                            ...item,
                            acciones: (
                                <div className="btn-group">
                                    <a className="btn btn-primary btn-sm" href={`/ficha/eleccion-afp/${item.id}`} target="_blank">
                                        <i className="fas fa-search"/>
                                    </a>
                                    <button className="btn btn-danger btn-sm" onClick={() => eliminarEleccionAfp(item.id)}>
                                        <i className="fas fa-trash-alt" />
                                    </button>
                                </div>
                            )
                        }
                    });

                    setDatatable({
                        ...datatable,
                        rows: eleccion_afp
                    });
                    setEleccionesAfp(eleccion_afp);
                })
                .catch(err => {
                    console.error(err);
                    if (intentos < 5) {
                        fetchEleccionesAfp();
                    }
                });
        }

        fetchEleccionesAfp();
    }, [desde, hasta])

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
