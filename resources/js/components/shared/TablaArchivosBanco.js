import React, { useState, useEffect } from 'react';
import { Table, Tooltip } from 'antd';
import Axios from 'axios';
import { split } from 'lodash';

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
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (_, record) => (
                <div className="btn-group">
                    <Tooltip title="Descargar">
                        <button  className="btn btn-light" type="button" onClick={() => descargar(record.link)}>
                            <i className="fas fa-download"></i>
                        </button>
                    </Tooltip>
                </div>
            )
        },
    ];

    const descargar = link => {
        const separated = split(link, '/');

        Axios({
            url: '/api/archivo-banco/descargar',
            data: { link },
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(separated);

                let blob = new Blob([response.data], { type: 'application/zip' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `ARCHIVOS-BANCO_${separated[2].toUpperCase()}_${separated[separated.length - 1]}.zip`
                link.click();
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
