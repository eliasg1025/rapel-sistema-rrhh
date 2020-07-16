import React from "react";
import ReactDOM from "react-dom";
import { Layout, Card, Form, Input, Button, Spin, notification } from "antd";

const Login = () => {
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

                <div className="card login">
                    <div className="card-body">
                        <form method="POST" action="/login">
                            <div className="form-group">
                                <label className="col-sm-3">Usuario</label>
                                <div className="col-sm-12">
                                    <input className="form-control" name="username" />
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="col-sm-3">Contraseña</label>
                                <div className="col-sm-12">
                                    <input type="password" className="form-control" name="password" />
                                </div>
                            </div>
                            <div className="form-group">
                                <button type="submit" className="btn btn-primary btn-block">
                                    Ingresar
                                </button>
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
