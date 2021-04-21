import React, { useState } from 'react';
import { Table, Tabs, Spin } from 'antd';

export const TablaReporte = ({ registros, loading }) => {

    const columns = [
        {
            title: 'Empresa',
            dataIndex: 'Empresa',
        },
        {
            title: 'DNI',
            dataIndex: 'DNI'
        },
        {
            title: 'Fecha',
            dataIndex: 'FECHA',
        },
        {
            title: 'Trabajador',
            dataIndex: 'APELLIDOS_NOMBRES',
        },
        {
            title: 'Zona Labor',
            dataIndex: 'CENTRO_COSTO',
        },
        {
            title: 'Oficio',
            dataIndex: 'CARGO',
        },
        {
            title: 'Horario Ingreso',
            dataIndex: 'Terminal Ingr',
        },
        {
            title: 'Horario Salida',
            dataIndex: 'Terminal Sal',
        },
        {
            title: 'Estacion Entrada',
            dataIndex: 'Estacion Entrada'
        },
        {
            title: 'Hora Ingreso',
            dataIndex: 'Hora Ingreso',
        },
        {
            title: 'Hora Salida',
            dataIndex: 'Hora Salida',
        },
    ];

    return (
        <>
            <br />
            <b style={{ fontSize: "13px" }}>
                Cantidad: {registros.length} registros{" "}
                &nbsp;
                <button
                    className="btn btn-success btn-sm"
                    //onClick={handleExportar}
                >
                    <i className="fas fa-file-excel" /> Exportar
                </button>
            </b>
            <br /><br />
            <Spin spinning={loading}>
                <Tabs defaultActiveKey="1">
                    <Tabs.TabPane tab="Resumen" key="1">
                        Resumen
                    </Tabs.TabPane>
                    <Tabs.TabPane tab="Data" key="2">
                        <Table
                            bordered
                            size="small"
                            columns={columns}
                            dataSource={registros}
                        />
                    </Tabs.TabPane>
                </Tabs>
            </Spin>
        </>
    );
}
