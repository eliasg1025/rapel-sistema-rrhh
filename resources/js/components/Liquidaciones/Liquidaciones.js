import React, { useState, useEffect } from 'react';
import { Layout, Menu } from 'antd';
import {BankOutlined, CloudUploadOutlined, FileDoneOutlined, HomeOutlined, QuestionCircleOutlined, StopOutlined} from "@ant-design/icons";
import moment from "moment";

import { Main } from './Submodules/Main';
import { Consulta } from './Submodules/Consulta';
import { Liquidaciones } from './Submodules/Liquidaciones';
import { Utilidades } from './Submodules/Utilidades';
import SubMenu from 'antd/lib/menu/SubMenu';
import { Pagados } from './Submodules/Pagados';
import { Rechazos } from './Submodules/Rechazos';

const { Content, Footer, Sider } = Layout;

export default function main() {

    const { usuario, submenu, submodule } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                breakpoint="lg"
                collapsedWidth="0"
                theme="dark"
            >
                <br />
                <Menu mode="inline" theme="dark" defaultSelectedKeys={[submodule]} defaultOpenKeys={[submenu]}>
                    {(usuario.liquidaciones === 2 || usuario.liquidaciones === 1) && (
                        <Menu.Item key="main" icon={<HomeOutlined />}>
                            <a href="/liquidaciones-utilidades">
                                Inicio
                            </a>
                        </Menu.Item>
                    )}
                    <Menu.Item key="consulta" icon={<QuestionCircleOutlined />}>
                        <a href="/liquidaciones-utilidades/consulta">
                            Consulta
                        </a>
                    </Menu.Item>
                    {
                        (usuario.liquidaciones === 1 || usuario.liquidaciones === 2) && (
                            <SubMenu key="sub1" icon={<FileDoneOutlined />} title="Pagos">
                                {usuario.liquidaciones === 2 && (
                                    <Menu.Item key="l" icon={<HomeOutlined />}>
                                        <a href="/liquidaciones-utilidades/l">
                                            Principal
                                        </a>
                                    </Menu.Item>
                                )}
                                <Menu.Item key="l-pagados" icon={<BankOutlined />}>
                                    <a href="/liquidaciones-utilidades/l/pagados">
                                        Pagados
                                    </a>
                                </Menu.Item>
                                <Menu.Item key="l-rechazos" icon={<StopOutlined />}>
                                    <a href="/liquidaciones-utilidades/l/rechazos">
                                        Rechazos
                                    </a>
                                </Menu.Item>
                            </SubMenu>
                        )
                    }
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '20px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'main' && <Main />}
                        {submodule === 'consulta' && <Consulta />}
                        {submodule === 'l' && <Liquidaciones />}

                        {submodule === 'l-pagados' && <Pagados />}

                        {submodule === 'l-rechazos' && <Rechazos />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
