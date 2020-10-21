import { message, notification } from 'antd';
import Axios from 'axios';
import React, { useEffect, useState } from 'react';
import Swal from 'sweetalert2';

import { DatosInforme, DatosDescansos, TablaDescansos, TablaInformes } from '../components';

export const RegistrarInformes = () => {

    const { usuario, editar } = JSON.parse(sessionStorage.getItem('data'));

    const [informes, setInformes] = useState([]);
    const [informe, setInforme] = useState(null);
    const [registros, setRegistros] = useState([]);
    const [descanso, setDescanso] = useState(null);
    const [reloadData, setReloadData] = useState(false);

    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        if (editar === 0) {
            Axios.get(`/api/informes-descansos?usuarioId=${usuario.id}`)
                .then(res => {
                    console.log(res);
                    setInformes(res.data.map(item => ({ key: item.id, ...item })));
                    message['success']({
                        content: `Se encontraron ${res.data.length} registros`
                    });
                })
                .catch(err => {
                    console.error(err);
                })
        } else {
            Axios.get(`/api/informes-descansos/${editar}`)
                .then(res => {
                    console.log(res);
                    setInforme(res.data);
                    setRegistros(res.data.registros.map(item => ({ key: item.id, ...item })));
                    message['success']({
                        content: `Se encontraron ${res.data.registros.length} registros`
                    });
                })
                .catch(err => {
                    console.error(err);
                });
        }
    }, [reloadData]);

    const deleteRow = (id) => {
        console.log('delete ', id);

        Swal.fire({
            title: '¿Deseas eliminar este registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrarlo',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.delete(`/api/registros-descansos/${id}`, )
                        .then(res => {
                            console.log(res);
                            setReloadData(!reloadData);
                            notification['success']({
                                message: res.data.message
                            });
                        })
                        .catch(err => {
                            console.error(err);
                        });
                }
            })

    }

    const editRow = (record) => {
        setDescanso(record);
        setIsVisible(true);
        console.log('edit', descanso);
    }

    const terminarInforme = () => {
        Swal.fire({
            title: '¿Deseas marca como TERMINADO este informe?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar'
        })
            .then(result => {
                if (result.value) {
                    Axios.put(`/api/informes-descansos/${informe.id}`, {
                        estado: 1
                    })
                        .then(res => {
                            console.log(res);
                            setReloadData(!reloadData);
                            notification['success']({
                                message: res.data.message
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        })
                        .catch(err => {
                            console.error(err);
                            notification['error']({
                                message: err.response.data.message
                            });
                        });
                }
            })
    }

    return (
        <>
            {editar === 0 ? (
                <>
                    <h4>Informes Bienestar Social</h4>
                    <br />
                    <DatosInforme
                        reloadData={reloadData}
                        setReloadData={setReloadData}
                    />
                    <br />
                    <TablaInformes
                        informes={informes}
                    />
                </>
            ) : (
                <>
                    <button className="btn btn-light pb-2" onClick={() => location.replace('/descansos-medicos')}>
                        <i className="fas fa-backward"></i> Atrás
                    </button>
                    <h4>
                        Registrar: {informe?.informe || ''}{" "} {informe?.estado === 0 && <button className="btn btn-danger btn-sm" onClick={() => terminarInforme()}>Terminar Informe</button>}
                    </h4>
                    <DatosDescansos
                        informe={informe}
                        reloadData={reloadData}
                        setReloadData={setReloadData}
                        descanso={descanso}
                        setDescanso={setDescanso}
                        isVisible={isVisible}
                        setIsVisible={setIsVisible}
                    />
                    <br />
                    <TablaDescansos
                        informe={informe}
                        registros={registros}
                        deleteRow={deleteRow}
                        editRow={editRow}
                    />
                </>
            )}
        </>
    );
}
