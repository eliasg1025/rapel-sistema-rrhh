import React, { useState, useEffect } from 'react';
import { DatePicker } from 'antd';
import moment from 'moment';
import Axios from 'axios';
import Swal from 'sweetalert2';

moment.locale('es');

export const ParaPago = ({ data, reloadData, setReloadData, setIsVisibleParent }) => {

    const [liquidaciones, setLiquidaciones] = useState([]);
    const [form, setForm] = useState({
        desde: moment().subtract(30, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        fecha: moment().format('YYYY-MM-DD').toString()
    });
    const [loading, setLoading] = useState(false);

    const getFechasFirmado = datos => {
        const fechas_repetidas = datos.map(l => l.fecha_firmado);
        const fechas = new Set(fechas_repetidas);
        return Array.from(fechas).sort();
    }

    const getFiniquitosEntreFechas = () => {
        return data.filter( f => {
            return moment(f.fecha_firmado, 'DD/MM/YYYY').isBetween( moment(form.desde), moment(form.hasta), "days", "[]" )
        });
    }

    useEffect(() => {
        setLiquidaciones(getFiniquitosEntreFechas(data));
    }, [form.desde, form.hasta]);

    const handleSubmit = e => {
        e.preventDefault();
        setLoading(true);
        Axios.post('/api/finiquitos/programar-para-pago', {
            fecha: form.fecha,
            finiquitos: liquidaciones.map(e => e.id )
        })
            .then(res => {
                const { message } = res.data;

                setLoading(false);
                Swal.fire(message, '', 'success')
                    .then(res => {
                        setIsVisibleParent(false);
                        setReloadData(!reloadData);
                    });
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
                Swal.fire('Error al actualizar el estado', '', 'error');
            });
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="form-row">
                <div className="col-md-6">
                    Fecha Pago:<br />
                    <DatePicker
                        allowClear={false}
                        style={{ width: '100%' }}
                        placeholder="Fecha Pago"
                        onChange={(date, dateString) => {
                            setForm({
                                ...form,
                                fecha: dateString
                            });
                        }}
                        value={moment(form.fecha)}
                    />
                </div>
                <div className="col-md-6">
                    <br />
                    <input
                        type="text" className="form-control"
                        value={moment(form.fecha).format('dddd').toUpperCase()} readOnly={true}
                    />
                </div>
            </div>
            <div className="form-row mt-1">
                <div className="col-md-6">
                    Fechas Firmado:<br />
                    <DatePicker.RangePicker
                        allowClear={false}
                        style={{ width: '100%' }}
                        placeholder={['Desde', 'Hasta']}
                        onChange={(date, dateString) => {
                            setForm({
                                ...form,
                                desde: dateString[0],
                                hasta: dateString[1],
                            });
                        }}
                        value={[moment(form.desde), moment(form.hasta)]}
                    />
                </div>
                <div className="col-md-6">
                    Cantidad:<br />
                    <span style={{ fontWeight: 'bold' }}>{ liquidaciones.length || 0 } finiquitos</span>
                </div>
            </div>
            <br />
            <div className="form-row">
                <div className="col">
                    <button className="btn btn-primary btn-block" type="submit">
                        {!loading ? 'Programar para pago' : (
                            <>
                                <i className="fas fa-spinner fa-spin" />&nbsp;Cargando
                            </>
                        )}
                    </button>
                </div>
            </div>
        </form>
    );
}
