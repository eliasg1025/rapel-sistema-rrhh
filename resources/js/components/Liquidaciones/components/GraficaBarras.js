import Axios from 'axios';
import React, { useState, useEffect } from 'react';
import { Bar } from 'react-chartjs-2';

export const GraficaBarras = () => {

    const [montosPorEstado, setMontosPorEstado] = useState({});

    const data = () => {
        return {
            labels: ['Pendientes', 'Firmados', 'Para Pago', 'Pagados'],
            datasets: [
                {
                    label: ['Pendientes'],
                    data: [montosPorEstado?.rapel?.pendiente || 0, montosPorEstado?.verfrut?.pendiente || 0],
                    backgroundColor:  'rgba(1,0,102,0.7)',
                    //yAxisID: 'y-axis-pendientes'
                },
                {
                    label: ['Firmados'],
                    data: [montosPorEstado?.rapel?.firmados || 0, montosPorEstado?.verfrut?.firmados || 0],
                    backgroundColor:  'rgba(204,51,0,0.7)',
                    //yAxisID: 'y-axis-firmados'
                },
                {
                    label: ['Para Pago'],
                    data: [montosPorEstado?.rapel?.para_pago || 0, montosPorEstado?.verfrut?.para_pago || 0],
                    backgroundColor:  'rgba(244,180,0,0.7)',
                    //yAxisID: 'y-axis-para-pago'
                },
                {
                    label: ['Pagados'],
                    data: [montosPorEstado?.rapel?.pagados || 0, montosPorEstado?.verfrut?.pagados || 0],
                    backgroundColor:  'rgba(64,203,10,0.7)',
                    //yAxisID: 'y-axis-pagados'
                },
            ]
        }
    }

    const options = () => {
        return {
            title: {
                display: true,
                text: `Montos (S/.) por estado de liquidación`
            },
            scales: {
                yAxes: [

                ],
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
                <div className="col-md-6">
                    <Bar
                        data={data()} options={options()} height={200}
                    />
                </div>
            </div>
        </>
    );
}
