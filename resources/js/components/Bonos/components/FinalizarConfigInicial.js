import React from 'react';

import { ResumenBono } from './ResumenBono';

export const FinalizarConfigInicial = ({ bono, reglas }) => {
    return (
        <>
            <p style={{ fontWeight: 'bold' }}>Verificar la información del bono antes de habilitarlo</p>
            <ResumenBono
                bono={bono}
                reglas={reglas}
            />
        </>
    );
}
