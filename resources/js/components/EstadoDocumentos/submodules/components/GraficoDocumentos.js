import React, { useState, createRef } from 'react';
import { Line } from 'react-chartjs-2'

import moment from 'moment';

export const GraficoDocumentos = ({ filter }) => {

    const [days, setDays] = useState([]);

    const chartRef = createRef();

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

    const data = canvas => {
        const ctx = canvas.getContext("2d");
        const gradient = ctx.createLinearGradient(0,0,100,0);

        return {
            backgroundColor: gradient
        }
    }

    const options = {
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

    window.onload = function() {
        const ctx = document.getElementById('docChart');

        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: getDates(filter.desde, filter.hasta),
                datasets: [
                    {
                        label: '# de Firmas BOLETAS',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor:  'rgba(255, 99, 132, 0.2)',
                        borderColor:  'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '# de Firmas PRORROGAS',
                        data: [5, 12, 5, 0, 0, 10],
                        backgroundColor:  'rgba(54, 162, 235, 0.2)',
                        borderColor:  'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
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
        });
    }

    return (
        <Line
            ref={chartRef}
            data={data}
            options={options}
        />
    );
}
