import React, { useState } from 'react';
import { Table, DatePicker, notification } from 'antd';
import moment from 'moment';
import Axios from 'axios';

export const TableSegurosVida = () => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

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
            dataIndex: 'created_at'
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa',
        },
        {
            title: 'Trabajador',
            dataIndex: 'trabajador'
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones'
        },
    ];

    const getData = () => {
        Axios.get(`/api/seguros-vida?usuario_id=${usuario.id}`)
            .then(res => {
                console.log(res);
            })
            .catch(err => {
                console.error(err);
            })
    }

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
            <Table
                size="small"
                bordered
                columns={columns}
            />
        </>
    );
}