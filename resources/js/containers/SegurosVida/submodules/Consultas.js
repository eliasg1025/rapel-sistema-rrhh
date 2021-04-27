import React, { useState } from 'react';

import { Busqueda, BusquedaResultados } from '../components';

export const Consultas = props => {

    const [dataSource, setDataSource] = useState([]);
    const [isLoading, setIsLoading] = useState(false);

    return (
        <>
            <h4>Consultas</h4>
            <br />
            <Busqueda setDataSource={setDataSource} setIsLoading={setIsLoading} />
            <br />
            <BusquedaResultados dataSource={dataSource} loading={isLoading} />
        </>
    );
}
