import React from 'react';
import { Layout, Menu } from 'antd';
import { Consulta } from './Submodules/Consulta';
import { HistorialBusqueda } from './Submodules/HistorialBusqueda';
import {QuestionCircleOutlined, BookOutlined} from "@ant-design/icons";
import moment from 'moment';

const { Header, Content, Footer, Sider } = Layout;

export default function ConsultaTrabajadores() {

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
                    <Menu.Item key="consulta" icon={<QuestionCircleOutlined />}>
                        <a href="/consulta-trabajadores">
                            Consulta
                        </a>
                    </Menu.Item>
                    {usuario.consultas_trabajadores === 2 && (
                        <Menu.Item key="historial-busqueda" icon={<BookOutlined />}>
                            <a href="/consulta-trabajadores/historial-busqueda">
                                Historial Búsqueda
                            </a>
                        </Menu.Item>
                    )}
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'consulta' && <Consulta />}
                        {submodule === 'historial-busqueda' && <HistorialBusqueda />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
