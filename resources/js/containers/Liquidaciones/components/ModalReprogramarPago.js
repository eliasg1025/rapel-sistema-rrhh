import React, { useState } from 'react';
import Modal from '../../Modal';
import moment from 'moment';
import Axios from 'axios';
import { DatePicker, message } from 'antd';

export const ModalRepogramarPago = ({ liquidacion, isVisible, setIsVisible, reloadData, setReloadData }) => {

    const [form, setForm] = useState({
        fecha_pago: liquidacion?.fecha_pago || moment().format('YYYY-MM-DD').toString()
    });

    const handleSubmit = e => {
        e.preventDefault();

        Axios.put(`/api/pagos/programar-para-pago/reprogramar`, {
            id: liquidacion.id,
            fecha_pago: form.fecha_pago,
            tipo_pago_id: liquidacion.tipo_pago === 'LIQUIDACION' ? 1 : 2
        })
            .then(res => {
                message['success']({
                    content: res.data.message
                });
                setIsVisible(false);
                setReloadData(!reloadData);
            })
            .catch(err => {
                console.error(err);
            });
    }

    return (
        <Modal
            isVisible={isVisible}
            setIsVisible={setIsVisible}
            title="Reprogramar Fecha de Pago"
        >
            <form onSubmit={handleSubmit}>
                <div className="form-row">
                    <div className="col-md-6">
                        RUT:<br />
                        <input
                            className="form-control" value={liquidacion?.rut || ''}
                            readOnly={true}
                        />
                    </div>
                    <div className="col-md-6">
                        Trabajador:<br />
                        <input
                            className="form-control" value={`${liquidacion?.apellido_paterno || ''} ${liquidacion?.apellido_materno || ''} ${liquidacion?.nombre || ''}`}
                            readOnly={true}
                        />
                    </div>
                </div>
                <div className="form-row">
                    <div className="col-md-6">
                        Fecha de Pago:<br />
                        <input
                            type="date" className="form-control" value={form.fecha_pago}
                            onChange={e => setForm({ ...form, fecha_pago: e.target.value })}
                        />
                    </div>
                    <div className="col-md-6">
                        Tipo Pago:<br />
                        <input
                            className="form-control" value={`${liquidacion?.tipo_pago}`}
                            readOnly={true}
                        />
                    </div>
                </div>
                <br />
                <div className="form-row">
                    <div className="col">
                        <button className="btn btn-success btn-block">
                            Reprogramar
                        </button>
                    </div>
                </div>
            </form>
        </Modal>
    );
}
