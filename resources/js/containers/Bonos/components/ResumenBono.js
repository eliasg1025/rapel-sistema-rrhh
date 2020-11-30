import React, { useEffect, useState } from "react";
import { Card, notification, Select } from "antd";
import Axios from "axios";

export const ResumenBono = ({ bono }) => {
    const [disableForm, setDisableForm] = useState(true);

    const [form, setForm] = useState(bono);

    const update = () => {
        Axios.put(`/api/bonos/${bono.id}`, form)
            .then(res => {
                console.log(res);

                notification['success']({
                    message: res.data.message
                });
            })
            .catch(err => console.error(err));
    }

    return (
        <>
            <Card>
                <h5>
                    <span style={{ textDecoration: "underline" }}>Resumen Bono</span>&nbsp;&nbsp;&nbsp;
                    <button className="btn btn-primary btn-sm" onClick={() => setDisableForm(!disableForm)}>
                        <i className="fas fa-pencil-alt"></i>
                    </button>
                </h5>
                <br />
                <div className="row">
                    <div className="col-md-4">
                        Nombre:
                        <br />
                        <input
                            type="text"
                            className="form-control"
                            value={form.name}
                            disabled
                        />
                    </div>
                    <div className="col-md-4">
                        Empresa:
                        <br />
                        <input
                            type="text"
                            className="form-control"
                            value={bono.empresa.shortname}
                            disabled={true}
                        />
                    </div>
                    <div className="col-md-4">
                        Cargado Por:
                        <br />
                        <input
                            type="text"
                            className="form-control"
                            value={bono.usuario.username}
                            disabled={true}
                        />
                    </div>
                    <div className="col-md-12">
                        Descripción:
                        <br />
                        <textarea
                            className="form-control"
                            value={form.descripcion}
                            onChange={e => setForm({ ...form, descripcion: e.target.value })}
                            disabled={disableForm}
                        />
                    </div>
                    <div className="col-md-4">
                        Concepto:
                        <br />
                        <Select
                            value={form.concepto_id}
                            showSearch
                            style={{ width: "100%" }}
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, concepto_id: e })}
                            size="small"
                            disabled={disableForm}
                        >
                            {[].map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Tipo Bono:
                        <br />
                        <Select
                            value={form.tipo_bono}
                            showSearch
                            style={{ width: "100%" }}
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, tipo_bono: e })}
                            size="small"
                            disabled={disableForm}
                        >
                            {['QUINCENAL', 'MENSUAL'].map(e => (
                                <Select.Option value={e} key={e}>
                                    {`${e}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                </div>
                <br />
                <div className="row">
                    {!disableForm && (
                        <div className="col-md-12">
                            <button className="btn btn-primary btn-block" onClick={update}>
                                Actualizar
                            </button>
                        </div>
                    )}
                </div>
            </Card>
        </>
    );
};
