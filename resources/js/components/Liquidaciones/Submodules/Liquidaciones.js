import React, { useState, useEffect } from 'react';
import { TablaLU } from '../TablaLU';
import { FiltroTabla } from '../FiltroTabla';
import Axios from 'axios';
import moment from 'moment';
import { message } from 'antd';

export const Liquidaciones = () => {

    const [data, setData] = useState([]);
    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM'),
        hasta: moment().format('YYYY-MM'),
        estado: 0,
        empresa_id: 0
    });

    const getData = () => {
        let intentos = 0;
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
    }, []);

    return (
        <>
            <h4>Liquidaciones</h4>
            <br />
            <FiltroTabla
                getData={getData}
                filtro={filtro}
                setFiltro={setFiltro}
            />
            <TablaLU
                data={data}
            />
        </>
    );
}
