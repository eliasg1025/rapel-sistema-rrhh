import React from 'react';
import { Layout, Menu } from 'antd';
import SubMenu from 'antd/lib/menu/SubMenu';
import { QuestionCircleOutlined, BookOutlined, BarChartOutlined, FileDoneOutlined } from "@ant-design/icons";
import moment from 'moment';

import AgregarSancion from "./Submodules/AgregarSancion";
import { Reportes } from './Submodules/Reportes';
import { Desvinculaciones } from './Submodules/Desvinculaciones';
import { Analista, Supervisor } from './Submodules/Sst';


const { Content, Footer, Sider } = Layout;

export default function Sanciones() {

    const { usuario, submodule, submenu } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                theme="dark"
                breakpoint="lg"
                collapsedWidth="0"
            >
                <br />
                <Menu mode="inline" defaultSelectedKeys={[submodule]} defaultOpenKeys={[submenu]} theme="dark">
                    <Menu.Item key="sanciones" icon={<QuestionCircleOutlined />}>
                        <a href="/sanciones">
                            Sanciones {usuario.sanciones === 2 && '(Admin)'}
                        </a>
                    </Menu.Item>
                    {[2, 3, 4].includes(usuario.sanciones) && (
                        <SubMenu key="sub1" icon={<FileDoneOutlined />} title="SST">
                            {[2, 3].includes(usuario.sanciones) && (
                                <Menu.Item key="supervisor-sst" icon={<FileDoneOutlined />}>
                                    <a href="/sanciones/sst/supervisor">Supervisor SST</a>
                                </Menu.Item>
                            )}
                            {[2, 4].includes(usuario.sanciones) && (
                                <Menu.Item key="analista-sst" icon={<FileDoneOutlined />}>
                                    <a href="/sanciones/sst/analista">Analista SST</a>
                                </Menu.Item>
                            )}
                        </SubMenu>
                    )}
                    {usuario.sanciones === 2 && (
                        <Menu.Item key="desvinculaciones" icon={<BookOutlined />}>
                            <a href="/sanciones/desvinculaciones">
                                Desvinculaciones
                            </a>
                        </Menu.Item>
                    )}
                    {usuario.sanciones === 2 && (
                        <Menu.Item key="reportes" icon={<BarChartOutlined />}>
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

                        {submodule === 'supervisor-sst' && <Supervisor />}
                        {submodule === 'analista-sst' && <Analista />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
