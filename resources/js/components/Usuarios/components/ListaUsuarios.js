import React, { useState } from 'react'
import { Switch, List, Avatar, Button, notification, Tooltip } from 'antd';
import { EditOutlined, StopOutlined, CheckOutlined } from '@ant-design/icons';

import AddUserForm from './AddUserForm';
import EditUserForm from './EditUserForm';
import Modal from '../../Modal';
import Axios from 'axios';

const ListaUsuarios = props => {
    const {
        reloadUser, setReloadUser, usersActive, usersInactive
    } = props;

    const [viewUsersActive, setViewUsersActive] = useState(true);
    const [isVisibleModal, setIsVisibleModal] = useState(false);
    const [modalTitle, setModalTitle] = useState('');
    const [modalContent, setModalContent] = useState(null);

    const addUserModal = () => {
        setIsVisibleModal(true);
        setModalTitle('Creando nuevo usuario');
        setModalContent(
            <AddUserForm
                setIsVisibleModal={setIsVisibleModal}
                setReloadUser={setReloadUser}
            />
        );
    };

    return (
        <div className="list-users">
            <div className="list-users__header">
                <div className="list-users__header-switch">
                    <Switch
                        defaultChecked
                        onChange={() => setViewUsersActive(!viewUsersActive)}
                    />
                    <span>
                        {viewUsersActive ? 'Usuarios Activos' : 'Usuarios Inactivos'}
                    </span>
                </div>
                <Button type="primary" onClick={addUserModal}>
                    Nuevo Usuario
                </Button>
            </div>

            {viewUsersActive ? (
                <UsersActive
                    usersActive={usersActive}
                    setIsVisibleModal={setIsVisibleModal}
                    setModalTitle={setModalTitle}
                    setModalContent={setModalContent}
                    reloadUser={reloadUser}
                    setReloadUser={setReloadUser}
                />
            ) : (
                <UsersInactive
                    usersInactive={usersInactive}
                    reloadUser={reloadUser}
                    setReloadUser={setReloadUser}
                />
            )}

            <Modal
                title={modalTitle}
                isVisible={isVisibleModal}
                setIsVisible={setIsVisibleModal}
            >
                {modalContent}
            </Modal>
        </div>
    )
};

function UsersActive(props) {
    const {
        usersActive,
        setIsVisibleModal,
        setModalTitle,
        setModalContent,
        reloadUser,
        setReloadUser,
    } = props;

    const editUser = user => {
        setIsVisibleModal(true);
        setModalTitle(`Editar ${user.username ? user.username : '...'}`);
        setModalContent(
            <EditUserForm
                user={user}
                setIsVisibleModal={setIsVisibleModal}
                reloadUser={reloadUser}
                setReloadUser={setReloadUser}
            />
        );
    };

    return (
        <List
            className="users-active"
            itemLayout="horizontal"
            dataSource={usersActive}
            renderItem={user => (
                <UserActive
                    user={user}
                    editUser={editUser}
                    reloadUser={reloadUser}
                    setReloadUser={setReloadUser}
                />
            )}
        />
    );
}

function UserActive(props) {
    const { user, editUser, reloadUser, setReloadUser } = props;

    const [loading, setLoading] = useState(false);

    const desativateUser = () => {
        setLoading(true);

        Axios.put(`/api/usuario/${user.id}/toggle-activate`)
            .then(res => {
                //console.log(res);
                setReloadUser(!reloadUser);
                notification['success']({
                    message: res.data.message
                });
            })
            .catch(err => console.log(err))
            .finally(() => setLoading(false));
    };

    return (
        <List.Item
            actions={[
                <Tooltip title="Editar Usuario">
                    <Button type="primary" onClick={() => editUser(user)}>
                        <EditOutlined />
                    </Button>
                </Tooltip>,
                <Tooltip title="Desactivar Usuario">
                    <Button type="danger" onClick={desativateUser} disabled={loading}>
                        <StopOutlined />
                    </Button>
                </Tooltip>,
            ]}
        >
            <List.Item.Meta
                avatar={<Avatar />}
                title={`Usuario: ${user.username} - ${user.rol}`}
                description={`${user.trabajador.rut} - ${user.trabajador.nombre} ${user.trabajador.apellido_paterno} ${user.trabajador.apellido_materno}`}
            />
        </List.Item>
    );
}

function UsersInactive(props) {
    const { usersInactive, reloadUser, setReloadUser } = props;
    return (
        <List
            className="users-active"
            itemLayout="horizontal"
            dataSource={usersInactive}
            renderItem={user => (
                <UserInactive user={user} reloadUser={reloadUser} setReloadUser={setReloadUser} />
            )}
        />
    );
}

function UserInactive(props) {
    const { user, reloadUser, setReloadUser } = props;

    const [loading, setLoading] = useState(false);

    const activateUser = () => {
        setLoading(true);

        Axios.put(`/api/usuario/${user.id}/toggle-activate`)
            .then(res => {
                //console.log(res);
                setReloadUser(!reloadUser);
                notification['success']({
                    message: res.data.message
                });
            })
            .catch(err => console.log(err))
            .finally(() => setLoading(false));
    };

    return (
        <List.Item
            actions={[
                <Tooltip title="Activar Usuario">
                    <Button type="primary" onClick={activateUser} disabled={loading}>
                        <CheckOutlined />
                    </Button>
                </Tooltip>,
            ]}
        >
            <List.Item.Meta
                avatar={<Avatar />}
                title={`Usuario: ${user.username} - ${user.rol}`}
                description={`${user.trabajador.rut} - ${user.trabajador.nombre} ${user.trabajador.apellido_paterno} ${user.trabajador.apellido_materno}`}
            />
        </List.Item>
    );
}

export default ListaUsuarios;
