import React, { useState } from "react";
import { Steps, Button, notification } from "antd";

import { ReglasBono } from "./ReglasBono";
import { CondicionesPago } from "./CondicionesPago";
import { FinalizarConfigInicial } from "./FinalizarConfigInicial";
import Axios from "axios";

const { Step } = Steps;

export const PasosIniciales = ({ bono }) => {
    const [current, setCurrent] = useState(0);
    const [reload, setReload] = useState(false);
    const [reglas, setReglas] = useState([]);
    const [condicionPago, setCondicionPago] = useState(null);
    const [loading, setLoading] = useState(false);

    const steps = [
        {
            title: "Reglas y filtros",
            content: (
                <ReglasBono
                    bono={bono}
                    reload={reload}
                    setReload={setReload}
                    reglas={reglas}
                    setReglas={setReglas}
                />
            )
        },
        {
            title: "Pago",
            content: (
                <CondicionesPago
                    bono={bono}
                    condicionPago={condicionPago}
                    setCondicionPago={setCondicionPago}
                />
            )
        },
        {
            title: "Finalizar",
            content: <FinalizarConfigInicial bono={bono} reglas={reglas} />
        }
    ];

    const next = () => {
        setCurrent(current + 1);
    };

    const prev = () => {
        setCurrent(current - 1);
    };

    const done = () => {
        setLoading(true);
        Axios.put(`/api/bonos/${bono.id}`)
            .then(res => {
                const { message, data } = res.data;

                notification['success']({
                    message: message
                });

                setTimeout(() => {
                    location.reload();
                }, 1500);
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => setLoading(false));
    };

    return (
        <>
            <p>Configuración para el bono</p>
            <Steps current={current}>
                {steps.map(item => (
                    <Step key={item.title} title={item.title} />
                ))}
            </Steps>
            <div className="steps-content">{steps[current].content}</div>
            <div className="steps-action">
                {current < steps.length - 1 && (
                    <Button
                        type="primary"
                        onClick={() => next()}
                        size="small"
                        disabled={reglas.length === 0}
                    >
                        Siguiente
                    </Button>
                )}
                {current === steps.length - 1 && (
                    <Button type="primary" onClick={() => done()} size="small" loading={loading}>
                        TERMINAR
                    </Button>
                )}
                {current > 0 && (
                    <Button
                        style={{ margin: "0 8px" }}
                        onClick={() => prev()}
                        size="small"
                    >
                        Anterior
                    </Button>
                )}
            </div>
        </>
    );
};
