import React from 'react';
import moment from "moment";
import { Layout, Menu } from "antd";
import { UploadOutlined, UserOutlined, HomeOutlined, LogoutOutlined } from '@ant-design/icons';

import { Home, Trabajadores, RegistroIndividual, RegistroMasivo } from './submodules';

const { Header, Content, Footer, Sider } = Layout;

export default function Ingresos() {
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
                    <Menu.Item key="home" icon={<HomeOutlined />}>
                        <a href="/ingresos">
                            Inicio
                        </a>
                    </Menu.Item>
                    <Menu.Item key="trabajadores" icon={<UploadOutlined />}>
                        <a href="/ingresos/trabajadores">
                            Trabajadores
                        </a>
                    </Menu.Item>
                    <Menu.Item key="registro-individual" icon={<UserOutlined />}>
                        <a href="/ingresos/registro-individual">
                            Registro Individual
                        </a>
                    </Menu.Item>
                    <Menu.Item key="registro-masivo" icon={<UserOutlined />}>
                        <a href="/ingresos/registro-masivo">
                            Registro Masivo
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'home' && <Home />}
                        {submodule === 'trabajadores' && <Trabajadores />}
                        {submodule === 'registro-individual' && <RegistroIndividual />}
                        {submodule === 'registro-masivo' && <RegistroMasivo />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
