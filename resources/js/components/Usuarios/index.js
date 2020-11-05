import React from 'react';
import moment from "moment";
import { Layout, Menu } from "antd";
import { FileOutlined, HomeOutlined, MenuFoldOutlined } from "@ant-design/icons";

import { Usuarios, RolesUsuarios } from './submodules';

const { Header, Content, Footer, Sider } = Layout;

export default function UsuariosModule() {
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
                        <a href="/usuarios">
                            Principal
                        </a>
                    </Menu.Item>
                    <Menu.Item key="roles" icon={<MenuFoldOutlined />}>
                        <a href="/usuarios/roles">
                            Roles de Usuarios
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'main' && <Usuarios />}
                        {submodule === 'roles' && <RolesUsuarios />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
