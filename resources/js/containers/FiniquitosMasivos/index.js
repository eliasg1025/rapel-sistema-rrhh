import React from 'react';

import { PrivateLayout } from '../../layouts';
import { Menu } from "antd";
import { HomeOutlined, FileAddOutlined, UserSwitchOutlined } from "@ant-design/icons";


import { Home, RegistroAnalistas, RegistroIndividual } from "./submodules";


export default function FiniquitosMasivos() {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const MenuA = () => {
        return (
            <Menu theme="dark" mode="inline" defaultSelectedKeys={[submodule]}>
                <Menu.Item key="main" icon={<HomeOutlined />}>
                    <a href="/finiquitos">
                        Registro Grupos
                    </a>
                </Menu.Item>
                {usuario.modulo_rol.tipo.name !== 'ANALISTA DE GESTION' && (
                    <Menu.Item key="registro-individual" icon={<FileAddOutlined />}>
                        <a href="/finiquitos/registro/individual">
                            Cartas de Renuncia
                        </a>
                    </Menu.Item>
                )}
                {usuario.modulo_rol.tipo.name === 'ADMINISTRADOR' && (
                    <Menu.Item key="registro-analistas" icon={<UserSwitchOutlined />}>
                        <a href="/finiquitos/registro/analistas">
                            Registro Analistas
                        </a>
                    </Menu.Item>
                )}
            </Menu>
        );
    }

    const Content = () => {
        switch (submodule) {
            case 'main':
                return <Home />;
            case 'registro-individual':
                return <RegistroIndividual />;
            case 'registro-analistas':
                return <RegistroAnalistas />;
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
