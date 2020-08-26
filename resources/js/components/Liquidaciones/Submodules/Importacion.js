import React, { useEffect, useState } from 'react';
import { DatePicker } from "antd";
import moment from 'moment';

export const Importacion = () => {

    const [form, setForm] = useState({
        desde: moment().format('YYYY-MM').toString(),
        hasta: moment().format('YYYY-MM').toString(),
        empresa_id: '9',
    });

    const handleSubmit = e => {
        e.preventDefault();
        console.log(e);
    }

    return (
        <>
            <div className="card">
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="form-row">
                            <div className="col-md-3">
                                <div className="form-group">
                                    <DatePicker.RangePicker
                                        style={{ width: '100%' }}
                                        allowClear={false}
                                        placeholder={['Desde', 'Hasta']}
                                        picker="month"
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
                            <div className="col-md-3">
                                <div className="form-group">
                                    <select
                                        value={form.empresa_id}
                                        onChange={e => setForm({
                                            ...form,
                                            empresa_id: e.target.value
                                        })}
                                        className="form-control"
                                    >
                                        <option key="9" value="9">RAPEL</option>
                                        <option key="14" value="14">VERFRUT</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}
