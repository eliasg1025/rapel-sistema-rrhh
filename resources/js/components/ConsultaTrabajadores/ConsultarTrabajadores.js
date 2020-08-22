import React from 'react';
import { Layout, Menu } from 'antd';
import { Consulta } from './Submodules/Consulta';
import {QuestionCircleOutlined} from "@ant-design/icons";
import moment from 'moment';

const { Header, Content, Footer, Sider } = Layout;

export default function ConsultaTrabajadores() {

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
                        <a href="/consulta-trabajadores">
                            Consulta
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {submodule === 'consulta' && <Consulta />}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
