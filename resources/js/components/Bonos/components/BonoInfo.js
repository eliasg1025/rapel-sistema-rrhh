import React from 'react';
import { List, Button, Card, Tag } from 'antd';

export const BonoInfo = ({ bono }) => {

    console.log(bono);

    return (
        <List.Item
            key={bono.id}
        >
            <div
                className="rapel-list-item"
                onClick={() => location.replace(`/bonos/editar/${bono.id}`)}
            >
                <List.Item.Meta
                    title={<a href={`/bonos/editar/${bono.id}`}>{bono.name}</a>}
                    description={bono.descripcion}
                />
                EMPRESA: <Tag color="processing">{bono.empresa_id === 9 ? 'RAPEL' : 'VERFRUT'}</Tag> | Creado por: {bono.usuario.username}
            </div>
        </List.Item>
    );
}
