import React, {useEffect, useState} from 'react';
import { Steps, Button } from 'antd';
import Axios from 'axios';

import { empresa } from '../../../data/default.json';

const { Step } = Steps;

export const Bono = () => {

    const { usuario } = JSON.parse(sessionStorage.getItem("data"));

    const [form, setForm] = useState({
        empresaId: '',
        zonasIds: [],
        laboresIds: [],
        cuartelesIds: [],
        name: '',
        descripcion: '',
    });
    const [zonas, setZonas] = useState([]);

    useEffect(() => {
        if (form.empresaId) {
            Axios.get(`/api/zona-labor/${form.empresaId}`)
                .then(res => {
                    setZonas(res.data);
                })
                .catch(err => console.error(err));
        }
    }, [form.empresaId]);

    const steps = [
        {
            title: 'Filtro',
            content: 'filtro',
        },
        {
            title: 'Condiciones',
            content: 'condiciones',
        },
        {
            title: 'Finalizar',
            content: 'finalizar',
        },
    ];

    // Step page
    const [current, setCurrent] = useState(0);
    // Data state

    const next = () => {
        setCurrent(current + 1);
    }

    const prev = () => {
        setCurrent(current - 1 );
    }

    const done = () => {
        Axios.post('/api/bonos', {})
            .then(res => {
                const { message, data } = res.data;

                console.log(data);
            })
            .catch(err => {
                console.error(err);
            });
    }

    return (
        <>
            <h4>Bono</h4>
            <br />
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
