import React, { useState } from "react";
import ReactDOM from "react-dom";
import { Layout, Card, Form, Input, Button, Spin, notification } from "antd";
import { EyeInvisibleOutlined, EyeTwoTone  } from '@ant-design/icons';

const Login = () => {

    const [form, setForm] = useState({
        username: '',
        password: '',
    });

    const handleInput = e => {
        setForm({
            ...form,
            [e.target.name]: e.target.value
        });
    }

    return (
        <Layout className="sign-in">
            <Layout.Content className="sign-in__content" style={{ height: "100vh" }}>
                <h1
                    className="sign-in__content-logo"
                    style={{ padding: "60px 20px" }}
                >
                    <img
                        src="/img/logo-grupo-verfrut.png"
                        alt="Logo Grupo Verfrut"
                        width={300}
                    />
                </h1>

                <div className="card login" style={{ borderRadius: '4px' }}>
                    <div className="card-body">
                        <form method="POST" action="/login">
                            <div className="form-group">
                                <label className="col-sm-3" style={{ fontSize: '13px' }}>Usuario</label>
                                <div className="col-sm-12">
                                    <Input
                                        name="username"
                                        placeholder="Ingrese nombre de usuario"
                                        onChange={handleInput}
                                    />
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="col-sm-3" style={{ fontSize: '13px' }}>Contraseña</label>
                                <div className="col-sm-12">
                                    <Input.Password
                                        name="password"
                                        placeholder="Ingrese contraseña"
                                        iconRender={visible => (visible ? <EyeTwoTone /> : <EyeInvisibleOutlined />)}
                                        onChange={handleInput}
                                    />
                                </div>
                            </div>
                            <br />
                            <div className="form-group">
                                <div className="col-sm-12">
                                    <button
                                        type="submit"
                                        className="btn btn-primary btn-lg btn-block"
                                        style={{ backgroundColor: '#010066', borderColor: '#010066', borderRadius: '3px' }}
                                        disabled={form.username === '' || form.password === '' || form.password.length < 6}
                                    >
                                        INGRESAR
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </Layout.Content>
        </Layout>
    );
};

export default Login;

if (document.getElementById("login")) {
    ReactDOM.render(<Login />, document.getElementById("login"));
}
