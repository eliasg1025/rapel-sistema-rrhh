import React, { useState, useEffect } from 'react';
import { Line } from 'react-chartjs-2'

import moment from 'moment';
import Axios from 'axios';

export const GraficoDocumentos = ({ filter }) => {

    const [dias, setDias] = useState([]);
    const [firmasBoletas, setFirmasBoletas] = useState([]);
    const [firmasProrrogas, setFirmasProrrogas] = useState([]);

    const getDates = (startDate, stopDate) => {
        var dateArray = [];
        var currentDate = moment(startDate);
        var stopDate = moment(stopDate);
        while (currentDate <= stopDate) {
            dateArray.push( moment(currentDate).format('YYYY-MM-DD') )
            currentDate = moment(currentDate).add(1, 'days');
        }
        return dateArray;
    }

    const data = () => {
        return {
            labels: dias,
            datasets: [
                {
                    label: '# de Firmas BOLETAS',
                    data: firmasBoletas,
                    backgroundColor:  'rgba(54, 162, 235, 0.2)',
                    borderColor:  'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                },
                {
                    label: '# de Firmas PRORROGAS',
                    data: firmasProrrogas,
                    backgroundColor:  'rgba(255, 99, 132, 0.2)',
                    borderColor:  'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        }
    }

    const options = () => {
        return {
            title: {
                display: true,
                text: 'Cantidad de firmas por día'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }

    useEffect(() => {
        Axios.get(`/api/documentos-turecibo/cantidad-firmados-dia?tipo_documento_turecibo_id=${2}&desde=${filter.desde}&hasta=${filter.hasta}&empresa_id=${filter.empresa_id}&regimen_id=${filter.regimen_id}&zona_labor_id=${filter.zona_labor_id}`)
            .then(res => {
                const { dias, cantidades } = res.data;

                setDias(dias);
                setFirmasBoletas(cantidades);
            })
            .catch(err => console.error(err))

        Axios.get(`/api/documentos-turecibo/cantidad-firmados-dia?tipo_documento_turecibo_id=${1}&desde=${filter.desde}&hasta=${filter.hasta}&empresa_id=${filter.empresa_id}&regimen_id=${filter.regimen_id}&zona_labor_id=${filter.zona_labor_id}`)
            .then(res => {
                const { dias, cantidades } = res.data;

                setFirmasProrrogas(cantidades);
            })
            .catch(err => console.error(err))
    }, [filter]);

    return (
        <Line data={data()} options={options()} height={100} />
    )
}
