import React from 'react';
import { Layout, Menu } from 'antd';
import { HomeOutlined, SnippetsOutlined } from "@ant-design/icons";
import moment from 'moment';

import { Home, Boletas, Prorrogas, Vacaciones } from './submodules';

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
                    {usuario.estado_documentos === 2 && (
                        <Menu.Item key="main" icon={<HomeOutlined />}>
                            <a href="/estado-documentos">
                                Inicio
                            </a>
                        </Menu.Item>
                    )}
                    <Menu.Item key="boletas" icon={<SnippetsOutlined />}>
                        <a href="/estado-documentos/boletas">
                            Boletas
                        </a>
                    </Menu.Item>
                    <Menu.Item key="prorrogas" icon={<SnippetsOutlined />}>
                        <a href="/estado-documentos/prorrogas">
                            Prorrogas
                        </a>
                    </Menu.Item>
                    <Menu.Item key="vacaciones" icon={<SnippetsOutlined />}>
                        <a href="/estado-documentos/vacaciones">
                            Vacaciones
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
                        {submodule === 'vacaciones' && <Vacaciones />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
