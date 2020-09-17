import React, { useState } from 'react';
import { DatePicker } from 'antd';
import moment from 'moment';
import Axios from 'axios';
import {SubirArchivo} from "../../shared/SubirArchivo";

export const ImportacionTuRecibo = ({ reloadData, setReloadData, setIsVisibleParent }) => {

    const [loading, setLoading] = useState(false);

    const [form, setForm] = useState({
        desde: moment().subtract(7, 'days').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
        empresa_id: '9',
    });

    const handleSubmit = e => {
        e.preventDefault();

        const url = `/api/finiquitos/importar-tu-recibo`;
        const formData = new FormData();
        formData.append('tu-recibo', form.file);
        formData.append('empresa_id', form.empresa_id);
        formData.append('desde', form.desde);
        formData.append('hasta', form.hasta);

        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }

        Swal.fire({
            title: 'Buscando documentos',
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        setLoading(true);
        Axios.post(url, formData, config)
            .then(res => {
                const { message, liquidaciones } = res.data;

                insertarData(liquidaciones);
            })
            .catch(err => {
                console.error(err);
            })
    }

    const insertarData = liquidaciones => {
        Swal.fire({
            title: 'Actualizando estado de los documentos',
            text: `Se encontraron ${liquidaciones.length} documentos firmados`,
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        Axios.post('/api/finiquitos/importar-tu-recibo/insertar', {
            liquidaciones
        })
            .then(res => {
                //console.log(res);

                const { total, completados } = res.data;

                setLoading(false);
                Swal.fire({
                    title: `Proceso completado`,
                    html: `Se han actualizados ${completados} de ${total} registros`,
                    icon: 'info'
                })
                    .then(res => {
                        setIsVisibleParent(false);
                        setReloadData(!reloadData);
                    });
            })
            .catch(err => {
                console.error(err);
            })
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="form-row">
                <div className="col-md-12">
                    Desde - Hasta:<br />
                    <DatePicker.RangePicker
                        style={{ width: '100%' }}
                        placeholder={['Desde', 'Hasta']}
                        allowClear={false}
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
            </div>
            <br />
            <div className="form-row">
                <div className="col-md-12">
                    <SubirArchivo
                        form={form}
                        setForm={setForm}
                    />
                </div>
            </div>
            <br />
            <div className="form-row">
                <div className="col">
                    <button type="submit" className="btn btn-primary btn-block">
                        {!loading ? 'Importar' : (
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
