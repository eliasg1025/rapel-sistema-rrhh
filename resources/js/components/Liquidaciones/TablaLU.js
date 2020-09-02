import React, { useState, useEffect } from 'react';
import { Table, Tag, Checkbox } from 'antd';
import { CheckCircleOutlined, SyncOutlined, CloseCircleOutlined, ClockCircleOutlined } from '@ant-design/icons';
import {ModalBootstrap} from "../shared/ModalBootstrap";
import {ParaPago} from "./components/ParaPago";
import { GenerarArchivoBanco } from './components/GenerarArchivoBanco';

const getColumns = (data) => {

    const getFechasFirmado = liquidaciones => {
        const fechas_repetidas = liquidaciones.map(l => l.fecha_firmado);
        const fechas = new Set(fechas_repetidas);

        return Array.from(fechas).map(f => ({ text: f, value: f }));
    }

    return [
        {
            title: 'Empresa',
            dataIndex: 'empresa',
        },
        {
            title: 'RUT',
            dataIndex: 'rut',
        },
        {
            title: 'Mes',
            dataIndex: 'mes',
        },
        {
            title: 'Año',
            dataIndex: 'ano'
        },
        {
            title: 'Monto',
            dataIndex: 'monto'
        },
        {
            title: 'Fecha Firmado',
            dataIndex: 'fecha_firmado',
            filters: getFechasFirmado(data),
            onFilter: (value, record) => record.fecha_firmado.indexOf(value) === 0
        },
        {
            title: 'Estado',
            dataIndex: 'estado',
            render: (_, record) => renderTags(record.estado)
        },
    ];
}

function renderTags(estado) {
    switch (estado) {
        case 0:
            return <Tag color="default" icon={<ClockCircleOutlined />}>PENDIENTE</Tag>;
        case 1:
            return <Tag color="warning" icon={<ClockCircleOutlined />}>FIRMADO</Tag>;
        case 2:
            return <Tag color="processing" icon={<SyncOutlined spin/>}>PARA PAGO</Tag>;
        case 3:
            return <Tag color="success" icon={<CheckCircleOutlined />}>PAGADO</Tag>;
        case 4:
            return <Tag color="error" icon={<CloseCircleOutlined />}>RECHAZADO</Tag>;
        default:
            return null;
    }
}

export const TablaLU = ({ data, estado, reloadData, setReloadData }) => {
    const [selectedRowKeys , setSelectedRowKeys] = useState([]);
    const [loading, setLoading] = useState(false);
    const [all, setAll] = useState(false);

    const reload = () => {
        setLoading(true);
        setTimeout(() => {
            setSelectedRowKeys([]);
            setLoading(false);
        }, 1500)
    }

    const onSelectChange = selectedRowKeys => {
        console.log('selectedRowKeys changed: ', selectedRowKeys);
        setSelectedRowKeys(selectedRowKeys);
    };

    const toggleSeleccionarTodos = () => {
        if (all) {
            setAll(false);
            setSelectedRowKeys([]);

            return;
        }

        const x = data.map(l => l.id);
        setAll(true);
        setSelectedRowKeys(x);
    }

    const rowSelection = {
        selectedRowKeys,
        onChange: onSelectChange,
    };
    const hasSelected = selectedRowKeys.length > 0;

    return (
        <>
            <div style={{ marginBottom: 16, marginTop: 12 }}>
                <div>
                    <Checkbox
                        onClick={toggleSeleccionarTodos}
                        checked={all}
                    >
                        Seleccionar todos
                    </Checkbox>
                </div>

                {(parseInt(estado) === 1) && (
                    <>
                        <br />
                        <button className="btn btn-primary" disabled={!hasSelected} data-toggle="modal" data-target="#paraPago">
                            Para Pago
                        </button>
                        <span style={{ marginLeft: 8 }}>
                            {hasSelected ? `${selectedRowKeys.length} item(s) seleccionados` : ''}
                        </span>
                    </>
                )}
                {(parseInt(estado) === 2) && (
                    <>
                        <br />
                        <button className="btn btn-primary" data-toggle="modal" data-target="#archivoBanco">
                            Generar archivos banco
                        </button>
                        <span style={{ marginLeft: 8 }}>
                            {hasSelected ? `${selectedRowKeys.length} item(s) seleccionados` : ''}
                        </span>
                    </>
                )}
            </div>
            <Table
                rowSelection={rowSelection} columns={getColumns(data)} dataSource={data} size="small" scroll={{ x: 500 }}
                pagination={{ pageSize: 20 }}
            />

            <ModalBootstrap
                id="paraPago"
                title="Programar para pago"
            >
                <ParaPago
                    finiquitos={rowSelection.selectedRowKeys}
                    reloadData={reloadData}
                    setReloadData={setReloadData}
                />
            </ModalBootstrap>

            <ModalBootstrap
                id="archivoBanco"
                title="Generar archivos banco"
            >
                <GenerarArchivoBanco
                    finiquitos={data}
                    reloadData={reloadData}
                    setReloadData={setReloadData}
                />
            </ModalBootstrap>
        </>
    );
}
