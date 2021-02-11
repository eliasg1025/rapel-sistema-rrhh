import React from "react";
import { Table } from 'antd';

export const TablaResumen = ({ data, loading }) => {

    const columns = [
        {
            title: "Fecha Retorno",
            dataIndex: "fecha_retorno"
        },
        {
            title: "Zona Labor",
            dataIndex: "zona_labor"
        },
        {
            title: "Regimen",
            children: [
                {
                    title: "Empleados Agrarios",
                    dataIndex: "Empleados Agrarios"
                },
                {
                    title: "Empleados Regulares",
                    dataIndex: "Empleados Regulares"
                },
                {
                    title: "Obreros",
                    dataIndex: "Obreros"
                },
                {
                    title: "Administrativos",
                    dataIndex: "Administrativos"
                }
            ]
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

    return <Table size="small" columns={columns} dataSource={data} bordered loading={loading} />;
};
