import React, { useState } from 'react';
import { Tabs } from 'antd';
import { PasosIniciales } from './PasosIniciales';
import { Resultados } from './Resultados';
import { Historial } from './Historial';

export const Panel = ({ bono }) => {

    const [reload, setReload] = useState(false);

    return (
        <Tabs defaultActiveKey="1" onChange={() => setReload(!reload)}>
            <Tabs.TabPane tab="Ejecución" key="1">
                <Resultados bono={bono} />
            </Tabs.TabPane>
            <Tabs.TabPane tab="Configuración" key="2">
                <PasosIniciales bono={bono} />
            </Tabs.TabPane>
            <Tabs.TabPane tab="Historial" key="3">
                <Historial bono={bono} reload={reload} setReload={setReload} />
            </Tabs.TabPane>
        </Tabs>
    );
}
