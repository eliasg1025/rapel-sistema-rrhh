import React, { useState, useEffect } from 'react';

import {
    TrabajadorProvider,
    RegimenesProvider,
    TiposCesesProvider
} from '../../../providers';

export const CreateFiniquitoFormIndividual = () => {

    const trabajadoresProvider = new TrabajadorProvider();
    const regimenesProvider = new RegimenesProvider();
    const tiposCesesProvider = new TiposCesesProvider();

    const [loadingRut, setLoadingRut] = useState(false);
    const [loading, setLoading] = useState(false);
    const [rut, setRut] = useState("");

    const [regimenes, setRegimenes] = useState([]);
    const [tiposCeses, setTiposCeses] = useState([]);

    const form = useState({
        empresa_id: "",
        regimen_id: "",
        tipo_cese_id: "",
        fecha_inicio_periodo: "",
        fecha_termino_contrato: "",
        tiempo_servicio: 0
    });

    const buscarTrabajador = async e => {
        e.preventDefault();
        setLoadingRut(true);

        try {
            const {
                message,
                data
            } = await trabajadoresProvider.getParaFiniquito(
                rut,
                informe.fecha_finiquito
            );
            notification["success"]({
                message: message
            });
            await setForm(data);
        } catch (e) {
            notification["error"]({
                message: e.message
            });
        } finally {
            setLoadingRut(false);
        }
    };

    useEffect(() => {
        async function fetchData() {
            const { data: regimenes } = await regimenesProvider.get();
            const { data: ceses } = await tiposCesesProvider.get();

            setRegimenes(regimenes);
            setTiposCeses(ceses);
        }

        fetchData();
    }, []);

    return (
        <>
            <div className="row">
                <form className="col-md-4">
                    RUT:<br />
                    
                </form>
            </div>
        </>
    );
}