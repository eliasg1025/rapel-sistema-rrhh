import React from 'react';
import moment from "moment";
import {Layout, Menu} from "antd";
import {QuestionCircleOutlined} from "@ant-design/icons";

import { RegistroCuenta } from './submodules/RegistroCuenta'

const { Header, Content, Footer, Sider } = Layout;

export default function Cuentas() {
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
                    <Menu.Item key="cuentas" icon={<QuestionCircleOutlined />}>
                        <a href="/cuentas">
                            Registro Cuentas {usuario.cuentas === 2 && '(Admin)'}
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'cuentas' && <RegistroCuenta />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
