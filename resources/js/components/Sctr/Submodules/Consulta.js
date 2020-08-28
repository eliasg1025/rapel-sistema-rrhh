import React from 'react';
import { DatosPersonales } from '../Submodules/components/DatosPersonales';
import { BusquedaTrabajador } from './components/BusquedaTrabajador';

export const Consulta = () => {
    return (
        <>
            <div className="row">
                <div className="col-md-5 col-sm-12">
                    <BusquedaTrabajador />
                </div>
            </div>
            <br />
            <DatosPersonales
                trabajador={null}
            />
        </>
    );
}
