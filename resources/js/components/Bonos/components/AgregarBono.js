import React, { useState } from "react";
import { Button, Input, message, notification, Select, Text } from "antd";

import Modal from "../../Modal";
import { empresa } from "../../../data/default.json";
import Axios from "axios";

export const AgregarBono = ({ reload, setReload }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem("data"));

    const [view, setView] = useState(false);
    const [form, setForm] = useState({
        name: "",
        empresaId: "",
        descripcion: ""
    });

    const validForm = form.name !== "" && form.empresaId !== "";

    const handleSubmit = e => {
        e.preventDefault();

        Axios.post("/api/bonos", {
            ...form,
            usuarioId: usuario.id
        })
            .then(res => {
                const { message, data } = res.data;

                setReload(!reload);
                setView(false);
                notification["success"]({
                    message: message
                });

                setTimeout(() => {
                    location.replace(`/bonos/editar/${data.id}`);
                }, 1500);
            })
            .catch(err => {
                console.error(err);
            });
    };

    return (
        <>
            <Button type="dashed" block onClick={() => setView(true)}>
                <i className="fas fa-plus" />
                &nbsp;&nbsp;Crear Nuevo Bono
            </Button>
            <Modal title="Bono" isVisible={view} setIsVisible={setView}>
                <form onSubmit={handleSubmit}>
                    <div className="row">
                        <div className="col-md-12">
                            Nombre*:
                            <br />
                            <Input
                                type="text"
                                value={form.name}
                                onChange={e =>
                                    setForm({ ...form, name: e.target.value })
                                }
                            />
                        </div>
                    </div>
                    <br />
                    <div className="row">
                        <div className="col-md-12">
                            Empresa*:
                            <br />
                            <Select
                                value={form.empresaId}
                                showSearch
                                style={{ width: "100%" }}
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setForm({ ...form, empresaId: e })
                                }
                            >
                                {empresa.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.id} - ${e.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                    </div>
                    <br />
                    <div className="row">
                        <div className="col-md-12">
                            Descripción:
                            <br />
                            <Input.TextArea
                                value={form.descripcion}
                                onChange={e =>
                                    setForm({
                                        ...form,
                                        descripcion: e.target.value
                                    })
                                }
                            />
                        </div>
                    </div>
                    <br />
                    <div className="row">
                        <div className="col-md-12">
                            <Button
                                type="primary"
                                htmlType="submit"
                                block
                                disabled={!validForm}
                            >
                                Agregar
                            </Button>
                        </div>
                    </div>
                </form>
            </Modal>
        </>
    );
};
