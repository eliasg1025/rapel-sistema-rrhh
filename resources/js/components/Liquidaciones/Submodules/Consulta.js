import Axios from 'axios';
import React, { useState, useEffect } from 'react';
import BuscarTrabajador from '../../shared/BuscarTrabajador';
import { InfoTrabajador } from '../components/InfoTrabajador';
import { TablaConsulta } from '../components/TablaConsulta';

export const Consulta = () => {

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState([]);

    const [liquidaciones, setLiquidaciones] = useState([]);

    useEffect(() => {
        if (trabajador) {
            console.log(trabajador)

            Axios.get(`/api/finiquitos/${trabajador.rut}/trabajador`)
                .then(res => {
                    console.log(res);
                    setLiquidaciones(res.data.map(e => {
                        return {
                            tipo: 'LIQUIDACIÓN',
                            ...e
                        }
                    }));
                })
                .catch(err => {
                    console.error(err);
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
                data={liquidaciones}
            />
        </>
    );
}
