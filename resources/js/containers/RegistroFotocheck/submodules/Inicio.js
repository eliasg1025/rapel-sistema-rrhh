import React, { useState, useEffect } from 'react';
import moment from 'moment';
import Axios from 'axios';

import BuscarTrabajador from '../../shared/BuscarTrabajador';
import { TablaRegistros } from '../components';

const initialState = {
    nombre_completo: '',
    fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
    empresa_id: 9,
    numero_telefono_trabajador: '',
}

export const Inicio = () => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem("data"));

    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [form, setForm] = useState({...initialState});
    const [reloadDatos, setReloadDatos] = useState(false);

    return (
        <>
            <div className="mb-3">
                <h4>Registro de Fotochecks</h4>
            </div>
            <BuscarTrabajador
                setTrabajador={setTrabajador}
                setContratoActivo={setContratoActivo}
                activo={false}
            />
            <hr />
            <TablaRegistros

            />
        </>
    );
}
