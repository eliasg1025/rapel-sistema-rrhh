import React from 'react';
import { List, Button } from 'antd';

import { BonoInfo } from './BonoInfo';

export const ListaBonos = ({ bonos }) => {

    return (
        <>
            <List
                dataSource={bonos}
                itemLayout="vertical"
                renderItem={item => <BonoInfo bono={item} />}
            />
        </>
    );
}
