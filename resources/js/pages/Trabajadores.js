import React, { useState } from 'react';
import { notification, Modal, message } from 'antd';
import moment from 'moment';

import FilterForm from "../components/Trabajadores/FilterForm";
import TablaTrabajadores from "../components/Trabajadores/TablaTrabajadores";
import TablaTrabajadoresObservados from "../components/Trabajadores/TablaTrabajadoresObservados";

const Trabajadores = props => {
    const usuario = props.data.usuario;
    const [filtro, setFiltro] = useState({
        desde: moment().add(1, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().add(1, 'days').format('YYYY-MM-DD').toString(),
        empresa_id: 9, //TODO: Cambiar si es que la empresa es diferente
        dni: '',
        nombre: '',
        grupo: '',
        signal: {},
    });
    const [trabajadores, setTrabajadores] = useState([]);
    const [trabajadoresObservados, setTrabajadoresObservados] = useState([]);
    const [loading, setLoading] = useState(false);
    const [reload, setReload] = useState(false);

    const generarContrato = async (lista_contratos) => {
        setLoading(true);
        try {
            const res = await axios.post('/api/contrato/generar-pdf', lista_contratos);
            console.log('Generar contrato response: ', res);
            if (res.status < 400) {
                notification['success']({
                    message: `Se han procesando los contratos`
                });
            } else {
                notification['error']({
                    message: `Error al generar los contratos`
                });
            }
        } catch (err) {
            console.log(err);
        } finally {
            setLoading(false);
        }
    };

    const generarFicha = async (lista_contratos) => {
        setLoading(true);
        try {
            const res = await axios.post('/api/contrato/generar-ficha-excel', lista_contratos);
            console.log('Generar contrato response: ', res);
            if (res.status < 400) {
                notification['success']({
                    message: `Se han procesando los contratos`
                });
            } else {
                notification['error']({
                    message: `Error al generar los contratos`
                });
            }
        } catch (err) {
            console.log(err);
        } finally {
            setLoading(false);
        }
    };

    const eliminarContrato = contrato_id => {
        Modal.confirm({
            title: 'Confirmación',
            content: '¿Desea eliminar el contrato de este trabajador?',
            okText: 'Eliminar',
            okType: 'danger',
            onOk() {
                deleteContrato(contrato_id);
            }
        });
    };

    const deleteContrato = contrato_id => {
        axios.delete(`/api/contrato/${contrato_id}`)
            .then(res => {
                const state = res.status < 300 ? 'success' : 'error';

                message[state]({
                    content: res.data.message
                });

                setReload(!reload);
            })
            .catch(err => {
                console.log(err);
            })
    };

    return (
        <div>
            <h4>Trabajadores</h4>
            <hr />
            <FilterForm
                filtro={filtro}
                setFiltro={setFiltro}
                setTrabajadores={setTrabajadores}
                reload={reload}
            />
            <br />
            <TablaTrabajadores
                loading={loading}
                trabajadores={trabajadores}
                generarContrato={generarContrato}
                generarFicha={generarFicha}
                eliminarContrato={eliminarContrato}
            />
            <br/>
            <hr />
            <br/>
            <h5>Con observación</h5>
            <br/>
            <TablaTrabajadoresObservados
                usuario={usuario}
                trabajadoresObservados={trabajadoresObservados}
                setTrabajadoresObservados={setTrabajadoresObservados}
                reload={reload}
                setReload={setReload}
            />
        </div>
    );
}

export default Trabajadores;
