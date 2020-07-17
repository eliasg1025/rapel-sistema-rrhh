import React, { useState } from 'react';
import { notification, Modal, message, Button, Space } from 'antd';
import { FileExcelFilled } from '@ant-design/icons';
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

    const getTrabajadores = () => {
        axios.put('/api/trabajador', filtro)
            .then(res => {
                //console.log(res);
                if (res.status < 400) {
                    notification['success']({
                        message: res.data.message,
                    });
                    const trabajadores = res.data.data.map((trabajador, i) => {
                        return {
                            key: i,
                            dni: trabajador.rut,
                            contrato_id: trabajador.contrato_id,
                            nombre: trabajador.nombre,
                            apellidos: `${trabajador.apellido_paterno} ${trabajador.apellido_materno}`,
                            zona_labor: trabajador.zona_labor_name,
                            empresa: trabajador.empresa_id == 9 ? 'RAPEL' : 'VERFRUT',
                            empresa_id: trabajador.empresa_id,
                            grupo: trabajador.grupo,
                            fecha_ingreso: moment(trabajador.fecha_inicio).format(
                                'DD/MM/YYYY'
                            ),
                        };
                    });
                    setTrabajadores(trabajadores);
                } else {
                    notification['error']({
                        message: res.data,
                    });
                    console.error(res);
                }
            })
            .catch(err => {
                console.log(err);
                notification['error']({
                    message: 'Error del servidor',
                });
            });
    };

    const getTrabajadoresObservados = () => {
        axios.put('/api/trabajador/observados', filtro)
            .then(res => {
                const trabajadores = res.data.data.map(t => {
                    return {
                        ...t,
                        key: t.contrato_id,
                        apellidos:
                            t.apellido_paterno + ' ' + t.apellido_materno,
                        empresa_name: t.empresa_id == 9 ? 'RAPEL' : 'VERFRUT'
                    };
                });
                setTrabajadoresObservados(trabajadores);
            })
            .catch(err => {
                console.log(err);
            });
    };

    const generarContrato = async (lista_contratos) => {
        setLoading(true);
        try {
            const res = await axios.post('/api/contrato/generar-pdf', {
                usuario,
                data: lista_contratos
            });
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
            const res = await axios.post('/api/contrato/generar-ficha-excel', {
                usuario,
                data: lista_contratos
            });
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

    const descargarObservados = () => {
        const data = trabajadoresObservados.map(to => {
            const contrato_activo = to.observaciones.filter(
                o => o.contrato_activo === 1
            );
            return {
                'empresa': to.empresa_name,
                'rut': to.rut,
                'apellidos': to.apellidos,
                'nombre': to.nombre,
                'fecha_ingreso': to.fecha_inicio,
                'grupo': to.grupo,
                'contrato_activo': contrato_activo[0].empresa_id == 9 ? 'RAPEL' : 'VERFRUT',
            }
        });

        axios({
            url: '/descargar/observados',
            data: {data},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/pdf' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = 'OBSERVADOS.xlsx'
                link.click()
            })
    };

    return (
        <div>
            <h4>Trabajadores</h4>
            <hr />
            <FilterForm
                filtro={filtro}
                setFiltro={setFiltro}
                getTrabajadores={getTrabajadores}
                getTrabajadoresObservados={getTrabajadoresObservados}
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
            <div>
                <Space>
                    <h5>Con observación</h5>
                    <button className="btn" onClick={() => descargarObservados()} style={{ color: "#87d068", padding: '0px', marginBottom: '15px ' }}>
                        <FileExcelFilled />
                    </button>
                </Space>
            </div>
            <br/>
            <TablaTrabajadoresObservados
                usuario={usuario}
                trabajadoresObservados={trabajadoresObservados}
                reload={reload}
                setReload={setReload}
                eliminarContrato={eliminarContrato}
            />
        </div>
    );
}

export default Trabajadores;
