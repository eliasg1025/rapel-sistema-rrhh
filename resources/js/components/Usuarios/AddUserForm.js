import React, { useState } from 'react';
import {
    Form,
    Input,
    Select,
    Button,
    Row,
    Col,
    notification,
    message,
} from 'antd';
import { UserOutlined, LockOutlined } from '@ant-design/icons';
import moment from 'moment';

import Axios from 'axios';

export default function AddUserForm(props) {
    const { setIsVisibleModal, setReloadUser } = props;
    const [userData, setUserData] = useState({});
    const [trabajadorData, setTrabajadorData] = useState({});
    const [found, setFound] = useState(false);

    const addUser = event => {
        event.preventDefault();

        if (
            !userData.username ||
            !userData.password ||
            !userData.confirm_password ||
            !userData.rol
        ) {
            message['error']({
                content: 'Todos los campos son obligatorios',
            });
        } else if (userData.password !== userData.confirm_password) {
            message['error']({
                content: 'Las contraseña tiene que ser iguales',
            });
        } else {
            const data = {
                ...userData,
                trabajador: trabajadorData
            };
            console.log('Usuario a registrar', data);
            createUser(data);
        }
    };

    const createUser = (data) => {
        Axios.post('/api/usuario', data)
            .then(res => {
                notification['success']({
                    message: res.message,
                });
            })
            .catch(err =>  {
                console.log(err);
                notification['error']({
                    message: err.message,
                });
            });
        /*
        createUserApi(token, data)
            .then(response => {
                notification['success']({
                    message: response.response.message,
                });
                setIsVisibleModal(false);
                setReloadUser(true);
                setUserData({});
            })
            .catch(err => {
                notification['error']({
                    message: err.response.response.message,
                });
            });*/
    };

    return (
        <div className="add-user-form">
            <BuscarTrabajador
                trabajador={trabajadorData}
                setTrabajador={setTrabajadorData}
                setFound={setFound}
            />
            <AddForm
                userData={userData}
                setUserData={setUserData}
                addUser={addUser}
                found={found}
            />
        </div>
    );
}

const BuscarTrabajador = props => {
    const { trabajador, setTrabajador, setFound } = props;
    const [loading, setLoading] = useState(false);

    const buscar = async rut => {
        setLoading(true);
        try {
            const { data, status } = await Axios.get(`http://192.168.60.16/api/trabajador/${rut}`);
            if (status < 300) {
                formatBeforeInsert(data.data.trabajador);
                message['success']({
                    content: data.message,
                });
                setFound(true);
            }
        } catch (err) {
            console.log(err);
            notification['error']({
                message:
                    'Error del servidor, probablemente la conexión no este disponible. Consulte con el administrador del sistema',
            });
        } finally {
            setLoading(false);
        }
    };

    const handleChangeInput = e => {
        const { name, value } = e.target;
        setTrabajador({
            ...trabajador,
            [name]: value,
        });
    };

    const formatBeforeInsert = _trabajador => {
        setTrabajador({
            ...trabajador,
            rut: _trabajador.rut,
            distrito_id: _trabajador.distrito_id,
            nombre: _trabajador.nombre,
            apellido_paterno: _trabajador.apellido_paterno,
            apellido_materno: _trabajador.apellido_materno,
            direccion: _trabajador.direccion || '',
            telefono: _trabajador.telefono || '',
            fecha_nacimiento: moment(_trabajador.fecha_nacimiento)
                .format('YYYY-MM-DD')
                .toString(),
            nombre_zona: _trabajador.nombre_zona || '',
            nombre_via: _trabajador.nombre_via || '',
            sexo: _trabajador.sexo,
            nacionalidad_id: _trabajador.nacionalidad_id,
            tipo_via_id: _trabajador.tipo_via_id || '',
            tipo_zona_id: _trabajador.tipo_zona_id || '',
            estado_civil_id: _trabajador.estado_civil_id,
            empresa_id: _trabajador.empresa_id
        });
    };

    return (
        <Form>
            <Row gutter={24}>
                <Col span={12}>
                    <Form.Item>
                        <Input.Search
                            placeholder="RUT Trabajador"
                            name="rut"
                            value={trabajador.rut}
                            onSearch={buscar}
                            loading={loading}
                            onChange={handleChangeInput}
                        />
                    </Form.Item>
                </Col>
                <Col span={12}>
                    <Form.Item>
                        <Input
                            placeholder="Nombre"
                            value={`${trabajador.nombre || ''} ${trabajador.apellido_paterno || ''} ${trabajador.apellido_materno || ''}`}
                        />
                    </Form.Item>
                </Col>
            </Row>
        </Form>
    );
};

const AddForm = props => {
    const { userData, setUserData, addUser, found } = props;
    const { Option } = Select;

    return (
        <Form className="form-add" onSubmitCapture={addUser}>
            <Row gutter={24}>
                <Col span={12}>
                    <Form.Item>
                        <Input
                            prefix={<UserOutlined />}
                            placeholder="Nombre de Usuario"
                            value={userData.username}
                            disabled={!found}
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
                            disabled={!found}
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
                            value={userData.password}
                            onChange={e =>
                                setUserData({
                                    ...userData,
                                    password: e.target.value,
                                })
                            }
                            disabled={!found}
                        />
                    </Form.Item>
                </Col>
                <Col span={12}>
                    <Form.Item>
                        <Input
                            prefix={<LockOutlined />}
                            placeholder="Repetir contraseña"
                            value={userData.confirm_password}
                            type="password"
                            onChange={e =>
                                setUserData({
                                    ...userData,
                                    confirm_password: e.target.value,
                                })
                            }
                            disabled={!found}
                        />
                    </Form.Item>
                </Col>
            </Row>
            <Form.Item>
                <Button type="primary" htmlType="submit" className="btn-submit" disabled={!found}>
                    Crear Usuario
                </Button>
            </Form.Item>
        </Form>
    );
};
