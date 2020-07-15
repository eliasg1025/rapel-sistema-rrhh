import React, { useState, useEffect } from 'react';
import { Table, Space, notification } from 'antd';


const CargasPdf = () => {

    const [cargasPdf, setCargasPdf] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const res = await axios.get('/api/cargas-pdf');
                const cargas = res.data.map(carga => {
                    return {
                        ...carga,
                        key: carga.id
                    }
                });
                setCargasPdf(cargas);
            } catch (err) {
                notification['error']({
                    message: 'Error al traer los datos de las cargas pdf'
                })
                console.log(err);
            }
        };
        fetchData();
    }, [])

    const columns = [
        {
            title: 'Codigo',
            dataIndex: 'id',
            key: 'id'
        },
        {
            title: 'Fecha y hora',
            dataIndex: 'fecha_hora',
            key: 'name',
        },
        {
            title: 'Usuario',
            dataIndex: 'username',
            key: 'username'
        },
        {
            title: 'Enlace',
            key: 'action',
            render: (_, record) => {
                const link = `/storage/${record.link}`
                return (
                    <Space size="middle">
                        <a href={link} target="_blank" rel="noopener noreferrer">Enlace</a>
                    </Space>
                )
            }
        },
    ];

    return <Table columns={columns} dataSource={cargasPdf} size="small"/>;
};

export default CargasPdf;
