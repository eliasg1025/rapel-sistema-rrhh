import React from 'react';
import { Layout, Menu } from 'antd';
import { QuestionCircleOutlined, BookOutlined } from "@ant-design/icons";
import moment from 'moment';
import AgregarSancion from "./Submodules/AgregarSancion";
import { Reportes } from './Submodules/Reportes';
import { Desvinculaciones } from './Submodules/Desvinculaciones';

const { Content, Footer, Sider } = Layout;

export default function Sanciones() {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                theme="dark"
                breakpoint="lg"
                collapsedWidth="0"
            >
                <br />
                <Menu mode="inline" defaultSelectedKeys={[submodule]} theme="dark">
                    <Menu.Item key="sanciones" icon={<QuestionCircleOutlined />}>
                        <a href="/sanciones">
                            Sanciones {usuario.sanciones === 2 && '(Admin)'}
                        </a>
                    </Menu.Item>
                    {usuario.sanciones === 2 && (
                        <Menu.Item key="desvinculaciones" icon={<BookOutlined />}>
                            <a href="/sanciones/desvinculaciones">
                                Desvinculaciones
                            </a>
                        </Menu.Item>
                    )}
                    {usuario.sanciones === 2 && (
                        <Menu.Item key="reportes" icon={<BookOutlined />}>
                            <a href="/sanciones/reportes">
                                Reportes
                            </a>
                        </Menu.Item>
                    )}
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '20px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'sanciones' && <AgregarSancion />}
                        {submodule === 'desvinculaciones' && <Desvinculaciones />}
                        {submodule === 'reportes' && <Reportes />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
