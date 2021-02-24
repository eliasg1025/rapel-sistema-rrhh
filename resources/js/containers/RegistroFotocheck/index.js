import React from 'react';
import moment from "moment";
import {Layout, Menu} from "antd";
import {FileAddOutlined, HomeOutlined, ProfileOutlined} from "@ant-design/icons";

import { Inicio, PlanillasManuales, Datos } from './submodules';

const { Header, Content, Footer, Sider } = Layout;

export default function RegistroFotochecks() {
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
                        <a href="/registro-fotochecks">
                            Inicio
                        </a>
                    </Menu.Item>
                    <Menu.Item key="datos" icon={<ProfileOutlined />}>
                        <a href="/registro-fotochecks/datos">
                            Datos
                        </a>
                    </Menu.Item>
                    <Menu.Item key="planillas-manuales" icon={<FileAddOutlined />}>
                        <a href="/registro-fotochecks/planillas-manuales">
                            Planillas manuales
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'main' && <Inicio />}
                        {submodule === 'datos' && <Datos />}
                        {submodule === 'planillas-manuales' && <PlanillasManuales />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
