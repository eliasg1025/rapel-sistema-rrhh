import React, {useEffect, useState} from 'react';
import { Button, notification, Spin, Result } from 'antd';
import Axios from 'axios';
import { PasosIniciales, ResumenBono, Resultados } from '../components';

export const Bono = () => {

    const { usuario, editar } = JSON.parse(sessionStorage.getItem("data"));

    const [bono, setBono] = useState(null);
    const [loadingBono, setLoadingBono] = useState(false);

    useEffect(() => {
        setLoadingBono(true);
        Axios.get(`/api/bonos/${editar}`)
            .then(res => {
                const { data } = res.data;
                setBono(data);
            })
            .catch(err => {
                console.error(err);
                notification['error']({
                    message: 'Error al obtener el bono'
                });
            })
            .finally(() => setLoadingBono(false));
    }, []);

    return (
        <>
            <Button type="ghost" size="small" onClick={() => location.replace('/bonos')}>
                <i className="fas fa-arrow-left"></i> Atrás
            </Button>
            <br /><br />
            <Spin spinning={loadingBono}>
                <h4><u>BONO:</u> {bono?.name}</h4>
                <br />
                {
                    bono ? (
                        bono?.listo_para_usar ? (
                            <>
                                <ResumenBono bono={bono}/>
                                <br />
                                <Resultados bono={bono} />
                            </>
                        ) : (
                            <PasosIniciales bono={bono} />
                        )
                    ) : (
                        <Result
                            status="500"
                            title="Error al cargar el recurso"
                            extra={<Button type="primary" onClick={() => location.reload()}>Volver a cargar</Button>}
                        />
                    )
                }
            </Spin>
        </>
    );
}
