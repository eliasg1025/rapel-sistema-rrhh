import React, { useEffect, useState } from 'react';
import { Card, notification, Select } from 'antd';

import Modal from '../../Modal';
import Axios from 'axios';

export const DatosDescansos = ({
    informe,
    reloadData,
    setReloadData,
    isVisible,
    setIsVisible,
    descanso,
    setDescanso
}) => {

    const { usuario, editar } = JSON.parse(sessionStorage.getItem('data'));

    const [zonasLabores, setZonasLabores] = useState([]);
    const [tiposLicencias, setTiposLicencias] = useState([]);

    useEffect(() => {
        if (informe) {
            Axios.get(`/api/zona-labor/${informe.empresa_id}`)
                .then(res => {
                    //console.log(res);
                    setZonasLabores(res.data);
                })
                .catch(err => {
                    console.error(err);
                });

            Axios.get(`/api/tipo-licencia/${informe.empresa_id}`)
                .then(res => {
                    //console.log(res);
                    setTiposLicencias(res.data);
                })
                .catch(err => {
                    console.error(err);
                });
        }
    }, [informe]);

    return (
        <>
            <br />
            <h5>Datos Informe</h5>
            <Card>
                <form>
                    <div className="row">
                        <div className="col-md-4">
                            Empresa:<br />
                            <input
                                className="form-control"
                                value={informe?.empresa || ''}
                                readOnly={true}
                            />
                        </div>
                        <div className="col-md-4">
                            Fecha Informe:<br />
                            <input
                                className="form-control"
                                value={informe?.fecha_inicio || ''}
                                readOnly={true}
                            />
                        </div>
                        <div className="col-md-4">
                            Generado por:<br />
                            <input
                                className="form-control"
                                value={informe?.trabajador || ''}
                                readOnly={true}
                            />
                        </div>
                    </div>
                </form>
            </Card>
            <br />
            {informe?.estado === 0 && (
                <button className="btn btn-primary" onClick={() => {
                    setDescanso(null)
                    setIsVisible(true)
                }}>
                    <i className="fas fa-plus"></i> Agregar
                </button>
            )}
            <br />
            <Modal
                title="Agregar Descanso"
                isVisible={isVisible}
                setIsVisible={setIsVisible}
                width={1000}
            >
                <FormDescanso
                    informe={informe}
                    descanso={descanso}
                    setDescanso={setDescanso}
                    tiposLicencias={tiposLicencias}
                    zonasLabores={zonasLabores}
                    reloadData={reloadData}
                    setReloadData={setReloadData}
                />
            </Modal>
        </>
    );
}

const FormDescanso = ({ informe, tiposLicencias, zonasLabores, descanso, setDescanso, reloadData, setReloadData }) => {

    const { usuario, editar } = JSON.parse(sessionStorage.getItem('data'));

    const [rut, setRut] = useState('');
    const [trabajador, setTrabajador] = useState(null);

    if (descanso) {
        console.log(descanso);
    }

    useEffect(() => {
        if (trabajador) {
            setDescanso({
                ...descanso,
                zona_labor_id: trabajador.zona_labor_id
            });
        }
    }, [trabajador]);

    const handleSubmit = e => {
        e.preventDefault();
        Axios.post(`/api/registros-descansos`, {
            ...descanso,
            trabajador: trabajador,
            usuario_id: usuario.id,
            informe_id: informe.id,
            empresa_id: informe.empresa_id
        })
            .then(res => {
                //console.log(res);
                setReloadData(!reloadData);
                setTrabajador(null);
                setDescanso(null);
                setRut('');
                notification['success']({
                    message: res.data.message
                });
            })
            .catch(err => {
                console.error(err);
                notification['error']({
                    message: err.response.data.message
                });
            });
    }

    const buscarTrabajador = e => {
        e.preventDefault();
        Axios.get(`/api/sqlsrv/trabajador/${rut}/${informe?.empresa_id}`)
            .then(res => {
                //console.log(res);
                notification['success']({
                    message: 'Trabajador encontrado'
                });
                setTrabajador(res.data);
            })
            .catch(err => {
                console.error(err);
                notification['error']({
                    message: err.response.data.message
                });
            });
    }

    return (
        <form>
            <div className="row">
                <form className="col-md-4" onSubmit={buscarTrabajador}>
                    RUT:<br />
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
                            <button className="btn btn-primary" type="submit">
                                <i className="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div className="col-md-4">
                    Trabajador:<br />
                    <input
                        className="form-control"
                        value={`${trabajador?.nombre || ''} ${trabajador?.apellido_paterno || ''} ${trabajador?.apellido_materno || ''}`}
                        readOnly={true}
                    />
                </div>
                <div className="col-md-4">
                    Zona Labor:<br />
                    <Select
                        value={descanso?.zona_labor_id} showSearch
                        style={{ width: '100%' }} optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setDescanso({ ...descanso, zona_labor_id: e })}
                        size="small"
                    >
                        {zonasLabores.map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id} - ${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-4">
                    Tipo Licencia:<br />
                    <Select
                        value={descanso?.tipo_licencia_medica_id} showSearch
                        style={{ width: '100%' }} optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setDescanso({ ...descanso, tipo_licencia_medica_id: e })}
                        size="small"
                    >
                        {tiposLicencias.map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id} - ${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Desde:<br />
                    <input
                        className="form-control" type="date"
                        value={descanso?.fecha_inicio || ''}
                        onChange={e => setDescanso({ ...descanso, fecha_inicio: e.target.value })}
                    />
                </div>
                <div className="col-md-4">
                    Hasta:<br />
                    <input
                        className="form-control" type="date"
                        value={descanso?.fecha_fin || ''}
                        onChange={e => setDescanso({ ...descanso, fecha_fin: e.target.value })}
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-12">
                    Observación:<br />
                    <textarea
                        className="form-control"
                        value={descanso?.observacion}
                        onChange={e => setDescanso({ ...descanso, observacion: e.target.value })}
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-12">
                    <button className="btn btn-primary btn-block" type="button" onClick={handleSubmit}>
                        Ingresar
                    </button>
                </div>
            </div>
        </form>
    );
}
