import React, { useState, useEffect } from 'react';
import { Table } from 'antd';
import Axios from 'axios';

export const TablaArchivosBanco = ({ reloadData }) => {

    const [archivos, setArchivos] = useState([]);

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Fecha Pago',
            dataIndex: 'fecha_pago'
        },
        {
            title: 'Descargar',
            dataIndex: 'descargar',
            render: (_, record) => (
                <button  className="btn" type="button" onClick={() => descargar(record.link)}>
                    <i className="fas fa-download"></i>
                </button>
            )
        },
    ];

    const descargar = link => {
        Axios({
            url: '/api/archivo-banco/descargar',
            data: { link },
            method: 'POST',
            //responseType: 'blob'
        })
            .then(res => {
                console.log(res);
            })
    }

    useEffect(() => {
        let intentos = 0;
        function fetchArchivosBanco() {
            intentos++;
            Axios.get('/api/archivo-banco/liquidaciones')
                .then(res => {
                    setArchivos(res.data);
                })
                .catch(err => {
                    console.error(err);
                    if (intentos < 5) {
                        fetchArchivosBanco();
                    }
                });
        }

        fetchArchivosBanco();
    }, [reloadData]);

    return (
        <Table
            columns={columns} scroll={{ x: 500 }}
            dataSource={archivos}
            size="small"
        />
    );
}
