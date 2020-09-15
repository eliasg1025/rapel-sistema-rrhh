import Axios from 'axios';
import React, { useState, useEffect } from 'react';
import { Bar } from 'react-chartjs-2';

export const GraficaBarras = () => {

    const [montosPorEstadoRapel, setMontosPorEstadoRapel] = useState([]);
    const [montosPorEstadoVerfrut, setMontosPorEstadoVerfrut] = useState([]);

    const data = () => {
        return {
            labels: ['RAPEL', 'VERFRUT'],
            datasets: [
                {
                    label: ['No firmado'],
                    data: [montosPorEstadoRapel?.total, montosPorEstadoVerfrut?.total]
                }
            ]
        }
    }

    const options = () => {
        return {
            title: {
                display: true,
                text: 'Cantidades'
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
        Axios.get('/api/finiquitos/montos-por-estado')
            .then(res => {
                console.log(res);
                setMontosPorEstadoRapel(res.data[0]);
                setMontosPorEstadoVerfrut(res.data[1]);
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
