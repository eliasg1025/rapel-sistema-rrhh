import React, { useState, useEffect } from 'react';
import { TablaLU } from '../TablaLU';
import { FiltroTabla } from '../FiltroTabla';
import Axios from 'axios';
import moment from 'moment';
import { message } from 'antd';
import { MenuTabla } from '../components/MenuTabla';

export const Liquidaciones = () => {

    const [data, setData] = useState([]);
    const [filtro, setFiltro] = useState({
        desde: moment().subtract(1, 'M').format('YYYY-MM'),
        hasta: moment().format('YYYY-MM'),
        estado: 0,
        empresa_id: 9
    });
    const [reloadData, setReloadData] = useState(false);
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
        getData();
    }, [filtro, reloadData]);

    return (
        <>
            <h4>Liquidaciones</h4>
            <br />
            <MenuTabla
                filtro={filtro}
                data={data}
                reloadData={reloadData}
                setReloadData={setReloadData}
            />
            <FiltroTabla
                getData={getData}
                filtro={filtro}
                setFiltro={setFiltro}
            />
            <br />
            <TablaLU
                data={data}
                loading={loading}
            />
        </>
    );
}
