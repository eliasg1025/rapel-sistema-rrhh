import React, { useEffect, useState } from "react";
import { notification, Select, Button, Modal as ModalAnt, Spin } from "antd";

import { SubirArchivo } from "../../shared/SubirArchivo";
import {
    FiniquitosProvider,
    GruposFiniquitosProvider,
    RegimenesProvider,
    TiposCesesProvider,
    TrabajadorProvider
} from "../../../providers";
import { empresa } from "../../../data/default.json";
import Modal from "../../Modal";

const regimenesProvider = new RegimenesProvider();
const tiposCesesProvider = new TiposCesesProvider();
const trabajadoresProvider = new TrabajadorProvider();
const finiquitosProvider = new FiniquitosProvider();
const gruposFiniquitosProvider = new GruposFiniquitosProvider();

const initalFormState = {
    empresa_id: "",
    regimen_id: "",
    tipo_cese_id: "",
    fecha_inicio_periodo: "",
    fecha_termino_contrato: "",
    tiempo_servicio: 0
};

export const CreateFiniquitoForm = ({ reload, setReload, informe }) => {
    const [viewModal, setViewModal] = useState(false);
    const [viewModalImport, setViewModalImport] = useState(false);
    const [loading, setLoading] = useState(false);

    const [estadoCarga, setEstadoCarga] = useState({
        advertencias: [],
        correctos: [],
        errores: []
    });

    const handleEnviar = async () => {
        ModalAnt.confirm({
            title: "Enviar Grupo",
            content: "¿Desea marcar este grupo como ENVIADO?",
            cancelText: "Cancelar",
            okText: "Si, ENVIAR",
            onOk: async function() {
                const {
                    message,
                    status
                } = await gruposFiniquitosProvider.setState(
                    { estado_id: 2 },
                    informe.id
                );

                notification[status]({
                    message: message
                });

                setReload(!reload);
            }
        });
    };

    const handleImprimir = async () => {
        setLoading(true);
        try {
            const {
                message,
                status,
                data
            } = await gruposFiniquitosProvider.print(informe.id);

            notification[status]({
                message: message
            });

            setTimeout(() => {
                window.open(data.file, "_blank");
            }, 1000);
        } catch (err) {
            notification["error"]({
                message: err
            });
        } finally {
            setLoading(false);
        }
    };

    return (
        <>
            {informe?.estado && (
                <Spin spinning={loading}>
                    <div className="row">
                        <div className="col-md-12">
                            <button
                                className="btn btn-primary mr-3"
                                onClick={() => setViewModal(true)}
                            >
                                <i className="fas fa-plus"></i> Agregar
                            </button>
                            <button
                                className="btn btn-success"
                                onClick={() => setViewModalImport(true)}
                            >
                                <i className="far fa-file-excel"></i> Importar
                            </button>
                            {informe?.estado?.name === "PENDIENTE" ? (
                                <button
                                    className="btn btn-outline-dark"
                                    style={{ float: "right" }}
                                    onClick={() => handleEnviar()}
                                >
                                    <i className="fas fa-share"></i> Enviar
                                </button>
                            ) : (
                                <button
                                    className="btn btn-primary"
                                    style={{ float: "right" }}
                                    onClick={() => handleImprimir()}
                                >
                                    <i className="fas fa-file-alt"></i> Imprimir
                                </button>
                            )}
                        </div>
                    </div>
                </Spin>
            )}
            <br />
            {estadoCarga.errores.length > 0 && (
                <div className="alert alert-danger">
                    <ul>
                        {estadoCarga.errores.map(item => {
                            return (
                                <li key={item.data.rut}>
                                    <b>{item.data.rut}</b> - {item.message}
                                </li>
                            );
                        })}
                    </ul>
                </div>
            )}
            {estadoCarga.advertencias.length > 0 && (
                <div className="alert alert-warning">
                    <ul>
                        {estadoCarga.advertencias.map(item => {
                            return (
                                <li key={item.data.rut}>
                                    <b>{item.data.rut}</b> - {item.message}
                                </li>
                            );
                        })}
                    </ul>
                </div>
            )}
            {estadoCarga.correctos.length > 0 && (
                <div className="alert alert-success">
                    <ul>
                        {estadoCarga.correctos.map(item => {
                            return (
                                <li key={item.data.rut}>
                                    <b>{item.data.rut}</b> - {item.message}
                                </li>
                            );
                        })}
                    </ul>
                </div>
            )}
            <Modal
                isVisible={viewModal}
                setIsVisible={setViewModal}
                title="Agregar Finiquito"
                width={1000}
            >
                <FiniquitoForm
                    informe={informe}
                    reload={reload}
                    setReload={setReload}
                />
            </Modal>
            <Modal
                isVisible={viewModalImport}
                setIsVisible={setViewModalImport}
                title="Importar Finiquito"
            >
                <ImportarFiniquitosForm
                    informe={informe}
                    reload={reload}
                    setReload={setReload}
                    setEstadoCarga={setEstadoCarga}
                />
            </Modal>
        </>
    );
};

