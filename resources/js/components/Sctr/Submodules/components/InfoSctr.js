import React, { useEffect } from 'react';
import { Tag } from 'antd';

export const InfoSctr = ({ trabajador, contratos, sctr }) => {

    return (
        <div className="card">
            <div className="card-body">
                {contratos.length !== 0 ? (
                    <div className="d-flex">
                        <div className="p-2">
                            Activo: {contratos.length !== 0 ? (
                                <Tag color="success">
                                    <i className="far fa-check-circle"/> ACTIVO <b>{contratos[0].empresa_id == 9 ? 'RAPEL' : 'VERFRUT'}</b>
                                </Tag>
                            ) : (
                                <Tag color="error">
                                    <i className="fas fa-exclamation-triangle" /> NO ACTIVO
                                </Tag>
                            )}
                        </div>
                        <div className="p-2">
                            Tiene SCTR: {sctr ? (
                                <Tag color="success">
                                    <i className="far fa-check-circle"/> SI TIENE
                                </Tag>
                            ) : (
                                <Tag color="error">
                                    <i className="fas fa-exclamation-triangle" /> NO TIENE
                                </Tag>
                            )}
                        </div>
                    </div>
                ) : (
                    <div className="d-flex">
                        <div className="p-2">
                            Activo:&nbsp;
                            <Tag color="default">
                                -
                            </Tag>
                        </div>
                        <div className="p-2">
                            Tiene SCTR:&nbsp;
                            <Tag color="default">
                                -
                            </Tag>
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}
