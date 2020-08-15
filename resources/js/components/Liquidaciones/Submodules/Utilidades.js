import React from 'react';
import { TablaLU } from '../TablaLU';

export const Utilidades = () => {

    const data = [];
    for (let i = 0; i < 46; i++) {
        data.push({
            key: i,
            id: i,
            empresa: 'RAPEL',
            rut: '72437334',
            mes: 8,
            ano: 2020,
            monto: 322.12,
            estado: 0
        });
    }

    return (
        <>
            <h4>Utilidades</h4>
            <br />
            <TablaLU data={data} />
        </>
    );
}
