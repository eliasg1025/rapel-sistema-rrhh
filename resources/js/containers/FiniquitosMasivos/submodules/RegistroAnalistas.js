import React, { useState } from 'react';
import { Card } from 'antd';
import { CreateUsuarioZonaForm } from '../components';
import { TableUsuarioZona } from '../components/TableUsuarioZona';

export const RegistroAnalistas = () => {
    const [reload, setReload] = useState(false);

    return (
        <>
            <h4>Registro de Analistas</h4>
            <br />
            <Card>
                <CreateUsuarioZonaForm
                    reload={reload}
                    setReload={setReload}
                />
            </Card>
            <br />
            <TableUsuarioZona
                reload={reload}
                setReload={setReload}
            />
        </>
    );
}