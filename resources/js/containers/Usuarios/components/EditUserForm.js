import React, { useState, useEffect } from 'react';
import {
    Form,
    Input,
    Select,
    Button,
    Row,
    Col,
    notification
} from 'antd';
import { UserOutlined, LockOutlined } from '@ant-design/icons';
import Axios from 'axios';

export default function EditUserForm(props) {
    const { user, setIsVisibleModal, setReloadUser } = props;
    const [userData, setUserData] = useState({});

    useEffect(() => {
        setUserData({
            username: user.username,
            rol: user.rol,
            password: '',
            confirm_password: ''
        });
    }, [user]);

    const updateUser = e => {
        e.preventDefault();
        let userUpdate = userData;

        if (userUpdate.password || userUpdate.confirm_password) {
            if (userUpdate.password !== userUpdate.confirm_password) {
                notification['error']({
                    message: 'Las contraseñas tienen que ser iguales'
                });
                return;
            } else {
                console.log(userUpdate);
            }
        }

        if (!userUpdate.username || !userUpdate.rol) {
            notification['error']({
                message: 'El username y rol son obligatorios'
            });
            return;
        }
        //console.log('Usuario a actualizar', userUpdate);

        Axios.put(`/api/usuario/${user.id}`, userUpdate)
            .then(res => {
                console.log(res);
                notification['success']({
                    message: res.data.message
                });
            })
            .catch(err => {
                //console.log(err);
                notification['error']({
                    message: err.response.message
                });
            })
            .finally(() => {
                setIsVisibleModal(false);
                setReloadUser(true);
            });
        /*
        updateUserApi(token, userUpdate, user.id)
            .then(res => {
                notification['success']({
                    message: res.response.message
                });
            })
            .catch(err => {
                notification['success']({
                    message: err.response.response.message
                });
            })
            .finally(() => {
                setIsVisibleModal(false);
                setReloadUser(true);
            });*/
    };

    return (
        <div className='edit-user-form'>
            <EditForm
                userData={userData}
                setUserData={setUserData}
                updateUser={updateUser}
            />
        </div>
    );
}


function EditForm(props) {
    const { userData, setUserData, updateUser } = props;
    const { Option } = Select;

    return (
        <Form className="form-add" onSubmitCapture={updateUser}>
            <Row gutter={24}>
                <Col span={12}>
                    <Form.Item>
                        <Input
                            prefix={<UserOutlined />}
                            placeholder="Nombre de Usuario"
                            value={userData.username}
                            onChange={e =>
                                setUserData({
                                    ...userData,
                                    username: e.target.value,
                                })
                            }
                        />
                    </Form.Item>
                </Col>
                <Col span={12}>
                    <Form.Item initialValue="defecto">
                        <Select
                            placeholder="Selecciona un rol"
                            onChange={e =>
                                setUserData({ ...userData, rol: e })
                            }
                            value={userData.rol}
                        >
                            <Option value="defecto">Por defecto</Option>
                            <Option value="admin">Administrador</Option>
                        </Select>
                    </Form.Item>
                </Col>
            </Row>
            <Row gutter={24}>
                <Col span={12}>
                    <Form.Item>
                        <Input
                            prefix={<LockOutlined />}
                            placeholder="Contraseña"
                            type="password"
                            onChange={e =>
                                setUserData({
                                    ...userData,
                                    password: e.target.value,
                                })
                            }
                        />
                    </Form.Item>
                </Col>
                <Col span={12}>
                    <Form.Item>
                        <Input
                            prefix={<LockOutlined />}
                            placeholder="Repetir contraseña"
                            type="password"
                            onChange={e =>
                                setUserData({
                                    ...userData,
                                    confirm_password: e.target.value,
                                })
                            }
                        />
                    </Form.Item>
                </Col>
            </Row>
            <Form.Item>
                <Button type="primary" htmlType="submit" className="btn-submit">
                    Actualizar Usuario
                </Button>
            </Form.Item>
        </Form>
    );
}
