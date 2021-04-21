import React, { useEffect, useState } from 'react';
import { Table, DatePicker, notification, Modal } from 'antd';
import moment from 'moment';
import Axios from 'axios';

export const TableSegurosVida = ({ reload, setReload }) => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [loading, setLoading] = useState(false);
    const [seguros, setSeguros] = useState([]);
    const [filtro, setFiltro] = useState({
        desde: moment().subtract(7, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        estado: 0,
        usuario_carga_id: 0,
        rut: '',
    });

    const columns = [
        {
            title: 'Fecha y Hora',
            dataIndex: 'created_at',
            render: (item, record) => moment(item).format('DD/MM/YYYY hh:mm:ss')
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa',
            render: (item, record) => item.shortname
        },
        {
            title: 'RUT',
            dataIndex: 'rut',
            render: (item, record) => record.trabajador.rut
        },
        {
            title: 'Trabajador',
            dataIndex: 'trabajador',
            render: (item, record) => `${item.apellido_paterno} ${item.apellido_materno} ${item.nombre}`
        },
        {
            title: 'Régimen',
            dataIndex: 'regimen',
            render: (item) => `${item.name}`
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor',
            render: (item) => `${item.name}`
        },
        {
            title: 'Cargado por',
            dataIndex: 'usuario',
            render: (item, record) => `${item.trabajador.apellido_paterno} ${item.trabajador.apellido_materno} ${item.trabajador.nombre}`
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (item, record) => (
                <button
                    className="btn btn-danger btn-sm"
                    type="button"
                    onClick={() => confirmDelete(record.id)}
                >
                    <i className="fas fa-trash-alt"></i>
                </button>
            )
        },
    ];

    const confirmDelete = id => {
        Modal.confirm({
            title: "Borrar registro",
            content: "¿Desea borrar este registro?",
            okText: "Si, BORRAR",
            cancelText: "Cancelar",
            onOk: () => deleteRecord(id)
        });
    }

    const deleteRecord = id => {
        Axios.delete(`/api/seguros-vida/${id}`)
            .then(res => {
                const { data, message } = res.data;

                notification['success']({
                    message
                });

                setReload(!reload);
            })
            .catch(err => {
                notification['error']({
                    message: 'Error al borrar registro'
                });
                console.log(err);
            });
    }

    const getData = () => {
        setLoading(true);
        Axios.get(`/api/seguros-vida?usuario_id=${usuario.id}&desde=${filtro.desde}&hasta=${filtro.hasta}`)
            .then(res => {
                const { data, message } = res.data;

                setSeguros(data.map(item => ({ ...item, key: item.id })));
            })
            .catch(err => {
                console.error(err);

                notification['error']({
                    message: 'Error al obtener data'
                });
            })
            .finally(() => setLoading(false));
    }

    const handleExportar = () => {
        const headings = [
            'FECHA HORA',
            'EMPRESA',
            'RUT',
            'APELLIDOS Y NOMBRES',
            'CARGADO POR'
        ];

        const d = seguros.map(item => {
            return {
                fecha_hora: item.fecha_hora,
                empresa: item.empresa.shortname,
                rut: item.trabajador.rut,
                apellidos_nombres: `${item.trabajador.apellido_paterno} ${item.trabajador.apellido_materno} ${item.trabajador.nombre}`,
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
                link.download = `REGISTROS-SEGUROS-VIDA-LEY_${filtro.desde}-${filtro.hasta}.xlsx`
                link.click();
            });
    }

    useEffect(() => {
        getData();
    }, [reload, filtro]);

    return (
        <>
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
            <b style={{ fontSize: '13px' }}>Cantidad: {seguros.length} registros&nbsp;<button className="btn btn-success btn-sm" onClick={handleExportar}>
                        <i className="fas fa-file-excel" /> Exportar
                    </button></b>
            <br /><br />
            <Table
                size="small"
                bordered
                scroll={{ x: 1000 }}
                columns={columns}
                dataSource={seguros}
                loading={loading}
            />
        </>
    );
}
