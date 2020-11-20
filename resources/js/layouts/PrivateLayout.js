import React from 'react';
import { Layout, Menu } from "antd";
import moment from "moment";

const { Content, Footer, Sider } = Layout;

export const PrivateLayout = ({ menu, content }) => {
    return (
        <Layout>
            <Sider
                theme="dark"
                breakpoint="lg"
                collapsedWidth="0"
            >
                <br />
                {menu}
            </Sider>
            <Layout>
                <Content style={{ margin: '20px 16px 0' }}>
                    <div className="site-layout-background" style={{padding: 24, minHeight: '100vh'}}>
                        {content}
                    </div>
                </Content>
                <Footer style={{ textAlign: 'center' }}>&copy;{ moment().format('YYYY') } - GRUPO VERFRUT</Footer>
            </Layout>
        </Layout>
    );
}
