import React from 'react';
import moment from "moment";
import { Layout, Menu } from "antd";
import { HomeOutlined, BarChartOutlined } from "@ant-design/icons";

import { Home } from './submodules';
import { Reportes } from './submodules/Reportes';

const { Header, Content, Footer, Sider } = Layout;

export default function ReseteoClave() {
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
                        <a href="/atencion-cambio-clave">
                            Principal
                        </a>
                    </Menu.Item>
                    {usuario.reseteo_clave === 3 && (
                        <Menu.Item key="reportes" icon={<BarChartOutlined />}>
                            <a href="/atencion-cambio-clave/reportes">
                                Reportes
                            </a>
                        </Menu.Item>
                    )}
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'main' && <Home />}
                        {submodule === 'reportes' && <Reportes />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
