import React from 'react';

import { PrivateLayout } from '../../layouts';
import { Menu } from "antd";
import { HomeOutlined, FileAddOutlined } from "@ant-design/icons";


import { Home, RegistroIndividual } from "./submodules";


export default function FiniquitosMasivos() {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const MenuA = () => {
        return (
            <Menu theme="dark" mode="inline" defaultSelectedKeys={[submodule]}>
                <Menu.Item key="main" icon={<HomeOutlined />}>
                    <a href="/finiquitos">
                        Principal
                    </a>
                </Menu.Item>
                <Menu.Item key="registro-individual" icon={<FileAddOutlined />}>
                    <a href="/finiquitos/registro/individual">
                        Registro Individual
                    </a>
                </Menu.Item>
            </Menu>
        );
    }

    const Content = () => {
        switch (submodule) {
            case 'main':
                return <Home />;
            case 'registro-individual':
                return <RegistroIndividual />;
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
