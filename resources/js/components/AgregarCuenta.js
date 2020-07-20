import React, { useState, useEffect } from 'react';
import ReactDOM from "react-dom";
import moment from 'moment';
import Swal from 'sweetalert2';
import {notification} from "antd";

const AgregarCuenta = props => {
    const { usuario, empresas } = JSON.parse(props.props);

    const [bancos, setBancos] = useState([]);
    const [trabajador, setTrabajador] = useState(false);
    const [loadingBancos, setLoadingBancos] = useState(false);
    const [loadingSubmit, setLoadingSubmit] = useState(false);
    const [validForm, setValidForm] = useState(false);
    const [form, setForm] = useState({
        rut: '',
        nombre_trabajador: '',
        fecha_solicitud: moment().format('YYYY-MM-DD').toString(),
        empresa_id: '9',
        numero_cuenta: '',
        banco_id: '',
    });

    useEffect(() => {
        setLoadingBancos(true);
        let intentos = 0;
        function fetchBancos() {
            intentos++;
            axios.get(`http://192.168.60.16/api/banco/${form.empresa_id}`)
                    .then(res => {
                        const { data, message } = res.data;
                        const bancos_permitidos = ['002', '003', '011', '038', '043'];
                        const b = data.filter(item => {
                            return bancos_permitidos.includes(item.cod_equ);
                        });
                        setBancos(b);
                        setLoadingBancos(false);
                        setForm({ ...form, banco_id: '59' });
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
        fetchBancos();
    }, [form.empresa_id]);

    useEffect(() => {
        for (const key in form) {
            if (form[key] === '') {
                setValidForm(false);
                return;
            }
        }
        setValidForm(true);
    }, [form]);

    const handleSubmit = e => {
        e.preventDefault();
        const banco = bancos.find(e => e.id === form.banco_id);
        form.banco = banco;
        form.trabajador = trabajador;
        form.usuario_id = usuario.id;

        console.log(form);
        setLoadingSubmit(true);
        axios.post('/api/cuenta', {...form})
            .then(res => {
                console.log(res);
                if (res.status >= 400) {
                    Swal.fire({
                        title: 'Algo salió mal',
                        icon: 'error'
                    });
                    return;
                }
                const url = `/ficha/cambio-cuenta/${res.data.cuenta_id}`;

                Swal.fire({
                    title: 'Cuenta guardada correctamente',
                    icon: 'success'
                })
                    .then(() => {
                        window.open(url, '_blank');
                        location.reload();
                    });
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => {
                setLoadingSubmit(false);
            });
    }

    return (
        <div>
            <BuscarTrabajador
                form={form}
                setForm={setForm}
                setTrabajador={setTrabajador}
            />
            <hr />
            <form id="form-agregar-cuenta" onSubmit={handleSubmit}>
                <div className="row">
                    <div className="form-group col-md-6 col-lg-4">
                        <input
                            type="text" name="fecha_solicitud" placeholder="Fecha solicitud" readOnly={true}
                            className="form-control"
                            value={form.fecha_solicitud}
                            onChange={e => setForm({ ...form, fecha_solicitud: e.target.value })}
                        />
                    </div>
                    <div className="form-group col-md-6 col-lg-4">
                        <select
                            name="empresa_id" className="form-control" required
                            placeholder="Selecciona Empresa"
                            onChange={e => setForm({ ...form, empresa_id: e.target.value })}
                        >
                            {empresas.map(e => <option value={e.id} key={e.id}>{e.id} - {e.name}</option>)}
                        </select>
                    </div>
                    <div className="form-group col-md-6 col-lg-4">
                        <input
                            type="text" name="rut" placeholder="DNI / RUT"
                            className="form-control" readOnly={true} required
                            value={form.rut}
                        />
                    </div>
                </div>
                <div className="row">
                    <div className="form-group col-md-6 col-lg-4">
                        <input
                            type="text" name="nombre_trabajador" placeholder="Trabajador"
                            className="form-control" readOnly={true} required
                            value={form.nombre_trabajador}
                        />
                    </div>
                    <div className="form-group col-md-6 col-lg-4">
                        {loadingBancos ? (
                            <div className="spinner-grow text-info"></div>
                        ) : (
                            <select
                                name="banco_id" id="banco_id" className="form-control" placeholder="Selecciona Banco"
                                value={form.banco_id}
                                onChange={e => setForm({ ...form, banco_id: e.target.value })}
                            >
                                {bancos.map(e => <option value={e.id} key={e.id}>{e.id} - {e.name}</option>)}
                            </select>
                        )}
                    </div>
                    <div className="form-group col-md-6 col-lg-4">
                        <input
                            type="text" name="numero_cuenta" placeholder="N° Cuenta"
                            className="form-control"
                            value={form.numero_cuenta}
                            onChange={e => setForm({ ...form, numero_cuenta: e.target.value })}
                        />
                    </div>
                </div>
                <div className="row">
                    <div className="col">
                        {loadingSubmit ? (
                            <div className="spinner-grow text-info"></div>
                        ) : (
                            <button
                                type="submit" className="btn btn-primary btn-block"
                                disabled={!validForm}
                            >
                                Registrar
                            </button>
                        )}
                    </div>
                </div>
            </form>
        </div>
    )
};

const clearData = data => {
    for (const key in data) {
        if (data[key] === null || data[key] === undefined) {
            data[key] = '';
        }
    }
    return data;
};

const BuscarTrabajador = props => {
    const { form, setForm, setTrabajador } = props;
    const [rut, setRut] = useState('');

    const handleSubmit = e => {
        e.preventDefault();

        Swal.fire({
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        })

        axios.get(`http://192.168.60.16/api/trabajador/${rut}`)
                .then(res => {
                    const { trabajador } = res.data.data;

                    setForm({
                        ...form,
                        rut: trabajador.rut,
                        nombre_trabajador: `${trabajador.apellido_paterno} ${trabajador.apellido_materno}, ${trabajador.nombre}`
                    });
                    setTrabajador({ ...clearData(trabajador) });
                    Swal.fire({
                        title: 'Trabajador encontrado',
                        icon: 'success'
                    });
                })
                .catch(err => {
                    console.log(err);
                    setForm({
                        ...form,
                        rut: '',
                        nombre_trabajador: ''
                    });
                    Swal.fire({
                        title: 'No encontrado',
                        icon: 'warning'
                    });
                });
    };
    return (
        <form id="form-buscar-trabajador" onSubmit={handleSubmit}>
            <div className="row">
                <div className="input-group mb-3 col">
                    <input
                        type="text"
                        className="form-control"
                        name="_rut"
                        placeholder="Buscar por RUT"
                        value={rut}
                        onChange={e => setRut(e.target.value)}
                    />
                    <div className="input-group-append">
                        <button className="btn btn-outline-secondary" type="submit">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
    );
};

export default AgregarCuenta;

if (document.getElementById("agregar-cuenta")) {
    const element = document.getElementById("agregar-cuenta");
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<AgregarCuenta {...props} />, document.getElementById("agregar-cuenta"));
}
