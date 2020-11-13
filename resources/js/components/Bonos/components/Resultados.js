import React from 'react';
import { Tabs } from 'antd';
import { PasosIniciales } from './PasosIniciales';

export const Resultados = ({ bono }) => {
    return (
        <Tabs defaultActiveKey="1">
            <Tabs.TabPane tab="Resultados" key="1">
                izi
            </Tabs.TabPane>
            <Tabs.TabPane tab="Configuración" key="2">
                <PasosIniciales bono={bono} />
            </Tabs.TabPane>
        </Tabs>
    );
}
