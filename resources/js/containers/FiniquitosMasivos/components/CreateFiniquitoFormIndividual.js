import React, { useState, useEffect } from "react";
import { Select, notification, Button } from "antd";
import moment from "moment";

import {
    TrabajadorProvider,
    RegimenesProvider,
    TiposCesesProvider,
    FiniquitosProvider
} from "../../../providers";

import { empresa } from "../../../data/default.json";
import Axios from "axios";

export const CreateFiniquitoFormIndividual = ({
    reload,
    setReload,
    form,
    setForm
}) => {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const trabajadoresProvider = new TrabajadorProvider();
    const regimenesProvider = new RegimenesProvider();
    const tiposCesesProvider = new TiposCesesProvider();
    const finiquitosProvider = new FiniquitosProvider();

    const [loadingRut, setLoadingRut] = useState(false);
    const [loading, setLoading] = useState(false);
    const [rut, setRut] = useState("");

    const [regimenes, setRegimenes] = useState([]);
    const [tiposCeses, setTiposCeses] = useState([]);
    const [zonasLabor, setZonasLabor] = useState([]);

    const initalFormState = {
        id: "",
        empresa_id: "",
        regimen_id: "",
        tipo_cese_id: 2,
        fecha_inicio_periodo: "",
        fecha_termino_contrato: "",
        zona_labor: "",
        tiempo_servicio: 0,
        fecha_finiquito: moment().format("YYYY-MM-DD")
    };

    const handleSubmit = async e => {
        e.preventDefault();

        setLoading(true);
        try {
            const { message, data, status } = await finiquitosProvider.create({
                ...form,
                grupo_finiquito_id: null,
                usuario_id: usuario.id,
                fecha_finiquito: form.fecha_finiquito,
                zona_labor: form.zona_labor
            });

            await notification[status]({
                message: message
            });

            if (status === "success") {
                setForm(initalFormState);
                setRut("");
                setReload(!reload);
                window.open(`/ficha/cese/${data.id}`, '_blank');
            }

        } catch (e) {
            console.log(e);

            await notification["error"]({
                message: e.message
            });
        } finally {
            setLoading(false);
        }
    };

    const handleSubmitBuscarTrabajador = e => {
        e.preventDefault();
        buscarTrabajador();
    };

    const buscarTrabajador = async () => {
        setLoadingRut(true);

        try {
            const {
                message,
                data
            } = await trabajadoresProvider.getParaFiniquito(
                rut,
                form.fecha_finiquito,
                1
            );
            notification["success"]({
                message: message
            });
            await setForm({
                ...data,
                fecha_finiquito: form.fecha_finiquito
            });
        } catch (e) {
            notification["error"]({
                message: e.message
            });
        } finally {
            setLoadingRut(false);
        }
    };

    useEffect(() => {
        async function fetchData() {
            const { data: regimenes } = await regimenesProvider.get();
            const { data: ceses } = await tiposCesesProvider.get();

            setRegimenes(regimenes);
            setTiposCeses(ceses);
        }

        fetchData();

        Axios.get("/api/zona-labor")
            .then(res => {
                setZonasLabor(res.data);
            })
            .catch(err => {
                console.error(err);
            });
    }, []);

    return (
        <>
            <div className="row">
                <div className="col-md-4">
                    Fecha Finiquito:
                    <br />
                    <input
                        type="date"
                        className="form-control"
                        value={form?.fecha_finiquito}
                        onChange={e =>
                            setForm({
                                ...form,
                                fecha_finiquito: e.target.value
                            })
                        }
                        onBlur={() => {
                            if (form?.rut?.length >= 8) {
                                buscarTrabajador();
                            }
                        }}
                    />
                </div>
                <form
                    className="col-md-4"
                    onSubmit={handleSubmitBuscarTrabajador}
                >
                    RUT:
                    <br />
                    <div className="input-group">
                        <input
                            type="text"
                            className="form-control"
                            name="_rut"
                            autoComplete="off"
                            placeholder="Buscar por RUT"
                            value={rut}
                            onChange={e => setRut(e.target.value)}
                        />
                        <div className="input-group-append">
                            <button
                                className="btn btn-primary"
                                type="submit"
                                disabled={loadingRut || rut.length < 8}
                            >
                                {!loadingRut ? (
                                    <i className="fas fa-search"></i>
                                ) : (
                                    <i className="fas fa-spinner fa-spin"></i>
                                )}
                            </button>
                        </div>
                    </div>
                </form>
                <div className="col-md-4">
                    Trabajador:
                    <br />
                    <input
                        className="form-control"
                        value={`${form?.nombre ||
                            ""} ${form?.apellido_paterno ||
                            ""} ${form?.apellido_materno || ""}`}
                        readOnly={true}
                    />
                </div>
            </div>
            <br />
            <form onSubmit={handleSubmit}>
                <div className="row">
                    {/* <div className="col-md-4">
                        Tipo Cese:
                        <br />
                        <Select
                            value={form.tipo_cese_id}
                            showSearch
                            style={{ width: "100%" }}
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e =>
                                setForm({ ...form, tipo_cese_id: e })
                            }
                            size="small"
                        >
                            {tiposCeses.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div> */}
                    <div className="col-md-4">
                        Zona Labor Envio:
                        <br />
                        <Select
                            value={form?.zona_labor || ""}
                            showSearch
                            style={{ width: "100%" }}
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, zona_labor: e })}
                            size="small"
                        >
                            {zonasLabor.map(e => (
                                <Select.Option value={e.name} key={e.name}>
                                    {`${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Empresa:
                        <br />
                        <select
                            className="form-control"
                            value={parseInt(form.empresa_id) || ""}
                            onChange={e => setForm({ ...form, empresa_id: e })}
                            disabled
                        >
                            {empresa.map(e => (
                                <option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.name}`}
                                </option>
                            ))}
                        </select>
                    </div>
                    <div className="col-md-4">
                        Oficio:
                        <br />
                        <input
                            className="form-control"
                            value={form?.oficio?.name || ""}
                            disabled
                        />
                    </div>
                </div>
                <br />
                <div className="row">
                    <div className="col-md-4">
                        Tiempo de Servicio a la fecha (meses):
                        <br />
                        <input
                            className="form-control"
                            type="text"
                            disabled
                            value={form.tiempo_servicio}
                        />
                    </div>
                    {/* <div className="col-md-4">
                        Regimen:
                        <br />
                        <select
                            className="form-control"
                            value={parseInt(form.regimen_id) || ""}
                            onChange={e => setForm({ ...form, regimen_id: e })}
                            disabled
                        >
                            {regimenes.map(e => (
                                <option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.name}`}
                                </option>
                            ))}
                        </select>
                    </div> */}
                    <div className="col-md-4">
                        Fecha Inicio Periodo:
                        <br />
                        <input
                            type="date"
                            className="form-control"
                            disabled
                            value={form?.fecha_inicio_periodo}
                        />
                    </div>
                    <div className="col-md-4">
                        Fecha Termino Contrato:
                        <br />
                        <input
                            type="date"
                            className="form-control"
                            disabled
                            value={form?.fecha_termino_contrato}
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
                            loading={loading}
                            disabled={!form.zona_labor}
                        >
                            Emitir
                        </Button>
                    </div>
                </div>
            </form>
        </>
    );
};
