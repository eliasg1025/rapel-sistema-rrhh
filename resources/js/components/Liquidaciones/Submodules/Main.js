import React, { useState, useEffect } from 'react';
import { ImportacionTuRecibo } from '../components/ImportacionTuRecibo';
import { Sincronizar } from '../components/Sincronizar';

export const Main = () => {

    return (
        <>
            <h3>Pagos de Liquidaciones y Utilidades</h3>
            <br />
            <div className="row">
                <div className="col-md-6 mb-2">
                    <Sincronizar />
                </div>
            </div>
        </>
    );
}
