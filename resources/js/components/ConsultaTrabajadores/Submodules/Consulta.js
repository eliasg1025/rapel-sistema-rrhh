import React from 'react';
import { BusquedaTrabajador } from './components/BusquedaTrabajador';
import { DatosPersonales } from './components/DatosPersonales';
import { Informacion } from './components/Informacion';
import { Periodos } from './components/Periodos';

export const Consulta = () => {
    return (
        <div className="row">
            <div className="col-md-5">
                <BusquedaTrabajador />
                <br />
                <DatosPersonales />
            </div>
            <div className="col-md-7">
                <Informacion />
                <br />
                <Periodos />
            </div>
        </div>
    );
}
