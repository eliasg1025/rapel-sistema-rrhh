import React, { useState, useEffect } from 'react';
import { DatePicker } from 'antd';
import moment from 'moment';
import Axios from 'axios';

export const Main = () => {

    const [filtro, setFiltro] = useState({
        desde: moment('2020-01').format('YYYY-MM').toString(),
        hasta: moment().format('YYYY-MM').toString(),
    });

    const handleSincronizar = () => {
        console.log('sincronizar');
    }

    const handleExportar = () => {
        console.log('Exportar');
    }

    const handleImportar = () => {
        console.log('importar');
    }

    return (
        <>
            <h3>Pagos de Liquidaciones y Utilidades</h3>
            <br />
            <div className="card">
                <div className="card-body d-flex">
                    <DatePicker.RangePicker
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
                    <button className="btn btn-primary" onClick={handleSincronizar}>
                        Sincronizar
                    </button>
                </div>
            </div>
            <br />
            <div className="card">
                <div className="card-body">
                    <button className="btn btn-outline-primary" onClick={handleExportar}>
                        Exportar SQL Server
                    </button>
                    <button className="btn btn-outline-primary" onClick={handleImportar}>
                        Importar MySQL
                    </button>
                </div>
            </div>
        </>
    );
}
