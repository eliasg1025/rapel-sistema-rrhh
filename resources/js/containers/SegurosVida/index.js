import React from 'react';

import { PrivateLayout } from '../../layouts';
import { Menu } from "antd";
import { HomeOutlined } from "@ant-design/icons";

import { Home } from './submodules';

export default function SegurosVida() {
    const { submodule } = JSON.parse(sessionStorage.getItem('data'));

    const MenuA = () => {
        return (
            <Menu theme="dark" mode="inline" defaultSelectedKeys={[submodule]}>
                <Menu.Item key="main" icon={<HomeOutlined />}>
                    <a href="/seguros-vida">
                        Principal
                    </a>
                </Menu.Item>
            </Menu>
        );
    }

    const Content = () => {
        switch (submodule) {
            case 'main':
                return <Home />;
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
