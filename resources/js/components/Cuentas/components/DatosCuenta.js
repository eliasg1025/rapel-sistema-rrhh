import React, {useEffect, useState} from 'react';
import { notification, Select } from "antd";

import { empresa } from '../../../data/default.json'

const DatosCuenta = ({ handleSubmit, form, setForm, bancos, setBancos, loadingSubmit }) => {
    const { cuenta } = JSON.parse(sessionStorage.getItem('data'));

    const [loadingBancos, setLoadingBancos] = useState(false);
    const [validForm, setValidForm] = useState(false);
    const [validNumeroCuenta, setValidNumeroCuenta] = useState(false);

    useEffect(() => {
        for (const key in form) {
            if (form[key] === '' && (form.apertura ? key !== 'numero_cuenta' : true)) {
                setValidForm(false);
                return;
            }
        }
        setValidForm(true);
    }, [form]);

    const validarNumeroCuenta = (numero_cuenta, banco_id) => {
        switch (banco_id) {
            case '59':
                return numero_cuenta.length === 14 && (
                    parseInt(numero_cuenta.charAt(numero_cuenta.length - 3)) === 0 ||
                    parseInt(numero_cuenta.charAt(numero_cuenta.length - 3)) === 1
                );
            case '03':
                return numero_cuenta.length === 13 && (
                    parseInt(numero_cuenta.substring(3, numero_cuenta.length - 1)) >= 100000000
                );
            case '38':
                return numero_cuenta.length >= 10 && numero_cuenta.length <= 20;
            case '09':
                return numero_cuenta.length === 10;
            case '11':
                return (numero_cuenta.length === 18 || numero_cuenta.length === 20 || numero_cuenta.length === 19) & (
                    numero_cuenta.substring(0, 4) === '0011'
                );
            default:
                return false;
        }
    }

    const formatNumeroCuenta = numero_cuenta => {
        let result = numero_cuenta.trim();
        result = result.replace(/[^\d]/g, "");
        return result;
    };

    useEffect(() => {
        setForm({
            ...form,
            numero_cuenta: formatNumeroCuenta(form.numero_cuenta)
        });
        const valido = validarNumeroCuenta(form.numero_cuenta, form.banco_id);
        setValidNumeroCuenta(valido);
        //console.log('Banco:', form.banco_id, ', Numero cuenta:', form.numero_cuenta, 'Valido:', valido);
    }, [form.numero_cuenta, form.banco_id]);

    useEffect(() => {
        let intentos = 0;
        function fetchBancos() {
            setLoadingBancos(true);
            intentos++;
            axios.get(`http://192.168.60.16/api/banco/${form.empresa_id}`)
                .then(res => {
                    const { data, message } = res.data;
                    let bancos_permitidos = [];
                    if (form.empresa_id == 14) {
                        bancos_permitidos = ['002', '003', '011'];
                    } else {
                        bancos_permitidos = ['002', '003', '011', '038', '009'];
                    }
                    const b = data.filter(item => {
                        return bancos_permitidos.includes(item.cod_equ);
                    });
                    setBancos(b);
                    setLoadingBancos(false);
                    // setForm({ ...form, banco_id: cuenta?.banco_id || '59' });
                })
                .catch(err => {
                    console.log(err);
                    if (intentos <= 5) {
                        fetchBancos();
                    } else {
                        notification['error']({
                            message: 'Fallo la conexión con la Base de datos SQL Server'
                        });
                    }
                });
        }

        if (form.empresa_id !== '') {
            fetchBancos();
        }
    }, [form.empresa_id]);

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="form-group col-md-6 col-lg-4">
                    Fecha Solicitud:<br />
                    <input
                        type="text" name="fecha_solicitud" placeholder="Fecha solicitud" readOnly={true}
                        className="form-control"
                        value={form.fecha_solicitud}
                        onChange={e => setForm({ ...form, fecha_solicitud: e.target.value })}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Empresa:<br />
                    <Select
                        value={form.empresa_id} showSearch
                        style={{ width: '100%' }} optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, empresa_id: e })}
                        size="small"
                    >
                        {empresa.map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id} - ${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Trabajador:<br />
                    <input
                        type="text" name="nombre_trabajador" placeholder="Trabajador"
                        className="form-control" readOnly={true} required
                        value={form.nombre_trabajador}
                    />
                    <input
                        type="text" name="rut" placeholder="DNI / RUT"
                        className="form-control d-none" readOnly={true} required
                        value={form.rut}
                    />
                </div>
            </div>
            <div className="row">
                <div className="form-group col-md-6 col-lg-4">
                    <div className="form-check mt-3">
                        <input
                            type="checkbox" name="nombre_trabajador" className="form-check-input"
                            id="checkboxEsApertura"
                            checked={form.apertura}
                            onChange={e => setForm({ ...form, apertura: e.target.checked })}
                        />
                        <label className="form-check-label" htmlFor="checkboxEsApertura">
                            Apertura de cuenta
                        </label>
                    </div>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Banco:<br />
                    <Select
                    loading={loadingBancos}
                        value={form.banco_id} showSearch
                        style={{ width: '100%' }} optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, banco_id: e })}
                        size="small"
                    >
                        {bancos.map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id} - ${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    {!form.apertura && (
                        <>
                            Número de Cuenta<br />
                            <input
                                type="text" name="numero_cuenta" placeholder="N° Cuenta"
                                autoComplete="off"
                                className={validNumeroCuenta ? "form-control is-valid" : "form-control is-invalid"}
                                value={form.numero_cuenta}
                                onChange={e => setForm({ ...form, numero_cuenta: e.target.value })}
                            />
                        </>
                    ) }
                </div>
            </div>
            <div className="row">
                <div className="col">
                    {loadingSubmit ? (
                        <div className="spinner-grow text-info"></div>
                    ) : (
                        <button
                            type="submit" className="btn btn-primary btn-block"
                            disabled={!(validForm && (!form.apertura ? validNumeroCuenta : true))}
                        >
                            Registrar
                        </button>
                    )}
                </div>
            </div>
        </form>
    );
};

export default DatosCuenta;
