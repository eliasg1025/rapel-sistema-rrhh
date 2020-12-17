import React, { useState } from 'react';
import { Card } from 'antd';
import { CreateSeguroVidaForm, TableSegurosVida } from '../components';

export const Home = () => {

    const [reload, setReload] = useState(false);

    return (
        <>
            <h4>Seguros Vida Ley</h4>
            <br />
            <CreateSeguroVidaForm
                reload={reload}
                setReload={setReload}
            />
            <br /><br />
            <TableSegurosVida
                reload={reload}
                setReload={setReload}
            />
        </>
    );
}
