import { Button, notification, Card, Divider, List } from 'antd';
import Axios from 'axios';
import React, { useState, useEffect } from 'react';

import Modal from '../Modal';
import Estadisticas from './components/Estadisticas';


export default function Perfil() {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const [isVisible, setIsVisible] = useState(false);
    const [loading, setLoading] = useState(false);
    const [changePasswordForm, setChangePasswordForm] = useState({
        password: '',
        confirmPassword: '',
    });

    const [rolesUsuario, setRolesUsuario] = useState([]);

    useEffect(() => {
        Axios.get(`/api/usuario/${usuario.id}/roles`)
            .then(res => {
                //console.log(res);
                setRolesUsuario(res.data.filter(item => item.nivel > 0));
            })
            .catch(err => {
                console.log(err);
            });
    }, []);

    const handleSubmit = e => {
        e.preventDefault();

        if (changePasswordForm.password.length < 6 && changePasswordForm.confirmPassword.length < 6)
        {
            notification['warning']({
                message: 'La contraseña debe tener de 6 a más caractéres'
            });
            return;
        }

        if (changePasswordForm.password !== changePasswordForm.confirmPassword)
        {
            notification['warning']({
                message: 'Las contraseñas deben ser iguales'
            });
            return;
        }

        setLoading(true);
        Axios.post('/perfil/change-password', {
            usuarioId: usuario.id,
            password: changePasswordForm.password,
            confirmPassword: changePasswordForm.confirmPassword
        })
            .then(res => {
                //console.log(res);
                notification['success']({
                    message: res.data.message
                });

                Axios.post('/logout')
                    .then(res => {
                        setTimeout(() => {
                            window.location.replace("/")
                        }, 1500);
                    });
            })
            .catch(err => {
                console.log(err);
                notification['warning']({
                    message: 'Error al cambiar la contraseña'
                });
            }).finally(() => setLoading(false));
    };

    return (
        <>
            <div className="container p-5">
                <div className="row">
                    <RightSide
                        usuario={usuario}
                        setIsVisible={setIsVisible}
                        rolesUsuario={rolesUsuario}
                    />
                    <LeftSide
                        usuario={usuario}
                        rolesUsuario={rolesUsuario}
                    />
                </div>
            </div>

            <Modal
                isVisible={isVisible}
                setIsVisible={setIsVisible}
                title="Cambiar Contraseña"
            >
                <form onSubmit={handleSubmit}>
                    <div className="form-group">
                        Nueva Contraseña:<br />
                        <input
                            type="password" className="form-control"
                            onChange={e => setChangePasswordForm({ ...changePasswordForm, password: e.target.value })}
                        />
                    </div>
                    <div className="form-group">
                        Repetir Contraseña:<br />
                        <input
                            type="password" className="form-control"
                            onChange={e => setChangePasswordForm({ ...changePasswordForm, confirmPassword: e.target.value })}
                        />
                    </div>
                    <div className="form-group">
                        <Button
                            type="primary" htmlType="submit" loading={loading}
                        >
                            Cambiar
                        </Button>
                    </div>
                </form>
            </Modal>
        </>
    );
}

const RightSide = ({ rolesUsuario, usuario, setIsVisible }) => {

    const getNivelUsuario = (nivel) => {
        switch (nivel) {
            case 1:
                return 'SUPERVISOR';
            case 2:
                return 'ADMINISTRADOR';
            default:
                return nivel;
        }
    }

    return (
        <div className="col-md-6">
            <Card>
                <h3>{ `${usuario.trabajador.nombre} ${usuario.trabajador.apellido_paterno} ${usuario.trabajador.apellido_materno}` }<br /><small>{ usuario.username }</small></h3>
                <button className="btn btn-sm btn-primary" onClick={() => setIsVisible(true)}>
                    Cambiar contraseña
                </button>
            </Card>
            <br />
            <Divider orientation="left">
                <h4>Permisos de usuario</h4>
            </Divider>
            <Card>
                <List
                    itemLayout="horizontal"
                    dataSource={rolesUsuario}
                    renderItem={item => (
                        <List.Item>
                            <List.Item.Meta
                                title={item.modulo.toUpperCase()}
                                description={getNivelUsuario(item.nivel)}
                            />
                        </List.Item>
                    )}
                />
            </Card>
        </div>
    );
}

const LeftSide = ({ usuario, rolesUsuario }) => {

    return (
        <div className="col-md-6">
            <div className="text-center">
                <h3>Estadísticas</h3>
                <br />
                <Estadisticas
                    usuario={usuario}
                    rolesUsuario={rolesUsuario}
                />
            </div>
        </div>
    );
};
