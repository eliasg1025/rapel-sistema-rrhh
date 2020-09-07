import React from 'react';

export const Boletas = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <>
            <h4>Boletas <small>{usuario.estado_documentos === 2 ? '(Administrador)' : ''}</small></h4>
            <br />
            <div className="row">
                <div className="col">
                    <button className="btn btn-primary">
                        Importar Boletas
                    </button>
                </div>
            </div>
        </>
    );
}
