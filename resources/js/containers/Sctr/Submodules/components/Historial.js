import React, { useState, useEffect } from 'react';
import { Table, Tag } from 'antd';
import Axios from 'axios';

const columns = [
    {
        title: 'Fecha y hora',
        dataIndex: 'created_at'
    },
    {
        title: 'Empresa',
        dataIndex: 'empresa'
    },
    {
        title: 'RUT',
        dataIndex: 'rut'
    },
    {
        title: 'Nombre Completo',
        dataIndex: 'nombre_completo'
    },
    {
        title: 'Zona Labor',
        dataIndex: 'zona_labor'
    },
    {
        title: 'Oficio',
        dataIndex: 'oficio'
    },
    {
        title: '¿Tiene SCTR?',
        dataIndex: 'sctr',
        render: (_, record) => _ ? <Tag color="success">SI TIENE</Tag> : <Tag color="error">NO TIENE</Tag>
    }
];

export const Historial = ({ reloadData }) => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [consultas, setConsultas] = useState([]);

    useEffect(() => {
        Axios.get(`/api/consulta-sctr/${usuario.id}`)
            .then(res => {
                setConsultas(res.data.map(c => {
                    return {
                        ...c,
                        key: c.id,
                    }
                }));
            })
            .catch(err => console.error(err));
    }, [reloadData]);

    const handleExportar = () => {
        console.log(consultas);

        const headings = [
            'Fecha y hora',
            'Empresa',
            'RUT',
            'Nombre Completo',
            'Zona Labor',
            'Oficio',
            '¿Tiene SCTR?'
        ];

        const data = consultas.map(c => {
            return {
                fecha_hora: c.created_at,
                empresa: c.empresa,
                rut: c.rut,
                nombre_completo: c.nombre_completo,
                zona_labor: c.zona_labor,
                oficio: c.oficio,
                sctr: c.sctr ? 'SI' : 'NO'
            }
        });

        Axios({
            url: '/descargar',
            data: {headings, data},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `HISTORIAL-SCTR.xlsx`
                link.click();
            })
    }

    return (
        <>
            <button type="button" className="btn btn-success btn-sm" onClick={handleExportar}>
                <i className="far fa-file-excel"></i> Exportar
            </button>
            <br />
            <div className="row">
                <div className="col">
                    <Table
                        columns={columns} size="small" dataSource={consultas}
                        scroll={{ x: 700 }}
                    />
                </div>
            </div>
        </>
    );
}
