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
            {
                props.usuario.usuario.rol === 'admin' ? (
                    <Spin spinning={loading}>
                        <Card>
                            <h5>Opciones de administrador</h5>
                            <br></br>
                            <Button onClick={() => setUpload(true)}>
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
