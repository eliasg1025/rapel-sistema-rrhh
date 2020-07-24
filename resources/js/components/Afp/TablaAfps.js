import React, { useState, useEffect } from 'react';
import { DatePicker, message } from 'antd';
import { MDBDataTableV5 } from 'mdbreact';
import moment from 'moment';
import Axios from 'axios';

const TablaAfps = props => {

    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString()
    });
    const [eleccionesAfp, setEleccionesAfp] = useState([]);

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
                    <button className="btn btn-success btn-sm">
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
                                    <a className="btn btn-primary btn-sm" href={`/eleccion-afp/editar/${item.id}`} target="_blank">
                                        <i className="far fa-edit" />
                                    </a>
                                    <button className="btn btn-danger btn-sm" onClick={() => console.log(item.id)}>
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
