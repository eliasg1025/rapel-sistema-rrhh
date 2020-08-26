import React from 'react';
import { HabilitarOficios } from './components/HabilitarOficios';
import { HabilitarCuarteles } from './components/HabilitarCuarteles';

export const Habilitar = () => {
    return (
        <>
            <div className="row">
                <div className="col-md-6">
                    <HabilitarOficios />
                </div>
                <div className="col-md-6">
                    <HabilitarCuarteles />
                </div>
            </div>
        </>
    );
}
