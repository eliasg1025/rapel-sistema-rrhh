import React, { useState } from 'react';
import { DatePicker } from 'antd';
import moment from 'moment';

import { GraficoDocumentos } from './components/GraficoDocumentos';
import { BuscarTrabajador } from './components/BuscarTrabajador';

export const Home = () => {

    const [filter, setFilter] = useState({
        desde: moment().subtract(1, 'M').format('YYYY-MM-DD').toString(),
        hasta: moment().format('YYYY-MM-DD').toString(),
    });

    return (
        <>
            <h4>Estado de Documentos - TU RECIBO</h4>
            <br />
            <div className="row">
                <div className="col">
                    Consulta de documentos:<br />
                    <BuscarTrabajador />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col">
                    <GraficoDocumentos
                        filter={filter}
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-4">
                    <DatePicker.RangePicker
                        style={{ width: '100%' }}
                        placeholder={['Desde', 'Hasta']}
                        allowClear={false}
                        onChange={(date, dateString) => {
                            setFilter({
                                ...filter,
                                desde: dateString[0],
                                hasta: dateString[1],
                            });
                        }}
                        value={[moment(filter.desde), moment(filter.hasta)]}
                    />
                </div>
            </div>
        </>
    );
}
