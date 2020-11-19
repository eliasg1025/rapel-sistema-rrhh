import Axios from 'axios';
import React, { useState, useEffect } from 'react';

export const MostrarUltimaActualizacion = () => {

    const [ultimaActualizacion, setUltimaActualizacion] = useState(null);

    useEffect(() => {
        Axios.get('/api/corte-turecibo/get-last')
            .then(res => {
                //console.log(res);
                setUltimaActualizacion(res.data);
            })
            .catch(err => {
                console.error(err);
            })
    }, []);

    return (
        <div>
            <div className="alert alert-dismissible alert-secondary">
                Última actualización: <strong>{ ultimaActualizacion?.fecha_hora_corte || '' }</strong>
            </div>
        </div>
    );
}
