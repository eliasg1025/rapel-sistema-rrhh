import React from 'react';

import { PrivateLayout } from '../../layouts';
import { Menu } from "antd";
import { HomeOutlined, QuestionCircleOutlined } from "@ant-design/icons";

import { Home, Consultas } from './submodules';

export default function SegurosVida() {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const MenuA = () => {
        return (
            <Menu theme="dark" mode="inline" defaultSelectedKeys={[submodule]}>
                {usuario.modulo_rol.tipo.name === 'ADMINISTRADOR' && (
                    <Menu.Item key="main" icon={<HomeOutlined />}>
                        <a href="/seguros-vida">
                            Registros
                        </a>
                    </Menu.Item>
                )}
                <Menu.Item key="consulta" icon={<QuestionCircleOutlined />}>
                    <a href="/seguros-vida/consulta">
                        Consulta
                    </a>
                </Menu.Item>
            </Menu>
        );
    }

    const Content = () => {
        switch (submodule) {
            case 'main':
                return <Home />;
            case 'consulta':
                return <Consultas />;
            default:
                return <Home />;
        }
    }

    return (
        <PrivateLayout
            menu={<MenuA />}
            content={<Content />}
        />
    );
}
