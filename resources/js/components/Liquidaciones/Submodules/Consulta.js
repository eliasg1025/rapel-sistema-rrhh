import React, { useState } from 'react';
import BuscarTrabajador from '../../shared/BuscarTrabajador';
import { InfoTrabajador } from '../components/InfoTrabajador';
import { TablaConsulta } from '../components/TablaConsulta';

export const Consulta = () => {

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState([]);

    return (
        <>
            <h4>Consulta Estado Liquidaciones - Utilidades</h4>
            <br />
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
                activo={false}
            />
            <InfoTrabajador />
            <br />
            <TablaConsulta

            />
        </>
    );
}
