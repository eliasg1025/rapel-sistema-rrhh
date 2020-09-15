import Axios from 'axios';
import React, { useState, useEffect } from 'react';
import { Bar } from 'react-chartjs-2';

export const GraficaBarras = () => {

    const [montosPorEstado, setMontosPorEstado] = useState({
        empresa: '',
        pagados: 0,
        para_pago: 0,
        firmados: 0,
        pendiente: 0,
        total: 0
    });

    const data = () => {
        return {
            labels: ['RAPEL', 'VERFRUT'],
            datasets: [
                {
                    label: ['Pagados'],
                    data: [montosPorEstado.pagados],
                },
                {
                    label: ['Firmados'],
                    data: [montosPorEstado.firmados]
                },
                {
                    label: ['Pendientes'],
                    data: [montosPorEstado.pendiente],
                    backgroundColor:  'rgb(1, 0, 102)',
                },
                {
                    label: ['Para Pago'],
                    data: [montosPorEstado.para_pago]
                }
            ]
        }
    }

    const options = () => {
        return {
            title: {
                display: true,
                text: `Montos (S/.) por estado de liquidación - ${montosPorEstado.empresa}`
            },
            scales: {
                yAxes: [{
                    //stacked: true,
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    //stacked: true,
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }

    useEffect(() => {
        Axios.get('/api/finiquitos/montos-por-estado?empresa_id=9')
            .then(res => {
                console.log(res);
                setMontosPorEstado(res.data);
            })
            .catch(err => {
                console.error(err);
            })
    }, []);

    return (
        <>
            <div className="row">
                <div className="col">

                </div>
            </div>
            <div className="row">
                <div className="col">
                    <Bar
                        data={data()} options={options()} height={100}
                    />
                </div>
            </div>
        </>
    );
}
