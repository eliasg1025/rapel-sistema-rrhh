import React from 'react';
import { Tag } from 'antd';
import moment from 'moment';

export const Informacion = ({ periodos, alertas }) => {
    return (
        <>
            <div className="card">
                <div className="card-body">
                    <div className="d-flex">
                        <div className="p-2">
                            Estado: {periodos.length !== 0 ? (
                                periodos.reduce((a, p) => parseInt(p.indicador_vigencia) + a, 0) ? (
                                    <Tag color="error">
                                        <i className="fas fa-exclamation-triangle" /> ACTIVO
                                    </Tag>
                                ) : (
                                    <Tag color="success">
                                        <i className="far fa-check-circle"/> NO ACTIVO
                                    </Tag>
                                )
                            ) : (
                                <Tag color="default">
                                    -
                                </Tag>
                            )}
                        </div>
                        <div className="p-2">
                            Alertas: {alertas.length !== 0 ? (
                                <Tag color="error">
                                    <a data-toggle="modal" data-target="#verAlertas">
                                        <i className="fas fa-exclamation-triangle" /> SI TIENE
                                    </a>
                                </Tag>
                            ) : (
                                <Tag color="success">
                                    <i className="far fa-check-circle"/> NO TIENE
                                </Tag>
                            )}
                        </div>
                    </div>
                </div>
            </div>

            <div className="modal fade" id="verAlertas">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title">Alertas</h5>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <div className="list-group">
                                {alertas.map(a => (
                                    <a
                                        href="#"
                                        className="list-group-item list-group-item-action flex-column align-items-start"
                                        key={a.fecha}
                                    >
                                        <div className="d-flex w-100 justify-content-between">
                                            <h5 className="mb-1">{a.observacion}</h5>
                                            <small className="text-muted">{moment(a.fecha).format('YYYY-MM-DD')}</small>
                                        </div>
                                        <p className="">Empresa: {a.empresa_id} | Zona Labor: {a.zona_id}</p>
                                        <small className="text-muted">
                                            {a.digito === '1' ? (
                                                <Tag color="warning">
                                                    VIGENTE
                                                </Tag>
                                            ) : (
                                                <Tag color="success">
                                                    NO VIGENTE
                                                </Tag>
                                            )}
                                        </small>
                                    </a>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
