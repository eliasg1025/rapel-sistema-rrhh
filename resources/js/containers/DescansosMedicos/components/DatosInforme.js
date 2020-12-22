import React, { useState } from "react";
import { DatePicker, message, Select, notification } from "antd";
import moment from "moment";
import Axios from "axios";

import Modal from "../../Modal";
import { empresa } from "../../../data/default.json";

export const DatosInforme = ({ reloadData, setReloadData }) => {
    const { usuario } = JSON.parse(sessionStorage.getItem("data"));

    const [viewModal, setViewModal] = useState(false);
    const [form, setForm] = useState({
        empresa_id: "",
        fecha_inicio: moment()
            .format("YYYY-MM-DD")
            .toString()
    });
    const [filtro, setFiltro] = useState({
        desde: moment()
            .format("YYYY-MM-DD")
            .toString(),
        hasta: moment()
            .format("YYYY-MM-DD")
            .toString()
    });

    const handleSubmit = e => {
        e.preventDefault();

        Axios.post(`/api/informes-descansos`, {
            usuarioId: usuario.id,
            empresaId: form.empresa_id,
            fechaInicio: form.fecha_inicio
        })
            .then(res => {
                notification["success"]({
                    message: res.data.message
                });
                setReloadData(!reloadData);
            })
            .catch(err => {
                console.error(err);
                notification["error"]({
                    message: err.response.data.message
                });
            });
    };

    const exportRecords = () => {
        /* Axios.get(`/api/registros-descansos/export?desde=${filtro.desde}&hasta=${filtro.hasta}`)
            .then(res => {
                console.log(res);
            })
            .catch(err => {
                console.error(err)
            }); */

        window.open(
            `/api/registros-descansos/export?desde=${filtro.desde}&hasta=${filtro.hasta}`,
            "_blank"
        );
    };

    return (
        <>
            <form onSubmit={handleSubmit} className="card">
                <div className="card-body">
                    <div className="row">
                        <div className="form-group col-md-4">
                            Empresa:
                            <br />
                            <Select
                                value={form.empresa_id}
                                showSearch
                                style={{ width: "100%" }}
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setForm({ ...form, empresa_id: e })
                                }
                                size="small"
                            >
                                {empresa.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.id} - ${e.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                        <div className="form-group col-md-4">
                            Fecha Informe:
                            <br />
                            <input
                                type="text"
                                name="fecha_inicio"
                                placeholder="Fecha Informe"
                                readOnly={true}
                                className="form-control"
                                value={form.fecha_inicio}
                                onChange={e =>
                                    setForm({
                                        ...form,
                                        fecha_inicio: e.target.value
                                    })
                                }
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="form-group col-md-4">
                            <button type="submit" className="btn btn-primary">
                                Comenzar Informe
                            </button>
                            <button
                                type="button"
                                className="ml-2 btn btn-success"
                                onClick={() => setViewModal(true)}
                            >
                                Exportar registros
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <Modal
                isVisible={viewModal}
                setIsVisible={setViewModal}
                title="Exportar"
            >
                <form>
                    <div className="row">
                        <div className="col-md-12">
                            Desde - Hasta:
                            <br />
                            <DatePicker.RangePicker
                                placeholder={["Desde", "Hasta"]}
                                style={{ width: "100%" }}
                                onChange={(date, dateString) => {
                                    setFiltro({
                                        ...filtro,
                                        desde: dateString[0],
                                        hasta: dateString[1]
                                    });
                                }}
                                value={[
                                    moment(filtro.desde),
                                    moment(filtro.hasta)
                                ]}
                            />
                        </div>
                        <div className="col-md-12 mt-3">
                            <a
                                className="btn btn-sm btn-primary btn-block"
                                href={`/api/registros-descansos/export?desde=${filtro.desde}&hasta=${filtro.hasta}`}
                                target="_blank"
                            >
                                Exportar
                            </a>
                        </div>
                    </div>
                </form>
            </Modal>
        </>
    );
};
