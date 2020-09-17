import React, { useState } from 'react';
import Axios from 'axios';

export const GenerarArchivoBanco = ({ d, data, filtro, reloadData, setReloadData, setIsVisibleParent, reloadDataAB, setReloadDataAB }) => {

    const [loading, setLoading] = useState(false);

    const generarArchivosBanco = () => {
        Swal.fire({
            title: 'Generando archivos',
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        setLoading(true);
        Axios.post('/api/finiquitos/generar-archivos-banco', { filtro, data })
            .then(res => {
                console.log(res);

                const { bcp, banbif, scotiabank, bbva, interbank } = res.data;

                setLoading(false);
                Swal.fire({
                    title: 'Proceso completado',
                    icon: 'info',
                    html: `
                        <ul>
                            <li><b>BCP: </b> ${bcp.message}</li>
                            <li><b>INTERBANK: </b> ${interbank.message}</li>
                            <li><b>BBVA: </b> ${bbva.message}</li>
                            <li><b>SCOTIABANK: </b> ${scotiabank.message}</li>
                            <li><b>BANBIF: </b> ${banbif.message}</li>
                        </ul>
                        <br />
                        <b>¿Desea pasar los registros al estado PAGADO?</b>
                    `,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar'
                })
                    .then(res => {
                        if (res.value) {
                            handleSubmit();
                        } else {
                            setIsVisibleParent(false);
                            setReloadDataAB(!reloadDataAB);
                        }
                    });
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
                Swal.fire('Error al actualizar el estado', '', 'error');
            });
    }

    const handleSubmit = () => {
        setLoading(true);
        Axios.put('/api/finiquitos/marcar-pagado-masivo', {
            data: d.map(e => e.id)
        })
            .then(res => {
                const { message } = res.data;

                setLoading(false);
                Swal.fire(message, '', 'success')
                    .then(res => {
                        setIsVisibleParent(false);
                        setReloadData(!reloadData);
                    });
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
                Swal.fire('Error al actualizar el estado', '', 'error');
            });
    }

    const obtenerMonto = arr => {
        const reducer = (p, c) => p + c.monto;
        const monto = arr.reduce(reducer, 0);

        return Math.round(monto * 100) / 100;
    }



    return (
        <form onSubmit={handleSubmit}>
            <div className="form-row">
                <div className="col m-auto">
                    <div className="table-responsive">
                        <table className="table table-borderless table-sm">
                            <thead className="thead-dark">
                                <tr>
                                    <th>Bancos</th>
                                    <th>Cantidad</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>BCP</td>
                                    <td>{data.bcp.length}</td>
                                    <td>{obtenerMonto(data.bcp)}</td>
                                </tr>
                                <tr>
                                    <td>INTERBANK</td>
                                    <td>{data.interbank.length}</td>
                                    <td>{obtenerMonto(data.interbank)}</td>
                                </tr>
                                <tr>
                                    <td>SCOTIABANK</td>
                                    <td>{data.scotiabank.length}</td>
                                    <td>{obtenerMonto(data.scotiabank)}</td>
                                </tr>
                                <tr>
                                    <td>BBVA</td>
                                    <td>{data.bbva.length}</td>
                                    <td>{obtenerMonto(data.bbva)}</td>
                                </tr>
                                <tr>
                                    <td>BANBIF</td>
                                    <td>{data.banbif.length}</td>
                                    <td>{obtenerMonto(data.banbif)}</td>
                                </tr>
                                <tr className="table-primary">
                                    <td>
                                        <b>TOTAL</b>
                                    </td>
                                    <td>
                                        <b>
                                        { data.banbif.length + data.bbva.length + data.bcp.length + data.scotiabank.length + data.interbank.length }
                                        </b>
                                    </td>
                                    <td className="">
                                        <b>
                                            {
                                                obtenerMonto(data.bcp) +
                                                obtenerMonto(data.interbank) +
                                                obtenerMonto(data.scotiabank) +
                                                obtenerMonto(data.bbva) +
                                                obtenerMonto(data.banbif)
                                            }
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div className="form-row">
                <div className="col text-center">
                    {(filtro.desde !== filtro.hasta) && <span style={{ fontWeight: 'bold', color: 'red' }}>Sólo se puede procesar 1 fecha de pago a la vez</span>}
                    <div className="btn-group" style={{ width: '100%' }}>
                        <button className="btn btn-primary" type="button" disabled={(filtro.desde !== filtro.hasta) || loading} onClick={generarArchivosBanco}>
                            {!loading ? 'Generar archivos' : (
                                <>
                                    <i className="fas fa-spinner fa-spin" />&nbsp;Cargando
                                </>
                            )}
                        </button>
                        {/*
                            <button className="btn btn-success" type="submit" disabled={filtro.desde !== filtro.hasta}>
                                {!loading ? 'Terminar proceso' : (
                                    <>
                                        <i className="fas fa-spinner fa-spin" />&nbsp;Cargando
                                    </>
                                )}
                            </button>
                         */}
                    </div>
                </div>
            </div>
        </form>
    );
}
