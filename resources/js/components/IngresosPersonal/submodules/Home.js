import React, { useState, useEffect } from 'react';
import Axios from 'axios';
import { Button, Spin, Card } from 'antd';

import CargasExcel from '../components/Home/CargasExcel';
import CargasPdf from '../components/Home/CargasPdf';

export const Home = () => {

    const { usuario } = JSON.parse(sessionStorage.getItem("data"));

    const [loading, setLoading] = useState(false);

    const uploadDataEmpresa = () => {
        setLoading(true);

        Axios.get('http://192.168.60.16/api/data/por-empresa')
            .then(res => {
                console.log(res.data.data);

                Axios.post('/api/actualizar-datos/por-empresa', {
                    ...res.data.data
                })
                    .then(res => {
                        console.log(res);
                        setLoading(false);
                    })
                    .catch(err => {
                        console.error(err);
                        setLoading(false);
                    })
            })
            .catch(err => {
                console.log(err);
                setLoading(false);
            })
    }

    const uploadDataLocalidades = () => {
        setLoading(true);

    };

    return (
        <div>
            {
                usuario.rol === 'admin' ? (
                    <Spin spinning={loading}>
                        <Card>
                            <h5>Opciones de administrador</h5>
                            <br></br>
                            <Button onClick={uploadDataEmpresa}>
                                Sincronizar datos empresa
                            </Button>
                            <Button onClick={uploadDataLocalidades}>
                                Sincronizar datos localidades
                            </Button>
                        </Card>
                    </Spin>
                ) : ''
            }
            <br/>
            <Card>
                <h6><u>Cargas realizadas</u></h6>
                <br></br>
                <div className="row">
                    <div className="col-md-6">
                        <h6><i className="far fa-file-alt"/>&nbsp;Contratos</h6>
                        <CargasPdf />
                    </div>
                    <div className="col-md-6">
                        <h6><i className="far fa-file-excel"/>&nbsp;Fichas excel</h6>
                        <CargasExcel />
                    </div>
                </div>
            </Card>
        </div>
    )
}
