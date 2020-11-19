import React, { useState, useEffect } from 'react';
import { Table } from 'antd';
import Axios from 'axios';
import moment from 'moment';
import Swal from 'sweetalert2';

export const ArchivosAprobacion = () => {

    const [loading, setLoading] = useState(false);
    const [fechasPagos, setFechasPagos] = useState([]);

    useEffect(() => {
        Axios.get('/api/pagos/fechas-pagos')
            .then(res => {
                //console.log(res);
                setFechasPagos(res.data);
            })
            .catch(err => {
                console.error(err);
            })
    }, []);

    const descargarArchivoBanco = fecha_pago => {
        console.log(fecha_pago);
        setLoading(true);

        Axios({
            url: `/api/finiquitos/fechas-pagos/descargar`,
            data: { fecha_pago },
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {

                setLoading(false);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `APROBACION-PAGO-REMUNERACIONES-VEFRUT-PERU-${moment(fecha_pago).format('DDMMYYYY')}.xlsx`
                link.click();
            })
            .catch(err => {
                console.log(err);

                setLoading(false);
                Swal.fire('Error al generar el archivo', 'Verifique la consola', 'error');
            });
    }

    const columns = [
        {
            title: 'Fecha Pago',
            dataIndex: 'fecha_pago'
        },
        {
            title: 'Descargar',
            dataIndex: 'descargar',
            render: (_, record) => (
                <a className="btn btn-light btn-sm" href={`/storage/formato-aprobacion/generados/FORMATO-APROBACION_${record.fecha_pago}.xlsx`} target="_blank">
                    <i className="fas fa-download"></i>
                </a>
            )
        }
    ];

    return (
        <>
            <div className="row">
                <div className="col">
                    <h5>Formatos de Aprobación:</h5>
                    <Table
                        columns={columns} dataSource={fechasPagos}
                        size="small"
                        scroll={{ x: 500 }}
                        loading={loading}
                    />
                </div>
            </div>
        </>
    );
}
