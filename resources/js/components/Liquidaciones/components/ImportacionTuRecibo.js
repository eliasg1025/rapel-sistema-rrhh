import React, { useState } from 'react';
import { DatePicker } from 'antd';
import moment from 'moment';
import Axios from 'axios';
import {SubirArchivo} from "../../shared/SubirArchivo";

export const ImportacionTuRecibo = ({ reloadData, setReloadData, setIsVisibleParent }) => {

    const [loading, setLoading] = useState(false);

    const [form, setForm] = useState({
        desde: moment('2020-01').format('YYYY-MM').toString(),
        hasta: moment().format('YYYY-MM').toString(),
        empresa_id: '9',
    });

    const handleSubmit = e => {
        e.preventDefault();

        const url = `/api/finiquitos/importar-tu-recibo`;
        const formData = new FormData();
        formData.append('tu-recibo', form.file);
        formData.append('empresa_id', form.empresa_id);

        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }

        setLoading(true);
        Axios.post(url, formData, config)
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
            })
    }

    return (
        <form onSubmit={handleSubmit}>
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
                        Importar
                    </button>
                </div>
            </div>
        </form>
    );
}
