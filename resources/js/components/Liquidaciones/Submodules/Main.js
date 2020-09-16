import React from 'react';
import { GraficaBarras } from '../components/GraficaBarras';
import { GraficaLinea } from '../components/GraficasLinea';

export const Main = () => {

    return (
        <>
            <h4>Pagos de Liquidaciones y Utilidades</h4>
            <br />
            <GraficaBarras />
            <br />
            <GraficaLinea />
        </>
    );
}
