import React, { useState, useEffect } from 'react';
import TextLoop from 'react-text-loop';
import {Alert, Collapse, Button, notification } from 'antd';
import { UserAddOutlined } from '@ant-design/icons';
import moment from 'moment';

import BusquedaTrabajador from "../components/RegistroIndividual/BusquedaTrabajador";
import DatosTrabajador from "../components/RegistroIndividual/DatosTrabajador";
import DatosContrato from "../components/RegistroIndividual/DatosContrato";
import Axios from 'axios';

export const RegistroIndividual = () => {

    const { usuario, trabajador: _trabajador, contrato: _contrato } = JSON.parse(sessionStorage.getItem("data"));

    useEffect(() => {
        if (_contrato && _trabajador) {

            setTrabajador({
                ...trabajador,
                ..._trabajador,
                fecha_nacimiento: moment(_trabajador.fecha_nacimiento).format('DD/MM/YYYY')
            });

            setContrato({
                ...contrato,
                ..._contrato,
            });
            setContratoId(_contrato.id);
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    const [contrato, setContrato] = useState({
        empresa_id: 9,
        zona_labor_id: '',
        grupo: '',
        regimen_id: '',
        fecha_ingreso: moment().add(1, 'days').format('YYYY-MM-DD').toString(),
        fecha_termino: moment().add(92, 'days').format('YYYY-MM-DD').toString(),
        oficio_id: '',
        cuartel_id: '',
        agrupacion_id: '',
        actividad_id: '',
        labor_id: '',
        tipo_contrato_id: '',
        tipo_trabajador: '',
        ruta_id: '',
        troncal_id: '',
    });
    const [trabajador, setTrabajador] = useState({
        rut: '',
        departamento_id: '20',
        provincia_id: '2001',
        distrito_id: '',
        nombre: '',
        apellido_paterno: '',
        apellido_materno: '',
        direccion: '',
        telefono: '',
        fecha_nacimiento: '',
        nombre_zona: '',
        nombre_via: '',
        sexo: '',
        nacionalidad_id: 'PE',
        tipo_via_id: '',
        tipo_zona_id: '',
        estado_civil_id: '',
        empresa_id: 9
    });
    const [contratoId, setContratoId] = useState(0);

    const [departamentos, setDepartamentos] = useState([]);
    const [provincias, setProvincias] = useState([]);
    const [distritos, setDistritos] = useState([]);
    const [nacionalidades, setNacionalidades] = useState([]);
    const [tiposZonas, setTiposZonas] = useState([]);
    const [tiposVias, setTiposVias] = useState([]);

    const [zonasLabor, setZonasLabor] = useState([]);
    const [regimenes, setRegimenes] = useState([]);
    const [oficios, setOficios] = useState([]);
    const [actividades, setActividades] = useState([]);
    const [agrupaciones, setAgrupaciones] = useState([]);
    const [tiposContratos, setTiposContratos] = useState([]);
    const [cuarteles, setCuarteles] = useState([]);
    const [labores, setLabores] = useState([]);
    const [rutas, setRutas] = useState([]);
    const [troncales, setTroncales] = useState([]);

    const [alertas, setAlertas] = useState([]);
    const [contratoActivo, setContratoActivo] = useState([]);

    const [loading, setLoading] = useState(false);
    // eslint-disable-next-line no-unused-vars

    const [datosContratoValido, setDatosContratoValido] = useState(false);
    const [datosTrabajadorValido, setDatosTrabajadorValido] = useState(false);

    const clearData = () => {
        let _trabajador = { ...trabajador };
        console.log('antes', _trabajador.fecha_nacimiento);
        //_trabajador.fecha_nacimiento = moment(_trabajador.fecha_nacimiento, 'DD/MM/YYYY').format('YYYY-MM-DD').toString();
        console.log('despues', _trabajador.fecha_nacimiento);
        for (const key in _trabajador) {
            if (_trabajador[key] == null) {
                _trabajador[key] = '';
            }
        }

        let _contrato = { ...contrato };
        for (const key in _contrato) {
            if (_contrato[key] == null) {
                _contrato[key] = '';
            }
        }

        return {
            trabajador: _trabajador,
            contrato: _contrato,
        };
    };

    const clearFormTrabajador = () => {
        setTrabajador({
            ...trabajador,
            departamento_id: '20',
            provincia_id: '2001',
            distrito_id: '',
            nombre: '',
            apellido_paterno: '',
            apellido_materno: '',
            direccion: '',
            telefono: '',
            fecha_nacimiento: moment(),
            nombre_zona: '',
            nombre_via: '',
            sexo: '',
            nacionalidad_id: 'PE',
            tipo_via_id: '',
            tipo_zona_id: '',
            estado_civil_id: 'S',
            empresa_id: 9
        });
        setAlertas([]);
        setContratoActivo([]);
    }

    const prepareDataContratos = contrato => {
        const regimen = regimenes.filter(e => e.id == contrato.regimen_id)[0];
        const cuartel = cuarteles.filter(e => e.id == contrato.cuartel_id)[0];
        const agrupacion = agrupaciones.filter(
            e => e.id == contrato.agrupacion_id
        )[0];
        const actividad = actividades.filter(
            e => e.id == contrato.actividad_id
        )[0];
        const labor = labores.filter(e => e.id == contrato.labor_id)[0];
        const tipo_contrato = tiposContratos.filter(
            e => e.id == contrato.tipo_contrato_id
        )[0];
        const oficio = oficios.filter(e => e.id == contrato.oficio_id)[0];
        const troncal = troncales.filter(e => e.id == contrato.troncal_id)[0];
        const ruta = rutas.filter(e => e.id == contrato.ruta_id)[0];
        const zona_labor = zonasLabor.filter(e => e.id == contrato.zona_labor_id)[0];

        return {
            ...contrato,
            zona_labor,
            regimen,
            cuartel,
            agrupacion,
            actividad,
            labor,
            tipo_contrato,
            oficio,
            troncal,
            ruta
        };
    };

    const handleSubmit = () => {
        if (datosContratoValido && datosTrabajadorValido) {
            let data = clearData();
            const contrato = prepareDataContratos(data.contrato);
            data = {
                ...data,
                contrato,
                rut: data.trabajador.rut,
                contrato_activo: contratoActivo,
                alertas,
            };
            console.log('Datos del trabajador y el contrato: ', data);
            registroContrato(data);
        } else {
            notification['warning']({
                message: 'Verifique los datos del trabajador'
            });
        }
    };

    const registroContrato = async data => {
        Axios.post(`/api/contrato/registro`, data)
            .then(res => {
               if (res.status < 300) {
                   const accion = contratoId !== 0 ? 'actualizado' : 'creado';
                   console.log(res);

                   notification['success']({
                       message: `Contrato para trabajador ${res.data.rut} ${accion} correctamente`,
                   });

                   if (res.data.observado) {
                       notification['warning']({
                           message: `El trabajador fue grabado con una observación`,
                       });
                   }

                   clearFormTrabajador();
               } else {
                    notification['error']({
                        message: res.response.error,
                    });
                }
            })
            .catch(err => {
                console.log(err.response)
                notification['error']({
                    message: err.response.data.error
                });
            });
    };

    const mostrarObservaciones = data => {
        if (data.alertas.length > 0) {
            notification['warning']({
                message: 'Este trabajador tiene alertas'
            });
        }

        if (data.contrato_activo.length > 0) {
            let empresa_contrato_activo;
            switch (data.contrato_activo[0].empresa_id) {
                case '9':
                    empresa_contrato_activo = 'RAPEL';
                    break;
                case '14':
                    empresa_contrato_activo = 'VERFRUT';
                    break;
                default:
                    empresa_contrato_activo = 'OTRO';
                    break;
            }
            notification['warning']({
                message: `Este trabajador tiene contrato activo en ${empresa_contrato_activo}`
            });
        }
    };

    return (
        <div className="consulta-trabajadores">
            <h3>Registro / Consulta trabajador</h3>
            <hr />
            <Alert
                banner
                type="info"
                message={
                    <TextLoop mask interval={5000}>
                        <div>
                            Puede buscar trabajadores ya registrados en el
                            sistema principal
                        </div>
                        <div>Si no encuentra uno, puede agregarlo</div>
                    </TextLoop>
                }
            />
            <Collapse defaultActiveKey={["1", "2"]}>
                <Collapse.Panel header="Datos Contrato" key="1">
                    <DatosContrato
                        contrato={contrato}
                        setDatosContratoValido={setDatosContratoValido}
                        setContrato={setContrato}
                        regimenes={regimenes}
                        oficios={oficios}
                        actividades={actividades}
                        agrupaciones={agrupaciones}
                        tiposContratos={tiposContratos}
                        cuarteles={cuarteles}
                        labores={labores}
                        zonasLabor={zonasLabor}
                        rutas={rutas}
                        troncales={troncales}
                        setRegimenes={setRegimenes}
                        setOficios={setOficios}
                        setActividades={setActividades}
                        setAgrupaciones={setAgrupaciones}
                        setTiposContratos={setTiposContratos}
                        setCuarteles={setCuarteles}
                        setLabores={setLabores}
                        setZonasLabor={setZonasLabor}
                        setRutas={setRutas}
                        setTroncales={setTroncales}
                    />
                </Collapse.Panel>
                <Collapse.Panel header="Datos Trabajador" key="2">
                    <BusquedaTrabajador
                        trabajador={trabajador}
                        loading={loading}
                        clearFormTrabajador={clearFormTrabajador}
                        setTrabajador={setTrabajador}
                        setLoading={setLoading}
                        setAlertas={setAlertas}
                        setContratoActivo={setContratoActivo}
                        mostrarObservaciones={mostrarObservaciones}
                    />
                    <DatosTrabajador
                        trabajador={trabajador}
                        setDatosTrabajadorValido={setDatosTrabajadorValido}
                        contrato={contrato}
                        setTrabajador={setTrabajador}
                        departamentos={departamentos}
                        provincias={provincias}
                        distritos={distritos}
                        nacionalidades={nacionalidades}
                        tiposZonas={tiposZonas}
                        tiposVias={tiposVias}
                        setDepartamentos={setDepartamentos}
                        setProvincias={setProvincias}
                        setDistritos={setDistritos}
                        setNacionalidades={setNacionalidades}
                        setTiposZonas={setTiposZonas}
                        setTiposVias={setTiposVias}
                    />
                </Collapse.Panel>
            </Collapse>
            <br />
            <Button
                type="primary"
                htmlType="submit"
                size="large"
                onClick={handleSubmit}
                block
                disabled={!(datosContratoValido  && datosTrabajadorValido)}
            >
                {contratoId !== 0 ? 'Editar Registro' : 'Guardar Registro'}{' '}
                <UserAddOutlined />
            </Button>
        </div>
    );
}
