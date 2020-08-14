import React, { useState, useEffect } from 'react';
import { Layout, Menu } from 'antd';
import { HomeOutlined } from "@ant-design/icons";

const { Header, Content, Footer, Sider } = Layout;

export default function AdminLiquidaciones() {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                theme="light"
                breakpoint="lg"
                collapsedWidth="0"
            >
                <Menu mode="inline">
                    <Menu.Item key="1" icon={<HomeOutlined />}>
                        <a href="/liquidaciones-utilidades">
                            Inicio
                        </a>
                    </Menu.Item>
                    <Menu.Item key="2" icon={<HomeOutlined />}>
                        <a href="/liquidaciones-utlidades/importacion">
                            Importación TU RECIBO
                        </a>
                    </Menu.Item>
                    <Menu.Item key="3" icon={<HomeOutlined />}>
                        <a href="/liquidaciones-utilidades/consulta">
                            Consulta
                        </a>
                    </Menu.Item>
                    <Menu.Item key="4" icon={<HomeOutlined />}>
                        <a href="/liquidaciones-utilidades/l">
                            Liquidaciones
                        </a>
                    </Menu.Item>
                    <Menu.Item key="5" icon={<HomeOutlined />}>
                        <a href="/liquidaciones-utilidades/u">
                            Utilidades
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
        </Layout>
    );
}
