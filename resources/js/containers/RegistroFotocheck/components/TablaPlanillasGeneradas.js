import React from "react";
import { Table, Tooltip } from 'antd';
import Axios from 'axios';

export const TablaPlanillasGeneradas = ({
    data,
    loading,
    reload,
    setReload,
    handleDelete
}) => {
    const columns = [
        {
            title: 'Fecha',
            dataIndex: 'fecha_planilla'
        },
        {
            title: "DNI",
            dataIndex: "trabajador",
            render: item => item?.rut
        },
        {
            title: "Trabajador",
            dataIndex: "trabajador",
            render: item =>
                item?.apellido_paterno +
                " " +
                item?.apellido_materno +
                " " +
                item?.nombre
        },
        {
            title: 'Hora Entrada',
            dataIndex: 'hora_entrada'
        },
        {
            title: 'Hora Salida',
            dataIndex: 'hora_salida'
        },
        {
            title: 'Cargado por',
            dataIndex: 'usuario',
            render: item => `${item.trabajador.apellido_paterno} ${item.trabajador.apellido_materno} ${item.trabajador.nombre}`
        },
        {
            title: "Acciones",
            dataIndex: "id",
            render: (_, record) => (
                <Tooltip title="Eliminar Registro">
                    <button className="btn btn-danger btn-sm" onClick={() => handleDelete(record.id)}>
                        <i className="fas fa-trash"></i>
                    </button>
                </Tooltip>
            )
        }
    ];

    const handleExportar = () => {
        const headings = [
            "FECHA",
            "RUT",
            "TRABAJADOR",
            "HORA ENTRADA",
            "HORA SALIDA",
            "PATENTE",
            "MOTIVO",
        ];

        const d = data.map(item => {
            return {
                fecha_solicitud: item.fecha_planilla,
                dni: item.trabajador.rut,
                trabajador: item?.trabajador.apellido_paterno + " " + item?.trabajador.apellido_materno + " " + item?.trabajador.nombre,
                hora_entrada: item.hora_entrada,
                hora_salida: item.hora_salida,
                patente: "",
                motivo: "",
            };
        });

        Axios({
            url: "/descargar",
            data: { headings, data: d },
            method: "POST",
            responseType: "blob"
        }).then(response => {
            let blob = new Blob([response.data], {
                type:
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "PLANILLAS-MANUALES.xlsx";
            link.click();
        });
    }

    return (
        <>
            <b style={{ fontSize: "13px" }}>
                Cantidad: {data.length} registros&nbsp;
                <button
                    className="btn btn-success btn-sm mr-1"
                    onClick={handleExportar}
                >
                    <i className="fas fa-file-excel" /> Exportar
                </button>
            </b>
            <br /><br />
            <Table
                size="small"
                bordered
                columns={columns}
                dataSource={data}
                loading={loading}
            />
        </>
    );
};
