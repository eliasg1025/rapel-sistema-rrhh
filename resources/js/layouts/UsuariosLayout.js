import React from "react";
import ReactDOM from "react-dom";
import { Layout, Menu } from "antd";
import {UploadOutlined, UserOutlined, HomeOutlined, LogoutOutlined} from '@ant-design/icons';
import moment from 'moment';

const { Header, Content, Footer, Sider } = Layout;

import Usuarios from '../pages/Usuarios';

import 'antd/dist/antd.css';

const MainLayout = props => {
    const usuario = JSON.parse(props.props);
    return (
        <Layout>
            <Sider
                theme="light"
                breakpoint="lg"
                collapsedWidth="0"
                onBreakpoint={broken => {
                    //console.log(broken);
                }}
                onCollapse={(collapsed, type) => {
                    //console.log(collapsed, type);
                }}
            >
                <br />
                <Menu mode="inline" defaultSelectedKeys={['2']}>
                    {
                        usuario.usuario.rol === 'admin' && (
                            <Menu.Item key="2" icon={<UserOutlined />}>
                                <a href="/usuarios">
                                    Usuarios
                                </a>
                            </Menu.Item>
                        )
                    }
                    {/*
                    <Menu.Item key="7" icon={<LogoutOutlined />} onClick={(e) => document.getElementById("logoutForm").submit()}>
                        <a href="/panel">
                            Regresar a
                        </a>
                    </Menu.Item>*/}
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        <Usuarios
                            usuario={usuario}
                        />
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
};

export default MainLayout;

if (document.getElementById("usuarios-layout")) {
    const element = document.getElementById("usuarios-layout");
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<MainLayout  {...props}/>, element);
}
