import React, { useState, useEffect } from 'react';
import ReactDOM from "react-dom";
import moment from 'moment';
import Swal from 'sweetalert2';
import {notification} from "antd";
import DatosCuenta from "./DatosCuenta";

const EditarCuenta = props => {
    const { empresas } = JSON.parse(sessionStorage.getItem('data'));
    const { cuenta } = props;

    const [loadingSubmit, setLoadingSubmit] = useState(false);
    const [bancos, setBancos] = useState([]);
    const [form, setForm] = useState({
        rut: '',
        nombre_trabajador: '',
        fecha_solicitud: '',
        empresa_id: '9',
        numero_cuenta: '',
        banco_id: '',
    });

    const handleSubmit = () => {
        console.log('submit');
    }

    return (
        <DatosCuenta
            handleSubmit={handleSubmit}
            form={form}
            setForm={setForm}
            bancos={bancos}
            setBancos={setBancos}
            empresas={empresas}
            loadingSubmit={loadingSubmit}
        />
    );
};

export default EditarCuenta;
