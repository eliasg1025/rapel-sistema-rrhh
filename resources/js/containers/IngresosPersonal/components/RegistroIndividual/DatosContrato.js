import React, { useState, useEffect } from "react";
import {
    Card,
    Form,
    Input,
    Select,
    Row,
    Col,
    DatePicker,
    notification,
    message
} from "antd";
import Axios from "axios";
import moment from "moment";

import { empresa, tipos_trabajadores } from "../../../../data/default.json";

const DatosContrato = props => {
    const {
        setDatosContratoValido,
        contrato,
        setContrato,
        regimenes,
        oficios,
        actividades,
        agrupaciones,
        tiposContratos,
        cuarteles,
        labores,
        zonasLabor,
        rutas,
        troncales,
        setRegimenes,
        setOficios,
        setActividades,
        setAgrupaciones,
        setTiposContratos,
        setCuarteles,
        setLabores,
        setZonasLabor,
        setRutas,
        setTroncales
    } = props;

    const [loadingZonaLabores, setLoadingZonaLabores] = useState(false);
    const [loadingRegimenes, setLoadingRegimenes] = useState(false);
    const [loadingOficios, setLoadingOficios] = useState(false);
    const [loadingActividades, setLoadingActividades] = useState(false);
    const [loadingAgrupaciones, setLoadingAgrupaciones] = useState(false);
    const [loadingTiposContratos, setLoadingTiposContratos] = useState(false);
    const [loadingCuarteles, setLoadingCuarteles] = useState(false);
    const [loadingLabores, setLoadingLabores] = useState(false);
    const [loadingTroncales, setLoadingTroncales] = useState(false);
    const [loadingRutas, setLoadingRutas] = useState(false);

    const layout = {
        labelCol: {
            md: 6
        }
    };

    const handleChangeInput = e => {
        const { name, value } = e.target;
        setContrato({
            ...contrato,
            [name]: value
        });
    };

    const validacionDatosContrato = () => {
        return (
            contrato.codigo_bus !== "" &&
            contrato.grupo !== "" &&
            contrato.empresa_id !== "" &&
            contrato.zona_labor_id !== "" &&
            contrato.fecha_ingreso !== "" &&
            contrato.cuartel_id !== "" &&
            contrato.agrupacion_id !== "" &&
            contrato.regimen_id !== "" &&
            contrato.actividad_id !== "" &&
            contrato.labor_id !== "" &&
            contrato.tipo_contrato_id !== "" &&
            contrato.oficio_id !== "" &&
            contrato.troncal_id !== "" &&
            contrato.ruta_id !== "" &&
            contrato.tipo_trabajador !== ""
        );
    };

    useEffect(() => {
        if (validacionDatosContrato()) {
            setDatosContratoValido(true);
        } else {
            setDatosContratoValido(false);
        }
    }, [contrato]);

    const setChangeFechaIngreso = e => {
        const dateString = e.target.value;
        setContrato({
            ...contrato,
            fecha_ingreso: dateString,
            fecha_termino: moment(dateString)
                .add(91, "days")
                .format("YYYY-MM-DD")
                .toString()
        });
    };

    useEffect(() => {
        if (contrato.regimen_id === 3) {
            setContrato({
                ...contrato,
                oficio_id: "3",
                cuartel_id: "SCG",
                agrupacion_id: 3,
                actividad_id: "111",
                labor_id: 61,
                tipo_contrato_id: 10
            });
        } else {
            setContrato({
                ...contrato,
                oficio_id: "",
                cuartel_id: "",
                agrupacion_id: '',
                actividad_id: "",
                labor_id: '',
                tipo_contrato_id: ''
            });
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [contrato.regimen_id]);

    /**
     * Fetching data
     */
    const url = "http://192.168.60.16/api";

    useEffect(() => {
        setLoadingRegimenes(true);
        let intentos = 0;
        function fetchRegimenes() {
            intentos++;
            Axios.get(`${url}/regimen`)
                .then(res => {
                    setRegimenes(res.data.data);
                    setLoadingRegimenes(false);
                })
                .catch(err => {
                    console.log(err);
                    if (intentos < 5) {
                        fetchRegimenes();
                    } else {
                        notification["warning"]({
                            message:
                                "Error al obtener los departamentos, vuelva a cargar la página"
                        });
                    }
                });
        }
        fetchRegimenes();
    }, []);

    useEffect(() => {
        setLoadingZonaLabores(true);
        setLoadingOficios(true);
        setLoadingActividades(true);
        setLoadingAgrupaciones(true);
        setLoadingTiposContratos(true);
        setLoadingTroncales(true);

        function fetchZonasLabores() {
            Axios.get(`/api/zona-labor/${contrato.empresa_id}`)
                .then(res => {
                    console.log(res);
                    setZonasLabor(res.data);
                    setLoadingZonaLabores(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchZonasLabores();
                });
        }
        function fetchOficios() {
            Axios.get(`${url}/oficio/${contrato.empresa_id}`)
                .then(res => {
                    setOficios(res.data.data);
                    setLoadingOficios(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchOficios();
                });
        }
        function fetchActividades() {
            Axios.get(`${url}/actividad/${contrato.empresa_id}`)
                .then(res => {
                    setActividades(res.data.data);
                    setLoadingActividades(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchActividades();
                });
        }
        function fetchAgrupaciones() {
            Axios.get(`${url}/agrupacion/${contrato.empresa_id}`)
                .then(res => {
                    setAgrupaciones(res.data.data);
                    setLoadingAgrupaciones(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchAgrupaciones();
                });
        }
        function fetchTiposContratos() {
            Axios.get(`${url}/tipo-contrato/${contrato.empresa_id}`)
                .then(res => {
                    setTiposContratos(res.data.data);
                    setLoadingTiposContratos(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchTiposContratos();
                });
        }
        function fetchTroncales() {
            Axios.get(`${url}/troncal/${contrato.empresa_id}`)
                .then(res => {
                    setTroncales(res.data.data);
                    setLoadingTroncales(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchTroncales();
                });
        }
        fetchZonasLabores();
        fetchOficios();
        fetchActividades();
        fetchAgrupaciones();
        fetchTiposContratos();
        fetchTroncales();
    }, [contrato.empresa_id]);

    useEffect(() => {
        function fetchRutas() {
            Axios.get(
                `${url}/ruta/${contrato.empresa_id}/${contrato.troncal_id}`
            )
                .then(res => {
                    setRutas(res.data.data);
                    setLoadingRutas(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchRutas();
                });
        }
        if (contrato.troncal_id !== "") {
            setLoadingRutas(true);
            fetchRutas();
        }
    }, [contrato.empresa_id, contrato.troncal_id]);

    useEffect(() => {
        function fetchCuarteles() {
            Axios.get(
                `${url}/cuartel/${contrato.empresa_id}/${contrato.zona_labor_id}`
            )
                .then(res => {
                    setCuarteles(res.data.data);
                    setLoadingCuarteles(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchCuarteles();
                });
        }
        if (contrato.zona_labor_id !== "") {
            setLoadingCuarteles(true);
            fetchCuarteles();
        }
    }, [contrato.empresa_id, contrato.zona_labor_id]);

    useEffect(() => {
        function fetchActividades() {
            Axios.get(
                `${url}/labor/${contrato.empresa_id}/${contrato.actividad_id}`
            )
                .then(res => {
                    setLabores(res.data.data);
                    setLoadingLabores(false);
                })
                .catch(err => {
                    console.log(err);
                    fetchActividades();
                });
        }
        if (contrato.actividad_id !== "") {
            setLoadingLabores(true);
            fetchActividades();
        }
    }, [contrato.empresa_id, contrato.actividad_id]);

    return (
        <Card>
            <div className="row">
                <div className="col-md-4">
                    Empresa:
                    <br />
                    <Select
                        name="empresa_id"
                        showSearch
                        placeholder="Empresa"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, empresa_id: e })
                        }
                        value={contrato.empresa_id}
                    >
                        {empresa.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {option.name}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Zona Labor:
                    <br />
                    <Select
                        name="zona_labor_id"
                        showSearch
                        placeholder="Zona Labor"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        loading={loadingZonaLabores}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, zona_labor_id: e })
                        }
                        value={contrato.zona_labor_id}
                    >
                        {zonasLabor.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>

                <div className="col-md-4">
                    Régimen
                    <br />
                    <Select
                        name="regimen_id"
                        showSearch
                        placeholder="Regimen"
                        optionFilterProp="children"
                        loading={loadingRegimenes}
                        size="small"
                        style={{ width: "100%" }}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, regimen_id: e })
                        }
                        value={contrato.regimen_id}
                    >
                        {regimenes.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Fecha Ingreso:
                    <br />
                    <input
                        type="date"
                        className="form-control"
                        value={contrato?.fecha_ingreso}
                        onChange={setChangeFechaIngreso}
                    />
                    {/* <DatePicker
                        placeholder="Fecha Ingreso"
                        value={moment(contrato.fecha_ingreso)}
                        onChange={setChangeFechaIngreso}
                        allowClear={false}
                        style={{ width: "100%" }}
                        size="small"
                    /> */}
                </div>
                <div className="col-md-4">
                    Fecha Termino:
                    <br />
                    <input
                        type="date"
                        className="form-control"
                        value={contrato?.fecha_termino}
                        onChange={e => setContrato({ ...contrato, fecha_termino: e.target.value })}
                    />
                </div>
                <div className="col-md-4">
                    Oficio:
                    <br />
                    <Select
                        name="oficio_id"
                        showSearch
                        placeholder="Oficio"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        loading={loadingOficios}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, oficio_id: e })
                        }
                        value={contrato.oficio_id}
                    >
                        {oficios.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Cuartel:
                    <br />
                    <Select
                        name="cuartel_id"
                        showSearch
                        placeholder="Cuartel"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        loading={loadingCuarteles}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, cuartel_id: e })
                        }
                        value={contrato.cuartel_id}
                    >
                        {cuarteles.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Agrupación:
                    <br />
                    <Select
                        name="agrupacion_id"
                        showSearch
                        placeholder="Agrupacion"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        loading={loadingAgrupaciones}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, agrupacion_id: e })
                        }
                        value={contrato.agrupacion_id}
                    >
                        {agrupaciones.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Actividad:
                    <br />
                    <Select
                        name="actividad_id"
                        showSearch
                        placeholder="Actividad"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        loading={loadingActividades}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, actividad_id: e })
                        }
                        value={contrato.actividad_id}
                    >
                        {actividades.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Labor:
                    <br />
                    <Select
                        name="labor_id"
                        showSearch
                        placeholder="Labor"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        loading={loadingLabores}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, labor_id: e })
                        }
                        value={contrato.labor_id}
                    >
                        {labores.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Tipo Contrato:
                    <br />
                    <Select
                        name="tipo_contrato_id"
                        showSearch
                        placeholder="Tipo Contrato"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        loading={loadingTiposContratos}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, tipo_contrato_id: e })
                        }
                        value={contrato.tipo_contrato_id}
                    >
                        {tiposContratos.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Troncal {contrato.regimen_id != 3 && '(opcional)'}:
                    <br />
                    <Select
                        name="troncal_id"
                        showSearch
                        placeholder="Troncal"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        loading={loadingTroncales}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setContrato({ ...contrato, troncal_id: e })
                        }
                        value={contrato.troncal_id}
                    >
                        {troncales.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Ruta {contrato.regimen_id != 3 && '(opcional)'}:
                    <br />
                    <Select
                        name="ruta_id"
                        showSearch
                        placeholder="Ruta"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: "100%" }}
                        loading={loadingRutas}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setContrato({ ...contrato, ruta_id: e })}
                        value={contrato.ruta_id}
                    >
                        {rutas.map(option => (
                            <Select.Option value={option.id} key={option.id}>
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                {[1, 4].includes(contrato.regimen_id) && (
                    <>
                        <div className="col-md-4">
                            Sueldo:<br />
                            <Input
                                type="number"
                                name="sueldo"
                                size="small"
                                value={contrato.sueldo}
                                onChange={handleChangeInput}
                            />
                        </div>
                    </>
                )}
                {contrato.regimen_id == 3 && (
                    <>
                        <div className="col-md-4">
                            Tipo de Ingreso:
                            <br />
                            <Select
                                name="tipo_trabajador"
                                showSearch
                                placeholder="Tipo Trabajador"
                                optionFilterProp="children"
                                size="small"
                                style={{ width: "100%" }}
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setContrato({ ...contrato, tipo_trabajador: e })
                                }
                                value={contrato.tipo_trabajador}
                            >
                                {tipos_trabajadores.map(option => (
                                    <Select.Option value={option.id} key={option.id}>
                                        {option.name}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                        <div className="col-md-4">
                            Código Bus:
                            <br />
                            <Input
                                name="codigo_bus"
                                value={contrato.codigo_bus}
                                onChange={handleChangeInput}
                                size="small"
                            />
                        </div>
                        <div className="col-md-4">
                            Grupo:
                            <br />
                            <Input
                                type="number"
                                name="grupo"
                                size="small"
                                value={contrato.grupo}
                                onChange={handleChangeInput}
                            />
                        </div>
                    </>
                )}
            </div>
        </Card>
    );
};

export default DatosContrato;
