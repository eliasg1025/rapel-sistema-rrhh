import React from 'react';
import { Layout, Menu } from 'antd';
import { Habilitar } from './Submodules/Habilitar';
import { Reportes } from './Submodules/Reportes';
import { Consulta } from './Submodules/Consulta';
import {QuestionCircleOutlined, BookOutlined} from "@ant-design/icons";
import moment from 'moment';

const { Content, Footer, Sider } = Layout;

export default function Sctr() {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                theme="light"
                breakpoint="lg"
                collapsedWidth="0"
            >
                <br />
                <Menu mode="inline" defaultSelectedKeys={[submodule]}>
                    <Menu.Item key="consulta" icon={<QuestionCircleOutlined />}>
                        <a href="/sctr">
                            Consulta
                        </a>
                    </Menu.Item>
                    {usuario.sctr === 2 && (
                        <Menu.Item key="habilitar" icon={<BookOutlined />}>
                            <a href="/sctr/habilitar">
                                Habilitar
                            </a>
                        </Menu.Item>
                    )}
                    {usuario.sctr === 2 && (
                        <Menu.Item key="reportes" icon={<BookOutlined />}>
                            <a href="/sctr/reportes">
                                Reportes
                            </a>
                        </Menu.Item>
                    )}
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'consulta' && <Consulta />}
                        {submodule === 'habilitar' && <Habilitar />}
                        {submodule === 'reportes' && <Reportes />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
