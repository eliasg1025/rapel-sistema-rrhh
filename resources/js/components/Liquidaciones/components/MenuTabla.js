import React, { useState, useEffect } from 'react';
import moment from 'moment';

import {ParaPago} from "./ParaPago";
import { GenerarArchivoBanco } from './GenerarArchivoBanco';
import Modal from '../../Modal';
import { ImportacionTuRecibo } from './ImportacionTuRecibo';
import Axios from 'axios';
import Swal from 'sweetalert2';
import { ImportacionUtilidades } from './ImportacionUtilidades';

moment.locale('es');

export const MenuTabla = ({ filtro, data, reloadData, setReloadData, reloadDataAB, setReloadDataAB }) => {

    const { tipo_pago_id } = JSON.parse(sessionStorage.getItem('data'));

    const [isVisibleImportarFirmados, setIsVisibleImportarFirmados] = useState(false);
    const [isVisibleProgramarParaPago, setIsVisibleProgramarParaPago] = useState(false);
    const [isVisibleGenerarArchivoBanco, setIsVisibleGenerarArchivoBanco] = useState(false);
    const [isVisibleImportarUtilidades, setIsVisibleImportarUtilidades] = useState(false);

    const [bcp, setBcp] = useState([]);
    const [interbank, setInterbank] = useState([]);
    const [scotiabank, setScotiabank] = useState([]);
    const [bbva, setBbva] = useState([]);
    const [banbif, setBanbif] = useState([]);

    const consultarSincronizacion = () => {

        const text = parseInt(filtro.estado) === 0 ? `
            <b>Periodos: ${moment(filtro.desde).format('MMMM YYYY').toUpperCase()} - ${moment(filtro.hasta).format('MMMM YYYY').toUpperCase()}</b><br />
            Este proceso se realiza <b><u>automáticamente cada semana</u></b>, si lo desea puede realizar una sincronización manual.
        ` : `Se actualizarán ${data.length} registros`;

        Swal.fire({
            title: `Sincronización ${parseInt(filtro.empresa_id) === 9 ? 'RAPEL' : 'VERFRUT'}`,
            html: text,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    recuperarDatos();
                }
            })
    }

    const recuperarDatos = () => {
        Swal.fire({
            title: 'Recuperando datos',
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        if (parseInt(filtro.estado) === 0) {
            Axios.get(`http://192.168.60.16/api/finiquitos?empresa_id=${filtro.empresa_id}&desde=${filtro.desde}&hasta=${filtro.hasta}`)
                .then(res => {
                    const { data } = res;

                    insertarDatos(data);
                })
                .catch(err => {
                    console.log(err);
                });
        } else {
            Axios.put('/api/pagos/utilidades/sincronizar', {
                ruts: data.filter(e => e.tipo_pago === 'UTILIDAD').map(e => e.rut)
            })
                .then(res => console.log(res))
                .catch(err =>  console.error(err));

            Axios.post(`http://192.168.60.16/api/finiquitos/get/one-by-one`, {
                finiquitosId: data.filter(e => e.tipo_pago === 'LIQUIDACION').map(e => e.id)
            })
                .then(res => {
                    const { data } = res;

                    insertarDatos(data);
                })
                .catch(err => {
                    console.error(err);
                });
        }
    }

    const insertarDatos = data => {
        Swal.fire({
            title: 'Ingresando datos',
            text: 'Este proceso puede tardar unos minutos',
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        Axios.post(`/api/pagos/massive`, {
            data,
            tipo_pago_id,
            empresa_id: filtro.empresa_id
        })
            .then(res => {
                const { data } = res;

                Swal.fire({
                    title: 'Proceso completado',
                    icon: 'info',
                    text: `Completados ${data.completados} de ${data.total}`,
                })
                    .then(res => {
                        setReloadData(!reloadData);
                    });
            })
            .catch(err => {
                console.log(err);
            });
    }

    const cerrarFecha = fecha_pago => {
        Swal.fire({
            title: '¿Desea cerrar la fecha?',
            html: `Los registros con FECHA DE PAGO <b>${fecha_pago}</b> pasarán al estado <b><u>PAGADO</u></b>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        })
            .then(res => {
                if (res.isConfirmed) {
                    Swal.fire({
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    Axios.put('/api/pagos/marcar-pagado-masivo', {
                        //data: d.map(e => e.id),
                        empresa_id: filtro.empresa_id,
                        fecha_pago: filtro.desde,
                        tipo_pago_id: tipo_pago_id
                    })
                        .then(res => {
                            const { message } = res.data;

                            Swal.fire(message, '', 'success')
                                .then(res => {
                                    setReloadData(!reloadData);
                                });
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire('Error al actualizar el estado', '', 'error');
                        });
                }
            });
    }

    useEffect(() => {
        if (parseInt(filtro.estado) === 2) {
            setBcp(data.filter(liq => liq.banco === 'BANCO DE CREDITO' && liq.monto !== 0));
            setInterbank(data.filter(liq => liq.banco === 'INTERBANK' && liq.monto !== 0));
            setBbva(data.filter(liq => liq.banco === 'BBVA BANCO CONTINENTAL' && liq.monto !== 0));
            setBanbif(data.filter(liq => liq.banco === 'INTERAMERICANO FINANZAS' && liq.monto !== 0));
            setScotiabank(data.filter(liq => liq.banco === 'SCOTIABANK PERU' && liq.monto !== 0));
        }
    }, [data]);

    return (
        <>
            <div style={{ marginBottom: 16 }}>
                <div className="btn-group">
                    <button className="btn btn-primary" onClick={consultarSincronizacion}>
                        <i className="fas fa-sync" />&nbsp;Sincronizar DB
                    </button>
                    <button className="btn btn-primary" disabled={parseInt(filtro.estado) !== 0} onClick={() => setIsVisibleImportarFirmados(true)}>
                        <i className="fas fa-file-upload" />&nbsp;Importar Firmados
                    </button>
                    <button className="btn btn-primary" disabled={parseInt(filtro.estado) !== 1} onClick={() => setIsVisibleProgramarParaPago(true)}>
                        <i className="far fa-clock" />&nbsp;Programar para Pago
                    </button>
                    <button className="btn btn-primary" disabled={parseInt(filtro.estado) !== 2} onClick={() => setIsVisibleGenerarArchivoBanco(true)}>
                        <i className="fas fa-file-invoice" />&nbsp;Generar archivos banco
                    </button>
                    {parseInt(filtro.estado) === 0 && (
                        <button className="btn btn-success" disabled={parseInt(filtro.estado) !== 0} onClick={() => setIsVisibleImportarUtilidades(true)}>
                            <i className="fas fa-file-upload" />&nbsp;Importar Utilidades
                        </button>
                    )}
                </div>
                <div style={{ display: 'flex', flexDirection: 'row-reverse' }}>
                    {parseInt(filtro.estado) === 2 && (
                        <button className="btn btn-danger" disabled={(filtro.desde !== filtro.hasta) && data.length === 0} onClick={() => cerrarFecha(filtro.desde)}>
                            <i className="fas fa-save"></i>&nbsp;Cerrar Fecha
                        </button>
                    )}
                </div>
            </div>

            <Modal
                isVisible={isVisibleImportarFirmados}
                setIsVisible={setIsVisibleImportarFirmados}
                title="Importar Firmados"
            >
                <ImportacionTuRecibo
                    reloadData={reloadData}
                    setReloadData={setReloadData}
                    setIsVisibleParent={setIsVisibleImportarFirmados}
                />
            </Modal>

            <Modal
                title="Programar para pago"
                isVisible={isVisibleProgramarParaPago}
                setIsVisible={setIsVisibleProgramarParaPago}
            >
                <ParaPago
                    data={data}
                    reloadData={reloadData}
                    setReloadData={setReloadData}
                    setIsVisibleParent={setIsVisibleProgramarParaPago}
                />
            </Modal>

            <Modal
                title="Generar Archivos Banco"
                isVisible={isVisibleGenerarArchivoBanco}
                setIsVisible={setIsVisibleGenerarArchivoBanco}
            >
                <GenerarArchivoBanco
                    data={{
                        bcp,
                        bbva,
                        interbank,
                        scotiabank,
                        banbif
                    }}
                    d={data}
                    filtro={filtro}
                    reloadData={reloadData}
                    setReloadData={setReloadData}
                    reloadDataAB={reloadDataAB}
                    setReloadDataAB={setReloadDataAB}
                    setIsVisibleParent={setIsVisibleGenerarArchivoBanco}
                />
            </Modal>

            <Modal
                title="Importar Utilidades"
                isVisible={isVisibleImportarUtilidades}
                setIsVisible={setIsVisibleImportarUtilidades}
            >
                <ImportacionUtilidades
                    reloadData={reloadData}
                    setReloadData={setReloadData}
                    setIsVisibleParent={setIsVisibleImportarUtilidades}
                />
            </Modal>
        </>
    );
}
