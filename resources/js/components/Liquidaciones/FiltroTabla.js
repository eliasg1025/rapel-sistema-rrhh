import React, { useState } from 'react';
import { DatePicker } from 'antd';
import moment from 'moment';

export const FiltroTabla = ({ filtro, setFiltro, getData }) => {
    const handleSubmit = e => {
        e.preventDefault();
        getData();
    }

    return (
        <div className="card">
            <div className="card-body">
                <form onSubmit={handleSubmit}>
                    <div className="row">
                        <div className="form-group col-md-3">
                            Periodos:<br />
                            <DatePicker.RangePicker
                                allowClear={false}
                                style={{ width: '100%' }}
                                placeholder={['Desde', 'Hasta']}
                                picker="month"
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
                        <div className="form-group col-md-3">
                            Estado: <br />
                            <select className="form-control" onChange={e => setFiltro({ ...filtro, estado: e.target.value })}>
                                <option key={0} value={0}>PENDIENTE</option>
                                <option key={1} value={1}>FIRMADO</option>
                                <option key={2} value={2}>PARA PAGO</option>
                                <option key={3} value={3}>PAGADO</option>
                                <option key={4} value={4}>RECHAZADO</option>
                            </select>
                        </div>
                        <div className="form-group col-md-3">
                            Empresa: <br />
                            <select className="form-control" onChange={e => setFiltro({ ...filtro, empresa_id: e.target.value })}>
                                <option key={0} value={0}>TODAS</option>
                                <option key={9} value={9}>RAPEL</option>
                                <option key={14} value={14}>VERFRUT</option>
                            </select>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col">
                            <button type="submit" className="btn btn-primary">
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
}
