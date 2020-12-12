import React, { useEffect, useState } from 'react';
import { Button, notification, Table, Tooltip, Modal, Tag, DatePicker } from 'antd';
import moment from 'moment';

import { FiniquitosProvider } from '../../../providers';

const finiquitosProvider = new FiniquitosProvider();

export const TablaFiniquitosIndividual = ({ reload, setReload, form, setForm }) => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const [filtro, setFiltro] = useState({
        desde: moment().format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
        usuario_carga_id: 0,
        rut: '',
    });

    const [loading, setLoading] = useState(false);
    const [finiquitos, setFiniquitos] = useState([]);

    const confirmDelete = (id) => {
        Modal.confirm({
            title: 'Eliminar Finiquito',
            content: '¿Desea eliminar este registro?',
            okText: 'SI',
            cancelText: 'Cancelar',
            onOk: () => deleteFiniquito(id)
        })
    }

    const deleteFiniquito = async (id) => {
        const { message, data } = await finiquitosProvider.delete(id);

        setReload(!reload);

        notification['success']({
            message: message
        });
    }

    const getFiniquitos = async () => {
        setLoading(true);
        try {
            const { message, data } = await finiquitosProvider.get(usuario.id, filtro);

            console.log(data);
            setFiniquitos(data);
        } catch (e) {
            notification['error']({
                message: e
            });
        } finally {
            setLoading(false);
        }
    }

    const handleExportar = () => {

    }

    useEffect(() => {
        getFiniquitos();
    }, [reload, filtro]);


    const columns = [
        {
            title: 'Fecha Finiquito',
            dataIndex: 'fecha_finiquito',
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor',
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa',
            render: item => item.shortname
        },
        {
            title: 'DNI',
            dataIndex: 'persona_id',
        },
        {
            title: 'Apellidos y Nombres',
            dataIndex: 'persona',
            render: (item, value) => `${item.apellido_paterno} ${item.apellido_materno} ${item.nombre}`
        },
        {
            title: 'Regimen',
            dataIndex: 'regimen',
            render: (item, value) => item.name
        },
        {
            title: 'Oficio',
            dataIndex: 'oficio',
            render: (item, value) => item.name
        },
        {
            title: 'Tipo Documento',
            dataIndex: 'tipo_cese',
            render: item => item.name
        },
        {
            title: 'Tiempo Servicio',
            dataIndex: 'tiempo_servicio',
            render: (_, value) => moment(value.fecha_finiquito).diff(moment(value.fecha_inicio_periodo), 'months') >= 0 ? moment(value.fecha_finiquito).diff(moment(value.fecha_inicio_periodo), 'months') : 0
        },
        {
            title: 'Estado',
            dataIndex: 'estado',
            render: (record) => <Tag color={record.color}>{record.name}</Tag>
        },
        {
            title: 'Cargado por',
            dataIndex: 'usuario',
            render: (record) => `${record.trabajador.apellido_paterno} ${record.trabajador.apellido_materno} ${record.trabajador.nombre}` 
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (item, value) => (
                <Button.Group size="small">
                    {/* <Tooltip title="Editar Registro">
                        <button className="btn btn-primary btn-sm">
                            <i className="fas fa-edit"></i>
                        </button>
                    </Tooltip> */}
                    <Tooltip title="Ver documento">
                        <a href={`/ficha/cese/${value.id}`} className="btn btn-primary btn-sm" target="_blank">
                            <i className="fas fa-search"></i>
                        </a>
                    </Tooltip>
                    <Tooltip title="Eliminar Registro">
                        <button className="btn btn-danger btn-sm" onClick={() => confirmDelete(value.id)}>
                            <i className="fas fa-trash"></i>
                        </button>
                    </Tooltip>
                </Button.Group>
            )
        },
    ];

    return (
        <>
            <br />
            <div className="row">
                <div className="col-md-4 col-sm-6 col-xd-12">
                    Desde - Hasta:<br />
                    <DatePicker.RangePicker
                        placeholder={['Desde', 'Hasta']}
                        style={{ width: '100%' }}
                        onChange={(date, dateString) => {
                            setFiltro({
                                ...filtro,
                                desde: dateString[0],
                                hasta: dateString[1],
                            });
                        }}
                        value={[moment(filtro.desde), moment(filtro.hasta)]}
                    />
                </div>
            </div>
            <br />
            <b style={{ fontSize: '13px' }}>Cantidad: {finiquitos.length} finiquitos&nbsp;<button className="btn btn-success btn-sm" onClick={handleExportar}>
                        <i className="fas fa-file-excel" /> Exportar
                    </button></b>
            <br /><br />
            <Table
                loading={loading}
                size="small"
                rowClassName={(record, index) => 'hoverable ' + (record.regimen.id === 1 ? 'table-row-warning' : null)}
                bordered
                columns={columns}
                dataSource={finiquitos.map(item => ({ ...item, key: item.id })) || []}
                scroll={{ x: 1100 }}
                onRow={(record, rowIndex) => {
                    return {
                        onClick: e => {
                            console.log(record);
                            setForm({
                                ...record,
                                tiempo_servicio: moment(record.fecha_finiquito).diff(moment(record.fecha_inicio_periodo), 'months') >= 0 ? moment(record.fecha_finiquito).diff(moment(record.fecha_inicio_periodo), 'months') : 0
                            });
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }, // click row
                        onDoubleClick: e => {}, // double click row
                        onContextMenu: e => {}, // right button click row
                    };
                }}
            />
        </>
    );
}
