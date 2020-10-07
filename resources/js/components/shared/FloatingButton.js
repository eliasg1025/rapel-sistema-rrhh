import { Drawer } from "antd";
import React from "react";
import { useState } from "react";

export const FloatingButton = ({ children }) => {
    const [visible, setVisible] = useState(false);

    const showDrawer = () => {
        setVisible(true);
    };

    const onClose = () => {
        setVisible(false);
    };

    return (
        <>
            <div className="fixed-widgets" onClick={showDrawer}>
                <span
                    className="ant-avatar ant-avatar-circle ant-avatar-icon ant-dropdown-trigger fixed-widgets-avatar"
                    style={{ width: "44px", height: "44px", fontSize: "30px" }}
                >
                    <i className="fas fa-list-ul"></i>
                </span>
            </div>
            <Drawer
                placement="right"
                onClose={onClose}
                visible={visible}
                bodyStyle={{ paddingBottom: 80 }}
            >
                { children }
            </Drawer>
        </>
    );
};
