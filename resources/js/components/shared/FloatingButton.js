import React from 'react';

export const FloatingButton = () => {
    return (
        <div className="fixed-widgets">
            <span
                className="ant-avatar ant-avatar-circle ant-avatar-icon ant-dropdown-trigger fixed-widgets-avatar"
                style={{ width: '44px', height: '44px', fontSize: '30px' }}
            >
                <i className="fas fa-list-ul"></i>
            </span>
        </div>
    );
}
