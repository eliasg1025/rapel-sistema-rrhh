import React from "react";
import { Table } from 'antd';

export const TablaResumen = ({ data, loading }) => {

    const columns = [
        {
            title: "Fecha Retorno",
            dataIndex: "fecha_retorno",
            align: "center",
        },
        {
            title: "Zona Labor",
            dataIndex: "zona_labor",
            align: "center",
            ellipsis: true
        },
        {
            title: "Regimen",
            children: [
                {
                    title: "Empleados",
                    dataIndex: "Empleados",
                    align: "center",
                    width: 150
                },
                {
                    title: "Obreros",
                    dataIndex: "Obreros",
                    align: "center",
                    width: 150
                },
            ]
        },
        {
            title: 'TOTAL',
            dataIndex: 'total',
            align: "center",
            width: 150,
            render: (_, record) => <b>{record.Empleados + record.Obreros}</b>
        }
    ];

    /* const data = [
        {
            key: 1,
            FechaRetorno: "2021-02-16",
            ZonaLabor: "",
            "Empleados Agrarios": 3,
            children: [
                {
                    key: 11,
                    FechaRetorno: "2021-02-16",
                    ZonaLabor: "51",
                    "Empleados Agrarios": 2
                },
                {
                    key: 12,
                    FechaRetorno: "2021-02-16",
                    ZonaLabor: "52",
                    "Empleados Agrarios": 1
                }
            ]
        }
    ]; */

    return (
        <>
            <Table
                size="small"
                scroll={{ x: 1000 }}
                columns={columns}
                dataSource={data}
                bordered
                loading={loading}
            />
        </>
    );
};
