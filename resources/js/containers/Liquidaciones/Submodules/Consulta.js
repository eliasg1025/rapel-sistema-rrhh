import Axios from 'axios';
import React, { useState, useEffect } from 'react';
import BuscarTrabajador from '../../shared/BuscarTrabajador';
import { InfoTrabajador } from '../components/InfoTrabajador';
import { TablaConsulta } from '../components/TablaConsulta';

export const Consulta = () => {

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState([]);
    const [loading, setLoading] = useState(false);
    const [liquidaciones, setLiquidaciones] = useState([]);

    useEffect(() => {
        if (trabajador) {
            console.log(trabajador)

            setLoading(true);
            Axios.get(`/api/pagos/${trabajador.rut}/trabajador`)
                .then(res => {
                    console.log(res);
                    setLiquidaciones(res.data.map(item => {
                        return {
                            ...item,
                            key: item.id
                        }
                    }));

                    setLoading(false);
                })
                .catch(err => {
                    console.error(err);
                    setLoading(false);
                });
            setLiquidaciones();
        } else {
            setLiquidaciones([]);
        }
    }, [trabajador]);

    return (
        <>
            <h4>Consulta Estado Liquidaciones - Utilidades</h4>
            <br />
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
                activo={false}
            />
            <InfoTrabajador
                trabajador={trabajador}
            />
            <br />
            <TablaConsulta
                loading={loading}
                data={liquidaciones}
            />
        </>
    );
}
