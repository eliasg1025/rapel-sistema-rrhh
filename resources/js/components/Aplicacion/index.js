import React from 'react';
import moment from "moment";
import { Layout, Menu } from "antd";
import { FileOutlined, HomeOutlined, SyncOutlined } from "@ant-design/icons";

import { Home, Sincronizacion } from './submodules';

const { Header, Content, Footer, Sider } = Layout;

export default function PanelAplicacion() {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                theme="dark"
                breakpoint="lg"
                collapsedWidth="0"
            >
                <br />
                <Menu theme="dark" mode="inline" defaultSelectedKeys={[submodule]}>
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
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'main' && <Home />}
                        {submodule === 'sync' && <Sincronizacion />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
