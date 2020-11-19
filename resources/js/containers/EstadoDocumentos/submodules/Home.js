import React, { useState, useEffect } from 'react';
import { DatePicker, Select } from 'antd';
import moment from 'moment';
import Axios from 'axios';

import { GraficoDocumentos } from '../components/GraficoDocumentos';
import { BuscarTrabajador } from '../components/BuscarTrabajador';
import { GraficoBarrasDocumentos } from '../components/GraficoBarrasDocumentos';
import { MostrarUltimaActualizacion } from '../components';

import { empresa } from '../../../data/default.json';

export const Home = () => {

    return (
        <>
            <MostrarUltimaActualizacion />
            <h4>Estado de Documentos - TU RECIBO</h4>
            <GraficoDocumentos />
            <br />
            <hr />
            <br />
            <GraficoBarrasDocumentos />
        </>
    );
}
