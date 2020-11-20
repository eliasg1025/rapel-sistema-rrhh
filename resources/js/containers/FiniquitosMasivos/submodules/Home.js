import React, { useState } from 'react';

import { CreateGrupoForm, TablaGrupo } from '../components';

export const Home = () => {

    const [reload, setReload] = useState(false);

    return (
        <>
            <h4>Finiquitos Masivos</h4>
            <br />
            <CreateGrupoForm
                reload={reload}
                setReload={setReload}
            />
            <br />
            <TablaGrupo
                reload={reload}
            />
        </>
    );
}


