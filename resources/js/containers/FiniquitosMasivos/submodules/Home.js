import Axios from 'axios';
import moment from 'moment';
import React, { useEffect, useState } from 'react';
import { Result, Button, Tag } from 'antd';

import { CreateGrupoForm, TablaGrupo, TablaFiniquitos, CreateFiniquitoForm } from '../components';

export const Home = () => {

    const { usuario, editar } = JSON.parse(sessionStorage.getItem('data'));

    const [reload, setReload] = useState(false);
    const [informe, setInforme] = useState({
        fecha_finiquito: moment().format('YYYY-MM-DD').toString(),
        zona_labor: '',
        ruta: '',
        codigo_bus: '',
        finiquitos: [],
    });

    useEffect(() => {
        if (editar !== 0) {
            Axios.get(`/api/grupos-finiquitos/${editar}`)
                .then(res => {
                    console.log(res.data.data);
                    setInforme(res.data.data);
                })
                .catch(err => {
                    console.error(err);
                })
        }
    }, [reload]);

    return (
        <>
            {editar === 0 ? (
                <>
                    <h4>Finiquitos Masivos</h4>
                    <br />
                    <CreateGrupoForm
                        reload={reload}
                        setReload={setReload}
                        informe={informe}
                    />
                    <br />
                    <TablaGrupo
                        reload={reload}
                        setReload={setReload}
                    />
                </>
            ) : (
                <>
                    {
                        informe ? (
                            <>
                                <button className="btn btn-light pb-2" onClick={() => location.replace('/finiquitos')}>
                                    <i className="fas fa-backward"></i> Atrás
                                </button>
                                <h4>
                                    Registrar Finiquitos: {informe?.ruta || ''} - {informe?.codigo_bus || ''}{" "}{" - "}<Tag color={informe?.estado?.color}>{informe?.estado?.name}</Tag>
                                </h4>
                                <br />
                                <CreateGrupoForm
                                    reload={reload}
                                    setReload={setReload}
                                    editable
                                    informe={informe}
                                />
                                <br />
                                <CreateFiniquitoForm
                                    reload={reload}
                                    setReload={setReload}
                                    informe={informe}
                                />
                                <br />
                                <TablaFiniquitos
                                    reload={reload}
                                    setReload={setReload}
                                    informe={informe}
                                />

                            </>
                        ) : (
                            <div className="container">
                                <Result
                                    status="404"
                                    title="404"
                                    subTitle="Finiquito no encontrado"
                                />,
                            </div>
                        )
                    }
                </>
            )}
        </>
    );
}


