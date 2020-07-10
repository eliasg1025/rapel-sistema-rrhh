import React, { useState } from 'react';
import { Button, Form, Input, Row, Col, message } from 'antd';

import Modal from "../Modal";

const AgregarTrabajador = props => {
    const {
        form, registrando, trabajadores, setTrabajadores, regimenes, oficios, actividades, agrupaciones, tiposContratos,
        cuarteles, labores, rutas, troncales
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
                    trabajadores={trabajadores}
                    setTrabajadores={setTrabajadores}
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
                />
            </Modal>
        </div>
    );
}

const FormularioTrabajador = ({
    formRegistroMasivo,
    trabajadores = [],
    setTrabajadores,
    regimenes,
    oficios,
    actividades,
    agrupaciones,
    tiposContratos,
    cuarteles,
    labores,
    rutas,
    troncales
}) => {
    const [form, setForm] = useState({
        rut: '',
    });

    const handleSubmit = e => {
        e.preventDefault();
        // eslint-disable-next-line eqeqeq
        const repetido = trabajadores.findIndex(t => t.rut == form.rut) > -1;

        if (repetido) {
            message['warn']({
                content: 'Este RUT ya esta en la lista, por favor ingrese otro',
            });
        } else {
            let _trabajadores = agregarTrabajador([...trabajadores]);
            setTrabajadores(_trabajadores);

            message['success']({
                content: 'Agregado',
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

    const agregarTrabajador = (_trabajadores) => {
        let regimen = regimenes.filter(e => e.id == formRegistroMasivo.regimen_id)[0];
        let cuartel = cuarteles.filter(e => e.id == formRegistroMasivo.cuartel_id)[0];
        let agrupacion = agrupaciones.filter(e => e.id == formRegistroMasivo.agrupacion_id)[0];
        let actividad = actividades.filter(e => e.id == formRegistroMasivo.actividad_id)[0];
        let labor = labores.filter(e => e.id == formRegistroMasivo.labor_id)[0];
        let tipo_contrato = tiposContratos.filter(e => e.id == formRegistroMasivo.tipo_contrato_id)[0];
        let oficio = oficios.filter(e => e.id == formRegistroMasivo.oficio_id)[0];
        let ruta = rutas.filter(e => e.id === formRegistroMasivo.ruta_id)[0];
        let troncal = troncales.filter(e => e.id == formRegistroMasivo.troncal_id)[0];

        _trabajadores.push({
            key: form.rut,
            rut: form.rut,
            empresa_id: formRegistroMasivo.empresa_id,
            zona_labor_id: formRegistroMasivo.zona_labor_id,
            codigo_bus: formRegistroMasivo.codigo_bus,
            grupo: formRegistroMasivo.grupo,
            fecha_ingreso: formRegistroMasivo.fecha_ingreso,
            fecha_termino: formRegistroMasivo.fecha_termino,
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
        });
        return _trabajadores
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
                    <Col span={16}>
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
                    <Col span={8}>
                        <Form.Item>
                            <Button htmlType="submit" type="primary" block>
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
