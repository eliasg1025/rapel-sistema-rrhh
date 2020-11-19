import React from 'react';
import moment from "moment";
import { Layout, Menu } from "antd";
import { ExceptionOutlined, FileOutlined, HistoryOutlined, HomeOutlined, SyncOutlined, UserOutlined } from "@ant-design/icons";

import { Home, Sincronizacion, Lecturas } from './submodules';
import SubMenu from 'antd/lib/menu/SubMenu';

const { Header, Content, Footer, Sider } = Layout;

export default function PanelAplicacion() {
    const { usuario, submodule, submenu } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                theme="dark"
                breakpoint="lg"
                collapsedWidth="0"
            >
                <br />
                <Menu theme="dark" mode="inline" defaultSelectedKeys={[submodule]} defaultOpenKeys={[submenu]}>
                    <Menu.Item key="main" icon={<HomeOutlined />}>
                        <a href="/aplicacion">
                            Principal
                        </a>
                    </Menu.Item>
                    <Menu.Item key="sync" icon={<SyncOutlined />}>
                        <a href="/aplicacion/sincronizar">
                            Sincronización
                        </a>
                    </Menu.Item>
                    <SubMenu key="sub1" icon={<UserOutlined />} title="Lecturas de Sueldos">
                        <Menu.Item key="historial" icon={<HistoryOutlined />}>
                            <a href="/aplicacion/lecturas-sueldos/historial">
                                Historial
                            </a>
                        </Menu.Item>
                        <Menu.Item key="observaciones" icon={<ExceptionOutlined />}>
                            <a href="/aplicacion/lecturas-sueldos/observaciones">
                                Observaciones
                            </a>
                        </Menu.Item>
                    </SubMenu>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'main' && <Home />}
                        {submodule === 'sync' && <Sincronizacion />}
                        {submenu === 'sub1' && (
                            submodule === 'historial' && <Lecturas.Historial />
                        )}
                        {submenu === 'sub1' && (
                            submodule === 'observaciones' && <Lecturas.Observaciones />
                        )}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
