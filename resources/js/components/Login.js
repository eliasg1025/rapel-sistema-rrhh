import React from "react";
import ReactDOM from "react-dom";
import { Layout, Card, Form, Input, Button, Spin, notification } from "antd";

const Login = () => {
    return (
        <Layout className="sign-in">
            <Layout.Content className="sign-in__content">
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
                <div>
                    <div className="card" style={{ width: "500px" }}>
                        <div className="card-body">
                            <form method="POST" action="/login">
                                <div className="form-group">
                                    <label className="col-sm-3">Usuario</label>
                                    <div className="col-sm-9">
                                        <input className="form-control" name="username" />
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label className="col-sm-3">Contraseña</label>
                                    <div className="col-sm-9">
                                        <input type="password" className="form-control" name="password" />
                                    </div>
                                </div>
                                <div className="form-group">
                                    <button type="submit" className="btn btn-primary">
                                        Ingresar
                                    </button>
                                </div>
                            </form>
                        </div>
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
