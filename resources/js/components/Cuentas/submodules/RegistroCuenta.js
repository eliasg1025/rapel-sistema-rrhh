import React, { useState, useEffect } from "react";

import DatosCuenta from "../components/DatosCuenta";
import moment from "moment";
import Swal from "sweetalert2";
import { TablaCuentas } from "../components/TablaCuentas";
import { BusquedaTrabajador } from "../components/BusquedaTrabajador";
import Axios from "axios";

export const RegistroCuenta = () => {
    const { usuario, editar, submodule } = JSON.parse(
        sessionStorage.getItem("data")
    );
    const initialState = {
        rut: "",
        nombre_trabajador: "",
        fecha_solicitud: moment()
            .format("YYYY-MM-DD")
            .toString(),
        empresa_id: 9,
        numero_cuenta: "",
        banco_id: "",
        apertura: false
    };

    const [bancos, setBancos] = useState([]);
    const [trabajador, setTrabajador] = useState(null);
    const [contratoActivo, setContratoActivo] = useState(null);
    const [loadingSubmit, setLoadingSubmit] = useState(false);
    const [reloadData, setReloadData] = useState(false);

    const [form, setForm] = useState(initialState);

    useEffect(() => {
        if (editar) {
            let intentos = 0;
            function fetchCuenta() {
                intentos++;
                Axios.get(`/api/cuenta/${editar}`)
                    .then(res => {
                        console.log(res.data);

                        const { data } = res;
                        setForm({ ...data, numero_cuenta: data.numero_cuenta || '' });
                    })
                    .catch(err => {
                        if (intentos < 3) {
                            fetchCuenta();
                        }
                    })
            }

            fetchCuenta();
        }
    }, []);

    const handleSubmit = e => {
        e.preventDefault();
        const banco = bancos.find(e => e.id == form.banco_id);
        form.banco = banco;
        form.trabajador = trabajador;
        form.usuario_id = usuario.id;

        console.log(form);
        setLoadingSubmit(true);
        axios
            .post("/api/cuenta", { ...form })
            .then(res => {
                console.log(res);
                if (res.status >= 400) {
                    Swal.fire({
                        title: "Algo salió mal",
                        icon: "error"
                    });
                    return;
                }

                if (res.data.cuenta_id != 0) {
                    const url = `/ficha/cambio-cuenta/${res.data.cuenta_id}`;

                    Swal.fire({
                        title: "Cuenta guardada correctamente",
                        icon: "success"
                    }).then(() => {
                        window.open(url, "_blank");
                        setReloadData(!reloadData);
                        setForm(initialState);
                    });
                } else {
                    Swal.fire({
                        title: "Cuenta guardada correctamente",
                        icon: "success"
                    }).then(() => {
                        setReloadData(!reloadData);
                        setForm(initialState);
                    });
                }
            })
            .catch(err => {
                console.log(err, err.response);
                if (err.response.status < 500) {
                    Swal.fire({
                        title: err.response.data.error,
                        icon: "error"
                    });
                    return;
                }
            })
            .finally(() => {
                setLoadingSubmit(false);
            });
    };

    return (
        <>
            <div className="mb-3">
                <h4>
                    Cuentas{" "}
                    <small>
                        {usuario.cuentas === 2 ? "(Modo Administrador)" : ""}
                    </small>
                </h4>
            </div>
            {!editar && (
                <BusquedaTrabajador
                    form={form}
                    setForm={setForm}
                    setTrabajador={setTrabajador}
                />
            )}
            <DatosCuenta
                handleSubmit={handleSubmit}
                form={form}
                setForm={setForm}
                bancos={bancos}
                setBancos={setBancos}
                loadingSubmit={loadingSubmit}
            />
            <hr />
            <br />
            {!editar && (
                <TablaCuentas
                    reloadData={reloadData}
                    setReloadData={setReloadData}
                />
            )}
        </>
    );
};
