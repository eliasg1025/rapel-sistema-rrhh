import React, { useState } from 'react';
import { DatosPersonales } from '../Submodules/components/DatosPersonales';
import { BusquedaTrabajador } from './components/BusquedaTrabajador';
import { InfoSctr } from './components/InfoSctr';

export const Consulta = () => {

    const [trabajador, setTrabajador] = useState(null);
    const [contratos, setContratos] = useState([]);
    const [sctr, setSctr] = useState(false);

    return (
        <>
            <div className="row">
                <div className="col-md-5 col-sm-12">
                    <BusquedaTrabajador
                        setTrabajador={setTrabajador}
                        setContratos={setContratos}
                        setSctr={setSctr}
                    />
                </div>
            </div>
            <br />
            <InfoSctr
                trabajador={trabajador}
                contratos={contratos}
                sctr={sctr}
            />
            <DatosPersonales
                trabajador={trabajador}
            />
        </>
    );
}
