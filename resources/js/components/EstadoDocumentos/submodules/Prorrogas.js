import React from 'react';

export const Prorrogas = () => {
    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <h4>Prórrogas <small>{usuario.estado_documentos === 2 ? '(Administrador)' : ''}</small></h4>
    );
}
