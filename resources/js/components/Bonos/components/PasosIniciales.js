import React, { useState } from 'react';
import { Steps, Button } from 'antd';

import { ReglasBono } from './ReglasBono';
import { CondicionesPago } from './CondicionesPago';

const { Step } = Steps;

export const PasosIniciales = ({ bono }) => {
    const [current, setCurrent] = useState(0);


    const steps = [
        {
            title: 'Reglas y filtros',
            content: <ReglasBono bono={bono} />,
        },
        {
            title: 'Pago',
            content: <CondicionesPago />,
        },
        {
            title: 'Finalizar',
            content: 'finalizar',
        },
    ];

    const next = () => {
        setCurrent(current + 1);
    }

    const prev = () => {
        setCurrent(current - 1);
    }

    const done = () => {
        Axios.post('/api/bonos', {})
            .then(res => {
                const { message, data } = res.data;

                setBono(data);
            })
            .catch(err => {
                console.error(err);
            });
    }

    return (
        <>
            <p>Configuración inicial para el Bono</p>
            <Steps current={current}>
                {
                    steps.map(item => (
                        <Step key={item.title} title={item.title} />
                    ))
                }
            </Steps>
            <div className="steps-content">
                {steps[current].content}
            </div>
            <div className="steps-action">
                {current < steps.length - 1 && (
                    <Button type="primary" onClick={() => next()} size="small">
                        Siguiente
                    </Button>
                )}
                {current === steps.length - 1 && (
                    <Button type="primary" onClick={() => done()} size="small">
                        TERMINAR
                    </Button>
                )}
                {current > 0 && (
                    <Button style={{ margin: '0 8px' }} onClick={() => prev()} size="small">
                        Anterior
                    </Button>
                )}
            </div>
        </>
    );
}
