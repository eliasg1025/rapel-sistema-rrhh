import React, { useState, useEffect } from 'react';
import { Button, Form, Input, Row, Col, message } from 'antd';

import Modal from "../../../Modal";

const AgregarTrabajador = props => {
    const {
        form, registrando, newTrabajadores, dispatchNewTrabajadores, regimenes, oficios, actividades, agrupaciones, tiposContratos,
        cuarteles, labores, rutas, troncales, zonasLabor
    } = props;
    const [isVisibleModal, setIsVisibleModal] = useState(false);

    const toggleModal = () => {
        setIsVisibleModal(true);
    };

    return (
        <div>
            <Button
                type="primary"
                onClick={() => toggleModal()}
                disabled={!registrando}
            >
                Agregar trabajador
            </Button>

            <Modal
                title="Agregar Trabajador"
                isVisible={isVisibleModal}
                setIsVisible={setIsVisibleModal}
            >
                <FormularioTrabajador
                    newTrabajadores={newTrabajadores}
                    dispatchNewTrabajadores={dispatchNewTrabajadores}
                    formRegistroMasivo={form}
                    regimenes={regimenes}
                    oficios={oficios}
                    actividades={actividades}
                    agrupaciones={agrupaciones}
                    tiposContratos={tiposContratos}
                    cuarteles={cuarteles}
                    labores={labores}
                    rutas={rutas}
                    troncales={troncales}
                    zonasLabor={zonasLabor}
                />
            </Modal>
        </div>
    );
}

const FormularioTrabajador = ({
    formRegistroMasivo,
    newTrabajadores,
    dispatchNewTrabajadores,
    regimenes,
    oficios,
    actividades,
    agrupaciones,
    tiposContratos,
    cuarteles,
    labores,
    rutas,
    troncales,
    zonasLabor
}) => {
    const [form, setForm] = useState({
        rut: '',
    });

    const [valid, setValid] = useState(false);

    useEffect(() => {
        if (form.rut.length === 8) {
            setValid(true);
            return;
        }
        setValid(false);
    }, [form.rut]);

    const handleSubmit = e => {
        e.preventDefault();
        // eslint-disable-next-line eqeqeq
        if (!form.rut) {
            message['warn']({
                content: 'Campo vacío',
            });
            return;
        }

        const repetido = newTrabajadores.findIndex(t => t.rut == form.rut) > -1;

        if (repetido) {
            message['warn']({
                content: 'Este RUT ya esta en la lista, por favor ingrese otro',
            });
        } else {
            agregarTrabajador();
            /* let _trabajadores = agregarTrabajador([...trabajadores]);
            setTrabajadores(_trabajadores); */

            message['success']({
                content: `Agregado ${form.rut}`,
            });
        }
        clearForm();
    };

    const clearForm = () => {
        setForm({
            ...form,
            rut: '',
        });
    };

    /* const agregarTrabajador = (_trabajadores) => {
        let regimen = regimenes.filter(e => e.id == formRegistroMasivo.regimen_id)[0];
        let cuartel = cuarteles.filter(e => e.id == formRegistroMasivo.cuartel_id)[0];
        let agrupacion = agrupaciones.filter(e => e.id == formRegistroMasivo.agrupacion_id)[0];
        let actividad = actividades.filter(e => e.id == formRegistroMasivo.actividad_id)[0];
        let labor = labores.filter(e => e.id == formRegistroMasivo.labor_id)[0];
        let tipo_contrato = tiposContratos.filter(e => e.id == formRegistroMasivo.tipo_contrato_id)[0];
        let oficio = oficios.filter(e => e.id == formRegistroMasivo.oficio_id)[0];
        let ruta = rutas.filter(e => e.id === formRegistroMasivo.ruta_id)[0];
        let troncal = troncales.filter(e => e.id == formRegistroMasivo.troncal_id)[0];
        let zona_labor = zonasLabor.filter(e => e.id == formRegistroMasivo.zona_labor_id)[0];

        _trabajadores.push({
            key: form.rut,
            rut: form.rut,
            empresa_id: formRegistroMasivo.empresa_id,
            zona_labor_id: formRegistroMasivo.zona_labor_id,
            codigo_bus: formRegistroMasivo.codigo_bus,
            grupo: formRegistroMasivo.grupo,
            fecha_ingreso: formRegistroMasivo.fecha_ingreso,
            fecha_termino: formRegistroMasivo.fecha_termino,
            zona_labor,
            regimen,
            cuartel,
            agrupacion,
            actividad,
            labor,
            tipo_contrato,
            oficio,
            tipo_trabajador: formRegistroMasivo.tipo_trabajador,
            ruta,
            troncal,
            estado: {
                descripcion: 'SIN PROCESAR',
                color: 'default'
            }
        });
        return _trabajadores
    }; */

    const agregarTrabajador = () => {
        let regimen = regimenes.filter(e => e.id == formRegistroMasivo.regimen_id)[0];
        let cuartel = cuarteles.filter(e => e.id == formRegistroMasivo.cuartel_id)[0];
        let agrupacion = agrupaciones.filter(e => e.id == formRegistroMasivo.agrupacion_id)[0];
        let actividad = actividades.filter(e => e.id == formRegistroMasivo.actividad_id)[0];
        let labor = labores.filter(e => e.id == formRegistroMasivo.labor_id)[0];
        let tipo_contrato = tiposContratos.filter(e => e.id == formRegistroMasivo.tipo_contrato_id)[0];
        let oficio = oficios.filter(e => e.id == formRegistroMasivo.oficio_id)[0];
        let ruta = rutas.filter(e => e.id === formRegistroMasivo.ruta_id)[0];
        let troncal = troncales.filter(e => e.id == formRegistroMasivo.troncal_id)[0];
        let zona_labor = zonasLabor.filter(e => e.id == formRegistroMasivo.zona_labor_id)[0];

        dispatchNewTrabajadores({
            type: 'add',
            value: {
                trabajador: {
                    key: form.rut,
                    rut: form.rut,
                    empresa_id: formRegistroMasivo.empresa_id,
                    zona_labor_id: formRegistroMasivo.zona_labor_id,
                    codigo_bus: formRegistroMasivo.codigo_bus,
                    grupo: formRegistroMasivo.grupo,
                    fecha_ingreso: formRegistroMasivo.fecha_ingreso,
                    fecha_termino: formRegistroMasivo.fecha_termino,
                    zona_labor,
                    regimen,
                    cuartel,
                    agrupacion,
                    actividad,
                    labor,
                    tipo_contrato,
                    oficio,
                    tipo_trabajador: formRegistroMasivo.tipo_trabajador,
                    ruta,
                    troncal,
                }
            }
        })
    };

    const handleInput = e => {
        const { name, value } = e.target;
        setForm({
            ...form,
            [name]: value,
        });
    };

    return (
        <div>
            <Form onSubmitCapture={handleSubmit}>
                <Row gutter={16}>
                    <Col md={16} sm={24} xs={24}>
                        <Form.Item label="RUT:">
                            <Input
                                autoComplete="off"
                                autoFocus="on"
                                name="rut"
                                value={form.rut}
                                onChange={handleInput}
                            />
                        </Form.Item>
                    </Col>
                    <Col md={8} xs={24}>
                        <Form.Item>
                            <Button htmlType="submit" type="primary" disabled={!valid} block>
                                Agregar
                            </Button>
                        </Form.Item>
                    </Col>
                </Row>
            </Form>
        </div>
    );
};

export default AgregarTrabajador;
