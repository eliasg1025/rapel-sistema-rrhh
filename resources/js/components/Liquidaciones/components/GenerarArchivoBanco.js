import React from 'react';
import Axios from 'axios';

export const GenerarArchivoBanco = ({ d, data, filtro, reloadData, setReloadData, setIsVisibleParent, reloadDataAB, setReloadDataAB }) => {

    const generarArchivosBanco = () => {
        Axios.post('/api/finiquitos/generar-archivos-banco', { filtro, data })
            .then(res => {
                console.log(res);
            })
            .catch(err => {
                console.error(err);
            });
    }

    const handleSubmit = e => {
        e.preventDefault();
        Axios.put('/api/finiquitos/marcar-pagado-masivo', {
            data: d.map(e => e.id)
        })
            .then(res => {
                console.log(res);
            })
            .catch(err => {
                console.error(err);
            });
    }

    const reducer = (p, c) => p + c.monto;

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
                                    <td>{data.bcp.reduce(reducer, 0)}</td>
                                </tr>
                                <tr>
                                    <td>INTERBANK</td>
                                    <td>{data.interbank.length}</td>
                                    <td>{data.interbank.reduce(reducer, 0)}</td>
                                </tr>
                                <tr>
                                    <td>SCOTIABANK</td>
                                    <td>{data.scotiabank.length}</td>
                                    <td>{data.scotiabank.reduce(reducer, 0)}</td>
                                </tr>
                                <tr>
                                    <td>BBVA</td>
                                    <td>{data.bbva.length}</td>
                                    <td>{data.bbva.reduce(reducer, 0)}</td>
                                </tr>
                                <tr>
                                    <td>BANBIF</td>
                                    <td>{data.banbif.length}</td>
                                    <td>{data.banbif.reduce(reducer, 0)}</td>
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
                                                data.bcp.reduce(reducer, 0) +
                                                data.interbank.reduce(reducer, 0) +
                                                data.scotiabank.reduce(reducer, 0) +
                                                data.bbva.reduce(reducer, 0) +
                                                data.banbif.reduce(reducer, 0)
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
                        <button className="btn btn-primary" type="button" disabled={filtro.desde !== filtro.hasta} onClick={generarArchivosBanco}>
                            Generar archivos
                        </button>
                        <button className="btn btn-success" type="submit" disabled={filtro.desde !== filtro.hasta}>
                            Terminar proceso
                        </button>
                    </div>
                </div>
            </div>
        </form>
    );
}
