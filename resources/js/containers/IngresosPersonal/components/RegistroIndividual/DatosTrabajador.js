import React, { useEffect, useState } from 'react';
import { Card, Form, Row, Col, Input, Select, DatePicker, notification } from 'antd'
import moment from 'moment';

import { sexo, estado_civil } from '../../../../data/default.json';
import Axios from 'axios';

const DatosTrabajador = props => {
    const {
        setDatosTrabajadorValido,
        trabajador, setTrabajador, departamentos, provincias,  distritos, nacionalidades, tiposZonas, tiposVias,
        setDepartamentos, setProvincias, setDistritos, setNacionalidades, setTiposVias, setTiposZonas, contrato
    } = props;
    const { Item } = Form;

    const [edad, setEdad] = useState(0);
    const [validacionEdad, setValidacionEdad] = useState({
        validateStatus: "error",
        help: "La edad debe estar en 18 y 55 años"
    });

    useEffect(() => {
        const edad = moment().diff(moment(trabajador.fecha_nacimiento, 'YYYY-MM-DD'), 'years');
        setEdad(edad);

        if (edad <= 18 || edad >= 55) {
            setValidacionEdad({
                validateStatus: "error",
                help: "La edad debe estar en 18 y 55 años"
            });
            return;
        }

        setValidacionEdad({
            validateStatus: "success",
            help: ""
        });
    }, [trabajador.fecha_nacimiento]);

    const validacionDatosTrabajador = () => {
        return trabajador.apellido_materno !== '' &&
            trabajador.apellido_paterno !== '' &&
            trabajador.nombre !== '' &&
            trabajador.estado_civil_id !== '' &&
            trabajador.sexo !== '' &&
            trabajador.nacionalidad_id !== '' &&
            trabajador.distrito_id !== '' &&
            trabajador.direccion !== ''
    };

    useEffect(() => {
        if (validacionDatosTrabajador()) {
            setDatosTrabajadorValido(true);
            return;
        }
        setDatosTrabajadorValido(false);
    }, [trabajador]);

    /**
     * Fetching data
     */
    const url = 'http://192.168.60.16/api';

    useEffect(() => {
        let intentos = 0;
        function fetchDepartamentos() {
            intentos++;
            Axios.get(`${url}/departamento`)
                .then(res => {
                    setDepartamentos(res.data.data);
                })
                .catch(err => {
                    console.log(err.response);
                    if (intentos < 3) {
                        fetchDepartamentos();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener los departamentos, vuelva a cargar la página',
                        });
                    }
                });
        }
        fetchDepartamentos();
    }, []);

    useEffect(() => {
        let intentos = 0;
        function fetchProvincias() {
            intentos++;
            Axios.get(`${url}/departamento/${trabajador.departamento_id}/provincias`)
                .then(res => {
                    //console.log(res);
                    setProvincias(res.data.data.provincias);
                })
                .catch(err => {
                    console.log(err.response);
                    if (intentos < 3) {
                        fetchProvincias();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las provincias, vuelva a cargar la página',
                        });
                    }
                });
        }
        if (trabajador.departamento_id !== '') {
            fetchProvincias();
        }
    }, [trabajador.departamento_id]);

    useEffect(() => {
        let intentos = 0;
        function fetchDistritos() {
            Axios.get(`${url}/provincia/${trabajador.provincia_id}/distritos`)
                .then(res => {
                    //console.log(res);
                    setDistritos(res.data.data.distritos);
                })
                .catch(err => {
                    console.log(err.response);
                    if ( intentos < 3 ) {
                        fetchDistritos();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las distritos, vuelva a cargar la página',
                        });
                    }
                });
        }
        if (trabajador.provincia_id !== '') {
            fetchDistritos();
        }
    }, [trabajador.provincia_id]);

    useEffect(() => {
        let intentos = 0;
        let intentos1 = 0;
        let intentos2 = 0;

        function fetchNacionalidades() {
            intentos++;
            Axios.get(`${url}/nacionalidad/${contrato.empresa_id}`)
                .then(res => setNacionalidades(res.data.data))
                .catch(err => {
                    console.log(err.response);
                    if (intentos < 3) {
                        fetchNacionalidades();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las nacionalidades, vuelva a cargar la página',
                        });
                    }
                });
        }
        function fetchTiposZonas() {
            intentos1++;
            Axios.get(`${url}/tipo-zona/${contrato.empresa_id}`)
                .then(res => setTiposZonas(res.data.data))
                .catch(err => {
                    console.log(err.response);
                    if (intentos1 < 3) {
                        fetchTiposZonas();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las tipos zonas, vuelva a cargar la página',
                        });
                    }
                });
        }
        function fetchTiposVias() {
            intentos2++;
            Axios.get(`${url}/tipo-via/${contrato.empresa_id}`)
                .then(res => setTiposVias(res.data.data))
                .catch(err => {
                    console.log(err.response);
                    if (intentos2 < 3) {
                        fetchTiposVias();
                    } else {
                        notification['warning']({
                            message: 'Error al obtener las tipos vias, vuelva a cargar la página',
                        });
                    }
                });
        }

        fetchNacionalidades();
        fetchTiposZonas();
        fetchTiposVias();

    }, [contrato.empresa_id]);

    /**
     * Functions
     */

    const handleChangeInput = e => {
        setTrabajador({
            ...trabajador,
            [e.target.name]: e.target.value
        });
    };

    const handleChangeDepartamento = e => {
        setTrabajador({
            ...trabajador,
            departamento_id: e,
            provincia_id: '',
            distrito_id: ''
        });
    };

    const handleChangeProvincia = e => {
        setTrabajador({
            ...trabajador,
            provincia_id: e
        });
    };

    const handleChangeDistrito = e => {
        setTrabajador({
            ...trabajador,
            distrito_id: e
        });
        console.log(e);
    };

    const layout = {
        labelCol: {
            span: 6
        }
    };

    return (
        <Card>
            <div className="row">
                <div className="col-md-4">
                    Nombre:<br />
                    <input
                        className="form-control"
                        autoComplete="off"
                        name="nombre"
                        value={trabajador.nombre}
                        onChange={e => setTrabajador({ ...trabajador, nombre: e.target.value })}
                    />
                </div>
                <div className="col-md-4">
                    Apellido Paterno:<br />
                    <input
                        className="form-control"
                        autoComplete="off"
                        name="apellido_paterno"
                        value={trabajador.apellido_paterno}
                        onChange={e => setTrabajador({ ...trabajador, apellido_paterno: e.target.value })}
                    />
                </div>
                <div className="col-md-4">
                    Apellido Materno:<br />
                    <input
                        className="form-control"
                        autoComplete="off"
                        name="apellido_materno"
                        value={trabajador.apellido_materno}
                        onChange={e => setTrabajador({ ...trabajador, apellido_materno: e.target.value })}
                    />
                </div>
                <div className="col-md-4">
                    Fecha Nacimiento:<br />
                    <input
                        type="date"
                        className="form-control"
                        value={trabajador?.fecha_nacimiento}
                        onChange={e => setTrabajador({ ...trabajador, fecha_nacimiento: e.target.value })}
                    />
                    <small>
                        {trabajador.fecha_nacimiento !== ''
                            ? `  ${edad} años`
                            : ''}
                    </small>
                </div>
                <div className="col-md-4">
                    Sexo:<br />
                    <Select
                        name="sexo"
                        placeholder="Sexo"
                        size="small"
                        style={{ width: '100%' }}
                        onChange={e => {
                            setTrabajador({ ...trabajador, sexo: e });
                        }}
                        value={trabajador.sexo}
                        required={true}
                    >
                        {sexo.map(option => (
                            <Select.Option
                                key={option.id}
                                value={option.id}
                            >
                                {option.name}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Estado Civil:<br />
                    <Select
                        name="estado_civil_id"
                        placeholder="Estado Civil"
                        size="small"
                        style={{ width: '100%' }}
                        onChange={e => {
                            setTrabajador({ ...trabajador, estado_civil_id: e });
                        }}
                        value={trabajador.estado_civil_id}

                    >
                        {estado_civil.map(option => (
                            <Select.Option
                                key={option.id}
                                value={option.id}
                            >
                                {option.name}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Nacionalidad:<br />
                    <Select
                        name="nacionalidad_id"
                        showSearch
                        placeholder="Nacionalidad"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: '100%' }}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => {
                            setTrabajador({ ...trabajador, nacionalidad_id: e });
                        }}
                        value={trabajador.nacionalidad_id}

                    >
                        {nacionalidades.map(option => (
                            <Select.Option
                                value={option.id}
                                key={option.id}
                            >
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Telefono:<br />
                    <input
                        className="form-control"
                        autoComplete="off"
                        name="telefono"
                        value={trabajador.telefono}
                        onChange={handleChangeInput}
                        size="small"
                    />
                </div>
                <div className="col-md-4">
                    Email:<br />
                    <input
                        className="form-control"
                        autoComplete="off"
                        name="email"
                        value={trabajador.email}
                        onChange={handleChangeInput}
                    />
                </div>
                <div className="col-md-4">
                    Departamento:<br />
                    <Select
                        name="departamento_id"
                        showSearch
                        placeholder="Departamento"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: '100%' }}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={handleChangeDepartamento}
                        value={trabajador.departamento_id}

                    >
                        {departamentos.map(option => (
                            <Select.Option
                                value={option.id}
                                key={option.id}
                            >
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Provincia:<br />
                    <Select
                        name="provincia_id"
                        showSearch
                        placeholder="Provincia"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: '100%' }}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={handleChangeProvincia}
                        value={trabajador.provincia_id}

                    >
                        {provincias.map(option => (
                            <Select.Option
                                value={option.id}
                                key={option.id}
                            >
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Distrito:<br />
                    <Select
                        name="distrito_id"
                        showSearch
                        placeholder="Distrito"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: '100%' }}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={handleChangeDistrito}
                        value={trabajador.distrito_id}

                    >
                        {distritos.map(option => (
                            <Select.Option
                                value={option.id}
                                key={option.id}
                            >
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Tipo Zona:<br />
                    <Select
                        name="tipo_zonas_id"
                        showSearch
                        placeholder="Tipo Zona"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: '100%' }}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setTrabajador({ ...trabajador, tipo_zona_id: e })
                        }
                        value={trabajador.tipo_zona_id}
                    >
                        {tiposZonas.map(option => (
                            <Select.Option
                                value={option.id}
                                key={option.id}
                            >
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-8">
                    Nombre Zona:<br />
                    <input
                        className="form-control"
                        autoComplete="off"
                        name="nombre_zona"
                        value={trabajador.nombre_zona}
                        onChange={handleChangeInput}
                    />
                </div>
                <div className="col-md-4">
                    Tipo Vía:<br />
                    <Select
                        name="tipo_via_id"
                        showSearch
                        placeholder="Tipo Via"
                        optionFilterProp="children"
                        size="small"
                        style={{ width: '100%' }}
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setTrabajador({ ...trabajador, tipo_via_id: e })
                        }
                        value={trabajador.tipo_via_id}
                    >
                        {tiposVias.map(option => (
                            <Select.Option
                                value={option.id}
                                key={option.id}
                            >
                                {`${option.id} - ${option.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-8">
                    Nombre Vía:<br />
                    <input
                        className="form-control"
                        autoComplete="off"
                        name="nombre_via"
                        value={trabajador.nombre_via}
                        onChange={handleChangeInput}
                    />
                </div>
                <div className="col-md-12">
                    Dirección:<br />
                    <input
                        className="form-control"
                        autoComplete="off"
                        name="direccion"
                        value={trabajador.direccion}
                        onChange={e => setTrabajador({ ...trabajador, direccion: e.target.value })}
                    />
                </div>
            </div>
        </Card>
    );
};

export default DatosTrabajador;
