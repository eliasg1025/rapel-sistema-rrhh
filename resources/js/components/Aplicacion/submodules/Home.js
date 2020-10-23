import React, { useEffect, useState } from 'react';
import { Card } from 'antd';

export const Home = () => {

    const [oneline, setOneline] = useState(false);

    useEffect(() => {
        setTimeout(() => {
            setOneline(true);
        }, 1500);
    }, []);

    return (
        <>
            <h4>Panel de Control - Aplicación RRHH</h4>
            <br />
            <h5>Estado Servidor:</h5>
            <Card>
                Dirección IP: <b>209.151.144.74</b><br />
                Estado: {oneline ? (
                    <span>En línea</span>
                ) : (
                    <span>Fuera de línea</span>
                )}
            </Card>
        </>
    );
}
