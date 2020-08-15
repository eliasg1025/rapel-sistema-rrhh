import React, { useState, useEffect } from 'react';
import { Layout, Menu } from 'antd';
import {CloudUploadOutlined, FileDoneOutlined, HomeOutlined, QuestionCircleOutlined} from "@ant-design/icons";
import moment from "moment";

import { Main } from './Submodules/Main';
import { Importacion } from './Submodules/Importacion';
import { Consulta } from './Submodules/Consulta';
import { Liquidaciones } from './Submodules/Liquidaciones';
import { Utilidades } from './Submodules/Utilidades';

const { Header, Content, Footer, Sider } = Layout;

export default function AdminLiquidaciones() {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                theme="light"
                breakpoint="lg"
                collapsedWidth="0"
            >
                <br />
                <Menu mode="inline" defaultSelectedKeys={[submodule]}>
                    <Menu.Item key="main" icon={<HomeOutlined />}>
                        <a href="/liquidaciones-utilidades">
                            Inicio
                        </a>
                    </Menu.Item>
                    <Menu.Item key="importacion" icon={<CloudUploadOutlined />}>
                        <a href="/liquidaciones-utilidades/importacion">
                            Importación TU RECIBO
                        </a>
                    </Menu.Item>
                    <Menu.Item key="consulta" icon={<QuestionCircleOutlined />}>
                        <a href="/liquidaciones-utilidades/consulta">
                            Consulta
                        </a>
                    </Menu.Item>
                    <Menu.Item key="l" icon={<FileDoneOutlined />}>
                        <a href="/liquidaciones-utilidades/l">
                            Liquidaciones
                        </a>
                    </Menu.Item>
                    <Menu.Item key="u" icon={<FileDoneOutlined />}>
                        <a href="/liquidaciones-utilidades/u">
                            Utilidades
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'main' && <Main />}
                        {submodule === 'importacion' && <Importacion />}
                        {submodule === 'consulta' && <Consulta />}
                        {submodule === 'l' && <Liquidaciones />}
                        {submodule === 'u' && <Utilidades />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
