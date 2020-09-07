import React from 'react';
import { Layout, Menu } from 'antd';
import { HomeOutlined } from "@ant-design/icons";
import moment from 'moment';

import { Home } from './submodules/Home';
import { Boletas } from './submodules/Boletas';
import { Prorrogas } from './submodules/Prorrogas';

const { Content, Footer, Sider } = Layout;

export default function EstadoDocumentos() {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                breakpoint="lg"
                collapsedWidth="0"
            >
                <br />
                <Menu mode="inline" defaultSelectedKeys={[submodule]} theme="dark">
                    <Menu.Item key="main" icon={<HomeOutlined />}>
                        <a href="/estado-documentos">
                            Inicio
                        </a>
                    </Menu.Item>
                    <Menu.Item key="boletas" icon={<HomeOutlined />}>
                        <a href="/estado-documentos/boletas">
                            Boletas
                        </a>
                    </Menu.Item>
                    <Menu.Item key="prorrogas" icon={<HomeOutlined />}>
                        <a href="/estado-documentos/prorrogas">
                            Prorrogas
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'main' && <Home />}
                        {submodule === 'boletas' && <Boletas />}
                        {submodule === 'prorrogas' && <Prorrogas />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
