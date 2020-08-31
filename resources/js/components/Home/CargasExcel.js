import React, { useState, useEffect } from 'react';
import { Table, Space, notification } from 'antd';


const CargasExcel = () => {

    const [cargasPdf, setCargasPdf] = useState([]);

    useEffect(() => {
        let intento = 0;
        const fetchData = async () => {
            intento++;
            try {
                const res = await axios.get('/api/cargas-excel');
                const cargas = res.data.map(carga => {
                    return {
                        ...carga,
                        key: carga.id
                    }
                });
                setCargasPdf(cargas);
            } catch (err) {
                console.log(err);
                if (intento < 5) {
                    fetchData();
                }
            }
        };
        fetchData();
    }, [])

    const columns = [
        {
            title: 'Código',
            dataIndex: 'id',
            key: 'id'
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa',
            key: 'empresa'
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
            title: 'Ver',
            key: 'action',
            render: (_, record) => {
                const link = `/storage/${record.link}`
                return (
                    <Space size="middle">
                        <a href={link} target="_blank" rel="noopener noreferrer">
                            <i className="fas fa-search" />
                        </a>
                    </Space>
                )
            }
        },
    ];

    return <Table columns={columns} dataSource={cargasPdf} size="small" scroll={{ x: 500 }}/>;
};

export default CargasExcel;
