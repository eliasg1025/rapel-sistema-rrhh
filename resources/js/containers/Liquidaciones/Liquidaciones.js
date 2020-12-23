import React, { useState, useEffect } from 'react';
import { Layout, Menu } from 'antd';
import {BankOutlined, FileDoneOutlined, HomeOutlined, QuestionCircleOutlined, StopOutlined, FileOutlined } from "@ant-design/icons";
import moment from "moment";

import { Main } from './Submodules/Main';
import { Consulta } from './Submodules/Consulta';
import { Liquidaciones } from './Submodules/Liquidaciones';
import { Pagados } from './Submodules/Pagados';
import { Rechazos } from './Submodules/Rechazos';
import { MainPagos } from './Submodules/MainPagos';
import { FloatingButton } from '../shared/FloatingButton';

const { Content, Footer, Sider } = Layout;
const { SubMenu } = Menu;

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
                            <a href="/pagos">
                                Inicio
                            </a>
                        </Menu.Item>
                    )}
                    <Menu.Item key="consulta" icon={<QuestionCircleOutlined />}>
                        <a href="/pagos/consulta">
                            Consulta
                        </a>
                    </Menu.Item>
                    {
                        (usuario.liquidaciones === 3 || usuario.liquidaciones === 2) && (
                            <SubMenu key="sub1" icon={<FileDoneOutlined />} title="Pagos">
                                {usuario.liquidaciones === 2 && (
                                    <Menu.Item key="l" icon={<HomeOutlined />}>
                                        <a href="/pagos/l">
                                            Principal
                                        </a>
                                    </Menu.Item>
                                )}
                                {usuario.liquidaciones === 2 && (
                                    <Menu.Item key="l-registros" icon={<FileOutlined />}>
                                        <a href="/pagos/l/registros">
                                            Registros
                                        </a>
                                    </Menu.Item>
                                )}
                                <Menu.Item key="l-pagados" icon={<BankOutlined />}>
                                    <a href="/pagos/l/pagados">
                                        Pagados
                                    </a>
                                </Menu.Item>
                                <Menu.Item key="l-rechazos" icon={<StopOutlined />}>
                                    <a href="/pagos/l/rechazos">
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
                        {submodule === 'l' && <MainPagos />}
                        {submodule === 'l-registros' && <Liquidaciones />}
                        {submodule === 'l-pagados' && <Pagados />}
                        {submodule === 'l-rechazos' && <Rechazos />}
                    </div>
                </Content>
                <FloatingButton />
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
