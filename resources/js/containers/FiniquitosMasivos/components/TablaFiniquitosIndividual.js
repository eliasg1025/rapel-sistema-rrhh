import React, { useEffect, useState } from 'react';
import { Button, notification, Table, Tooltip, Modal, Tag, DatePicker, Input } from 'antd';
import moment from 'moment';
import Axios from 'axios';

import ModalCustom from "../../Modal";

import { FiniquitosProvider } from '../../../providers';

const finiquitosProvider = new FiniquitosProvider();

export const TablaFiniquitosIndividual = ({ reload, setReload, form, setForm }) => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const [filtro, setFiltro] = useState({
        desde: moment().subtract(7, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
        usuario_carga_id: 0,
        rut: '',
    });

    const [loading, setLoading] = useState(false);
    const [finiquitos, setFiniquitos] = useState([]);

    const [viewModal, setViewModal] = useState(false);
    const [deleteForm, setDeleteForm] = useState({
        justificacion: "",
        id: ""
    });

    const confirmDelete = id => {
        setDeleteForm({ id: id });
        setViewModal(true);
    };

    const confirmChangeState = id => {
        Modal.confirm({
            title: 'Marcar como Firmado',
            content: '¿Desea marcar como firmado este registro?',
            okText: 'SI',
            cancelText: 'Cancelar',
            onOk: () => changeState(id)
        });
    }

    const changeState = async (id) => {
        const { message, data } = await finiquitosProvider.changeState(id, { estado_id: 2 });

        setReload(!reload);
        setForm({
            id: "",
            empresa_id: "",
            regimen_id: "",
            tipo_cese_id: "",
            fecha_inicio_periodo: "",
            fecha_termino_contrato: "",
            zona_labor: "",
            tiempo_servicio: 0,
            fecha_finiquito: moment().format("YYYY-MM-DD")
        })

        notification['success']({
            message: message
        });
    }

    const deleteFiniquito = async e => {
        e.preventDefault();
        const { message, data } = await finiquitosProvider.delete(deleteForm.id, {
            justificacion: deleteForm.justificacion
        });

        setReload(!reload);
        setForm({
            id: "",
            empresa_id: "",
            regimen_id: "",
            tipo_cese_id: "",
            fecha_inicio_periodo: "",
            fecha_termino_contrato: "",
            zona_labor: "",
            tiempo_servicio: 0,
            fecha_finiquito: moment().format("YYYY-MM-DD")
        });

        notification["success"]({
            message: message
        });
    };

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
        const headings = [
            'FECHA FINIQUITO',
            'ZONA LABOR',
            'EMPRESA',
            'RUT',
            'APELLIDOS Y NOMBRES',
            'REGIMEN',
            'OFICIO',
            'TIPO DOCUMENTO',
            'TIEMPO SERVICIO',
            'ULTIMO DIA LABORADO',
            'ESTADO',
            'CARGADO POR'
        ];

        const d = finiquitos.map(item => {
            return {
                fecha_finiquito: item.fecha_finiquito,
                zona_labor: item.zona_labor,
                empresa: item.empresa.shortname,
                rut: item.persona_id,
                apellidos_nombres: `${item.persona.apellido_paterno} ${item.persona.apellido_materno} ${item.persona.nombre}`,
                regimen: item.regimen.name,
                oficio: item.oficio.name,
                tipo_documento: item.tipo_cese.name,
                tiempo_servicio: moment(item.fecha_finiquito).diff(moment(item.fecha_inicio_periodo), 'months') >= 0 ? moment(item.fecha_finiquito).diff(moment(item.fecha_inicio_periodo), 'months') : 0,
                ultimo_dia_laborado: item.fecha_ultimo_dia_laborado || '',
                estado: item.estado.name,
                cargado_por: `${item.usuario.trabajador.apellido_paterno} ${item.usuario.trabajador.apellido_materno} ${item.usuario.trabajador.nombre}`
            };
        });

        Axios({
            url: '/descargar',
            data: {headings, data: d},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                //console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `FINIQUITOS_${filtro.desde}-${filtro.hasta}.xlsx`
                link.click();
            });
    }

    useEffect(() => {
        if (filtro.rut.length === 0 || filtro.rut.length >= 8) {
            getFiniquitos();
        }
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
            //render: (_, value) => moment(value.fecha_finiquito).diff(moment(value.fecha_inicio_periodo), 'months') >= 0 ? moment(value.fecha_finiquito).diff(moment(value.fecha_inicio_periodo), 'months') : 0,
            render: (_, value) => {
                let a = moment(value.fecha_finiquito);
                let b = moment(value.fecha_inicio_periodo);

                const years = a.diff(b, 'year');
                b.add(years, 'years');

                const months = a.diff(b, 'months');
                b.add(months, 'months');

                const days = a.diff(b, 'days');

                return `${years} años ${months} meses ${days} días`;
            }
        },
        {
            title: 'Último día laborado',
            dataIndex: 'fecha_ultimo_dia_laborado',
            render: (_, value) => value.fecha_ultimo_dia_laborado,
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
                <div className="btn-group">
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
                    {usuario.modulo_rol.tipo.name !== 'ANALISTA DE GESTION' && (
                        value.estado.name === 'NO FIRMADO' && (
                            <Tooltip title="Estado">
                                <button className="btn btn-primary btn-sm" onClick={() => confirmChangeState(value.id)}>
                                    <i className="fas fa-check"></i>
                                </button>
                            </Tooltip>
                        )
                    )}
                    {value.estado.name === 'SIN EFECTO' ? (
                        usuario.modulo_rol.tipo.name === 'ADMINISTRADOR' && (
                            <Tooltip title="Eliminar Registro">
                                <button className="btn btn-danger btn-sm" onClick={() => confirmDelete(value.id)}>
                                    <i className="fas fa-trash"></i>
                                </button>
                            </Tooltip>
                        )
                    ) : (
                        <Tooltip title="Anular registro">
                            <button className="btn btn-danger btn-sm" onClick={() => confirmDelete(value.id)}>
                                <i className="fas fa-ban"></i>
                            </button>
                        </Tooltip>
                    )}
                </div>
            )
        },
    ];

    return (
        <>
            <br />
            <div className="row">
                <div className="col-md-4 col-sm-6 col-xs-12">
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
                <div className="col-md-4 col-sm-6 col-xs-12">
                    Búsqueda por DNI:<br />
                    <Input
                        placeholder="Mínimo 8 caracteres"
                        value={filtro.rut}
                        onChange={e => setFiltro({ ...filtro, rut: e.target.value })}
                        allowClear
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
            <ModalCustom
                title="Eliminar Finiquito"
                isVisible={viewModal}
                setIsVisible={setViewModal}
            >
                <form className="row" onSubmit={deleteFiniquito}>
                    <div className="col-md-12">
                        <textarea
                            className="form-control"
                            style={{ fontSize: "1.2rem" }}
                            placeholder="Justificación de la anulación"
                            value={deleteForm.justificacion}
                            onChange={e =>
                                setDeleteForm({ ...deleteForm, justificacion: e.target.value })
                            }
                            rows="3"
                        ></textarea>
                    </div>
                    <div className="col-md-12">
                        <div className="btn-group btn-block mt-4">
                            <button
                                type="button"
                                className="btn btn-outline-secondary"
                                onClick={() => setViewModal(false)}
                            >
                                Cancelar
                            </button>
                            <button
                                type="submit"
                                className="btn btn-outline-danger"
                            >
                                Anular
                            </button>
                        </div>
                    </div>
                </form>
            </ModalCustom>
        </>
    );
}
