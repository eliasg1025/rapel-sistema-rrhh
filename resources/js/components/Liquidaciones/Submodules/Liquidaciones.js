import React, { useState, useEffect } from 'react';
import { TablaLU } from '../TablaLU';
import { FiltroTabla } from '../FiltroTabla';
import Axios from 'axios';
import moment from 'moment';
import { message } from 'antd';
import { MenuTabla } from '../components/MenuTabla';
import { TablaArchivosBanco } from '../../shared/TablaArchivosBanco';

export const Liquidaciones = () => {

    const [data, setData] = useState([]);
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM').toString(),
        hasta: moment().format('YYYY-MM').toString(),
        estado: 0,
        empresa_id: 9
    });
    const [reloadData, setReloadData] = useState(false);
    const [reloadDataAB, setReloadDataAB] = useState(false);
    const [loading, setLoading] = useState(false);

    const getData = () => {
        let intentos = 0;
        setLoading(true);

        function fetchFiniquitos() {
            intentos++;
            Axios.get(`/api/finiquitos?desde=${filtro.desde}&hasta=${filtro.hasta}&estado=${filtro.estado}&empresa_id=${filtro.empresa_id}`)
                .then(res => {
                    message['success']({
                        content: `Se encontraron ${res.data.length} registros`
                    });

                    const total = res.data.map(r => {
                        return {
                            ...r,
                            key: r.id
                        }
                    });

                    setData(total);
                    setLoading(false);
                })
                .catch(err => {
                    if (intentos < 3) {
                        fetchFiniquitos();
                    }
                });
        }

        fetchFiniquitos();
    }

    useEffect(() => {
        setFiltro({
            ...filtro,
            desde: moment().format('YYYY-MM-DD').toString(),
            hasta: moment().format('YYYY-MM-DD').toString()
        });
    }, [filtro.estado]);

    useEffect(() => {
        getData();
    }, [filtro, reloadData]);

    return (
        <>
            <h4>Liquidaciones</h4>
            <FiltroTabla
                getData={getData}
                filtro={filtro}
                setFiltro={setFiltro}
            />
            <br />
            <MenuTabla
                filtro={filtro}
                data={data}
                reloadData={reloadData}
                setReloadData={setReloadData}
                reloadDataAB={reloadDataAB}
                setReloadDataAB={setReloadDataAB}
            />
            <TablaLU
                data={data}
                loading={loading}
                estado={filtro.estado}
            />
            <hr /><br />
            <h5>Archivos Banco</h5>
            <TablaArchivosBanco
                reloadData={reloadDataAB}
            />
        </>
    );
}
