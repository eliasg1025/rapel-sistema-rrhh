import React from 'react';
import { Tag } from 'antd';
import { CheckCircleOutlined, ExclamationCircleOutlined, MinusCircleOutlined } from '@ant-design/icons';

export const Informacion = ({ periodos, alertas }) => {
    return (
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
                                <i className="fas fa-exclamation-triangle" /> SI TIENE
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
    );
}
