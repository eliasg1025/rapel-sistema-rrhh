import React, { useState, useEffect } from 'react';
import { Button, notification, Spin, Card } from 'antd';

import CargasPdf from '../components/Home/CargasPdf';
import CargasExcel from '../components/Home/CargasExcel';

export default function Home(props) {
    console.log(props)
    const [upload, setUpload] = useState(false);
    const [loading, setLoading] = useState(false);


    useEffect(() => {
        if (upload) {
            setLoading(true);

            setUpload(false);
        }
    }, [upload]);

    const uploadDataLocalidades = () => {
        setLoading(true);

    };

    return (
        <div>
            <h4>Bienvenido, <b>{props.usuario.usuario.username}</b></h4>
            <br />
            {
                props.usuario.usuario.rol === 'admin' ? (
                    <Spin spinning={loading}>
                        <Card>
                            <h5>Opciones de administrador</h5>
                            <br></br>
                            <Button onClick={() => setUpload(true)}>
                                Actualizar datos empresa
                            </Button>
                            <Button onClick={uploadDataLocalidades}>
                                Actualizar datos localidades
                            </Button>
                        </Card>
                    </Spin>
                ) : ''
            }
            <br/>
            <Card>
                <h6><u>Cargas realizadas</u></h6>
                <br></br>
                <h6>Contratos</h6>
                    <CargasPdf />
                <br />
                <h6>Fichas excel</h6>
                    <CargasExcel />
            </Card>
        </div>
    )
}
