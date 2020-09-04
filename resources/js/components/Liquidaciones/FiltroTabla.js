import React, { useState } from 'react';
import { DatePicker } from 'antd';
import moment from 'moment';

export const FiltroTabla = ({ filtro, setFiltro, getData }) => {
    const handleSubmit = e => {
        e.preventDefault();
        getData();
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="col-md-6">
                    <div className="card">
                        <div className="card-body">
                            <div className="row">
                                <div className="form-group col-md-6">
                                    Empresa: <br />
                                    <select className="form-control" onChange={e => setFiltro({ ...filtro, empresa_id: e.target.value })}>
                                        <option key={9} value={9}>RAPEL</option>
                                        <option key={14} value={14}>VERFRUT</option>
                                    </select>
                                </div>
                                <div className="form-group col-md-6">
                                    Estado: <br />
                                    <select className="form-control" onChange={e => setFiltro({ ...filtro, estado: e.target.value })}>
                                        <option key={0} value={0}>PENDIENTE</option>
                                        <option key={1} value={1}>FIRMADO</option>
                                        <option key={2} value={2}>PARA PAGO</option>
                                        <option key={3} value={3}>PAGADO</option>
                                        <option key={4} value={4}>RECHAZADO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="card">
                        <div className="card-body">
                            {parseInt(filtro.estado) == 0 && (
                                <div className="row">
                                    <div className="form-group col-md-6">
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
                                </div>
                            )}
                            {parseInt(filtro.estado) == 1 && (
                                <div className="row">
                                    <div className="form-group col-md-6">
                                        Fecha Firmado:<br />
                                        <DatePicker.RangePicker
                                            allowClear={false}
                                            style={{ width: '100%' }}
                                            placeholder={['Desde', 'Hasta']}
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
                            ) }
                            {parseInt(filtro.estado) == 2 && (
                                <div className="row">
                                    <div className="form-group col-md-6">
                                        Fecha Pago:<br />
                                        <DatePicker.RangePicker
                                            allowClear={false}
                                            style={{ width: '100%' }}
                                            placeholder={['Desde', 'Hasta']}
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
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    );
}
