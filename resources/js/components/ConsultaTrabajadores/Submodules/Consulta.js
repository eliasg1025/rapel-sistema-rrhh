import React, { useState, useEffect } from 'react';
import { BusquedaTrabajador } from './components/BusquedaTrabajador';
import { DatosPersonales } from './components/DatosPersonales';
import { Informacion } from './components/Informacion';
import { Periodos } from './components/Periodos';

export const Consulta = () => {

    const [trabajador, setTrabajador] = useState(null);
    const [periodos, setPeriodos] = useState([]);
    const [alertas, setAlertas] = useState([]);

    return (
        <>
            <div className="row">
                <div className="col-md-5 col-sm-12">
                    <BusquedaTrabajador
                        setTrabajador={setTrabajador}
                        setPeriodos={setPeriodos}
                        setAlertas={setAlertas}
                    />
                </div>
            </div>
            <div className="row">
                <div className="col-md-5 col-sm-12">
                    <DatosPersonales
                        trabajador={trabajador}
                    />
                </div>
                <div className="col-md-7 col-sm-12">
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
