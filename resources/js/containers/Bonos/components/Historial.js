import React, { useState, useEffect } from 'react';
import { Table, Button } from 'antd';
import Axios from 'axios';
import moment from 'moment';

export const Historial = ({ bono, reload }) => {

    const [cargasBonos, setCargasBonos] = useState([]);

    useEffect(() => {
        Axios.get(`/api/cargas-bonos?bono_id=${bono.id}`)
            .then(res => {
                setCargasBonos(res.data.data.map(item => {
                    return {
                        ...item,
                        key: item.id
                    }
                }));
            })
            .catch(err => {
                console.error(err);
            });
    }, [reload]);

    const columns = [
        {
            title: 'Nombre',
            dataIndex: 'name'
        },
        {
            title: 'Generado',
            dataIndex: 'updated_at',
            render: (_, value) => moment(_).format('DD/MM/YYYY hh:mm:ss')
        },
        {
            title: 'Ver',
            dataIndex: 'link',
            render: (_, value) => (
                <a href={`/storage${value.link}`} className="btn btn-light" target="_blank">
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
