import React from 'react';

export const Reportes = () => {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    return (
        <>
            <h4>Reportes</h4>
            <br />
            <a href={`/api/atencion-cambio-clave/reportes`} target="_blank" className="btn btn-success">
                Exportar
            </a>
        </>
    );
}