const FiniquitoForm = ({ reload, setReload, informe }) => {
    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const [loadingRut, setLoadingRut] = useState(false);
    const [loading, setLoading] = useState(false);
    const [rut, setRut] = useState("");

    const [regimenes, setRegimenes] = useState([]);
    const [tiposCeses, setTiposCeses] = useState([]);

    const [form, setForm] = useState(initalFormState);

    const buscarTrabajador = async e => {
        e.preventDefault();
        setLoadingRut(true);

        try {
            const {
                message,
                data
            } = await trabajadoresProvider.getParaFiniquito(
                rut,
                informe.fecha_finiquito
            );
            notification["success"]({
                message: message
            });
            await setForm(data);
        } catch (e) {
            notification["error"]({
                message: e.message
            });
        } finally {
            setLoadingRut(false);
        }
    };

    const handleSubmit = async e => {
        e.preventDefault();

        setLoading(true);
        try {
            const { message, data, status } = await finiquitosProvider.create({
                ...form,
                grupo_finiquito_id: informe.id,
                usuario_id: usuario.id
            });

            await notification[status]({
                message: message
            });

            setForm(initalFormState);
            setReload(!reload);
        } catch (e) {
            console.log(e);

            await notification["error"]({
                message: e.message
            });
        } finally {
            setLoading(false);
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
    }, []);

    return (
        <>
            <div className="row">
                <form className="col-md-4" onSubmit={buscarTrabajador}>
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
                <div className="col-md-4">
                    Empresa:
                    <br />
                    <Select
                        value={parseInt(form.empresa_id) || ""}
                        showSearch
                        style={{ width: "100%" }}
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, empresa_id: e })}
                        size="small"
                        disabled
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
            <form onSubmit={handleSubmit}>
                <div className="row">
                    <div className="col-md-4">
                        Regimen:
                        <br />
                        <Select
                            value={parseInt(form.regimen_id) || ""}
                            showSearch
                            style={{ width: "100%" }}
                            optionFilterProp="children"
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            onChange={e => setForm({ ...form, regimen_id: e })}
                            size="small"
                            disabled
                        >
                            {regimenes.map(e => (
                                <Select.Option value={e.id} key={e.id}>
                                    {`${e.id} - ${e.name}`}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Fecha Inicio Periodo:
                        <br />
                        <input
                            type="text"
                            className="form-control"
                            disabled
                            value={form?.fecha_inicio_periodo}
                        />
                    </div>
                    <div className="col-md-4">
                        Fecha Termino Contrato:
                        <br />
                        <input
                            type="text"
                            className="form-control"
                            disabled
                            value={form?.fecha_termino_contrato}
                        />
                    </div>
                </div>
                <br />
                <div className="row">
                    <div className="col-md-4">
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
                    </div>
                    <div className="col-md-4">
                        Tiempo de Servicio (meses):
                        <br />
                        <input
                            className="form-control"
                            type="text"
                            disabled
                            value={form.tiempo_servicio}
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
                        >
                            Enviar
                        </Button>
                    </div>
                </div>
            </form>
        </>
    );
};

const ImportarFiniquitosForm = ({
    reload,
    setReload,
    informe,
    setEstadoCarga
}) => {
    const [loading, setLoading] = useState(false);
    const [form, setForm] = useState({
        fecha_finiquito: informe.fecha_finiquito,
        grupo_finiquito_id: informe.id
    });

    const handleSubmit = async e => {
        e.preventDefault();

        setLoading(true);
        try {
            const { message, data, status } = await finiquitosProvider.import(
                form
            );

            notification[status]({
                message: message
            });

            setEstadoCarga(data);
            setReload(!reload);
        } catch (e) {
            console.log(e);

            notification["error"]({
                message: "Error"
            });
        } finally {
            setLoading(false);
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <SubirArchivo form={form} setForm={setForm} />
            <br />
            <Button
                type="primary"
                htmlType="submit"
                block
                disabled={!form.file}
                loading={loading}
            >
                Cargar
            </Button>
        </form>
    );
};
