import React, { useState, useEffect } from 'react';
import { Layout, Menu } from 'antd';
import {CloudUploadOutlined, FileDoneOutlined, HomeOutlined, QuestionCircleOutlined} from "@ant-design/icons";
import moment from "moment";

const { Header, Content, Footer, Sider } = Layout;

export default function AdminLiquidaciones() {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    return (
        <Layout>
            <Sider
                theme="light"
                breakpoint="lg"
                collapsedWidth="0"
            >
                <br />
                <Menu mode="inline" defaultSelectedKeys={['1']}>
                    <Menu.Item key="1" icon={<HomeOutlined />}>
                        <a href="/liquidaciones-utilidades">
                            Inicio
                        </a>
                    </Menu.Item>
                    <Menu.Item key="2" icon={<CloudUploadOutlined />}>
                        <a href="/liquidaciones-utilidades/importacion">
                            Importación TU RECIBO
                        </a>
                    </Menu.Item>
                    <Menu.Item key="3" icon={<QuestionCircleOutlined />}>
                        <a href="/liquidaciones-utilidades/consulta">
                            Consulta
                        </a>
                    </Menu.Item>
                    <Menu.Item key="4" icon={<FileDoneOutlined />}>
                        <a href="/liquidaciones-utilidades/l">
                            Liquidaciones
                        </a>
                    </Menu.Item>
                    <Menu.Item key="5" icon={<FileDoneOutlined />}>
                        <a href="/liquidaciones-utilidades/u">
                            Utilidades
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: '24px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        <h1>Hi</h1>
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
