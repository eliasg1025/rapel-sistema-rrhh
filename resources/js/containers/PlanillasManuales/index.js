import React, { useEffect } from "react";
import moment from "moment";
import { Layout, Menu } from "antd";
import { HomeOutlined, FileAddOutlined } from "@ant-design/icons";

import { Inicio, Reportes } from './submodules';

const { Header, Content, Footer, Sider } = Layout;

export default function PlanillasManuales() {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    return (
        <Layout>
            <Sider theme="dark" breakpoint="lg" collapsedWidth="0">
                <br />
                <Menu
                    theme="dark"
                    mode="inline"
                    defaultSelectedKeys={[submodule]}
                >
                    <Menu.Item key="main" icon={<HomeOutlined />}>
                        <a href="/planillas-manuales">Inicio</a>
                    </Menu.Item>
                    <Menu.Item key="reportes" icon={<FileAddOutlined />}>
                        <a href="/planillas-manuales/reportes">
                            Reportes
                        </a>
                    </Menu.Item>
                </Menu>
            </Sider>
            <Layout>
                <Content style={{ margin: "24px 16px 0" }}>
                    <div
                        className="site-layout-background"
                        style={{ padding: 24, minHeight: "100vh" }}
                    >
                        {submodule === "main" && <Inicio />}
                        {submodule === "reportes" && <Reportes />}
                    </div>
                </Content>
                <Footer style={{ textAlign: "center" }}>
                    &copy;{moment().format("YYYY")} - GRUPO VERFRUT
                </Footer>
            </Layout>
        </Layout>
    );
}
