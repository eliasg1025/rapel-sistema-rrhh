import React, { useState, useEffect } from 'react';
import BuscarTrabajador from "../shared/BuscarTrabajador";

export default function ConsultarEstadoLiquidacion() {

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);

    return (
        <BuscarTrabajador
            setTrabajador={setTrabajador}
            setContratoActivo={setContratoActivo}
            activo={false}
        />
    );
}
