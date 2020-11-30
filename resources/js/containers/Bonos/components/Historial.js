import React, { useState, useEffect } from 'react';
import { Table, Button } from 'antd';
import Axios from 'axios';
import moment from 'moment';

export const Historial = ({ bono }) => {

    const [cargasBonos, setCargasBonos] = useState([]);

    useEffect(() => {
        Axios.get(`/api/cargas-bonos?bono_id=${bono.id}`)
            .then(res => {
                console.log(res);

                setCargasBonos(res.data.data);
            })
            .catch(err => {
                console.error(err);
            });
    }, []);

    const columns = [
        {
            title: 'Nombre',
            dataIndex: 'name'
        },
        {
            title: 'Generado',
            dataIndex: 'created_at',
            render: (_, value) => moment(_).format('DD/MM/YYYY h:m:s')
        },
        {
            title: 'Ver',
            dataIndex: 'link',
            render: (_, value) => (
                <a href={value.link} className="btn btn-light" target="_blank">
                    <i className="fas fa-search"></i>
                </a>
            )
        }
    ];

    return (
        <>
            <Table
                size="small"
                columns={columns}
                dataSource={cargasBonos}
            />
        </>
    );
}
