import React, { useState, useEffect } from 'react';
import { Radio } from 'antd';
import { BusquedaTrabajador } from './components/BusquedaTrabajador';
import { DatosPersonales } from './components/DatosPersonales';
import { Informacion } from './components/Informacion';
import { Periodos } from './components/Periodos';
import AutocompletarTrabajador from './components/AutocompletarTrabajador';

export const Consulta = () => {

    const [trabajador, setTrabajador] = useState(null);
    const [periodos, setPeriodos] = useState([]);
    const [alertas, setAlertas] = useState([]);
    const [tipoBusqueda, setTipoBusqueda] = useState('rut');

    const options = [
        { label: 'POR RUT', value: 'rut' },
        { label: 'POR NOMBRE Y APELLIDOS', value: 'nombres' },
    ];

    return (
        <>
            <div className="row">
                <div className="col">
                    <Radio.Group
                        size="small"
                        options={options}
                        onChange={e => setTipoBusqueda(e.target.value)}
                        value={tipoBusqueda}
                        optionType="button"
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-5 col-sm-12">
                    {tipoBusqueda === 'rut' ? (
                        <BusquedaTrabajador
                            setTrabajador={setTrabajador}
                            setPeriodos={setPeriodos}
                            setAlertas={setAlertas}
                        />
                    ) : (
                        <AutocompletarTrabajador
                            setTrabajador={setTrabajador}
                            setPeriodos={setPeriodos}
                            setAlertas={setAlertas}
                        />
                    )}
                </div>
            </div>
            <div className="row">
                <div className="col">
                    <DatosPersonales
                        trabajador={trabajador}
                    />
                </div>
            </div>
            <div className="row">
                <div className="col">
                    <Informacion
                        periodos={periodos}
                        alertas={alertas}
                    />
                    <br />
                    <Periodos
                        periodos={periodos}
                    />
                </div>
            </div>
        </>
    );
}
