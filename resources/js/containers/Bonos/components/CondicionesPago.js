import React, { useEffect, useState } from 'react';
import { InputNumber, Select, Button, notification } from 'antd';
import Axios from 'axios';

export const CondicionesPago = ({ bono, condicionPago, setCondicionPago }) => {
    return (
        <>
            <p style={{ fontWeight: 'bold' }}>Establece las condiciones de pago para los trabajadores</p>
            <br />
            <DatosCondiciones bono={bono} condicionPago={condicionPago} setCondicionPago={setCondicionPago} />
        </>
    );
}

const DatosCondiciones = ({ bono, condicionPago, setCondicionPago }) => {

    const [loadingSave, setLoadingSave] = useState(false);
    const [form, setForm] = useState({
        variableUtilizada: '',
        valorBono: 0,
        valorDescuento: 0,
        condicion: '',
        valorMeta: 0,
        recuento: ''
    });

    useEffect(() => {
        Axios.get(`/api/bonos-condiciones-pagos/bono/${bono.id}`)
            .then(res => {
                const { data } = res.data;

                if (data) {
                    setForm({
                        variableUtilizada: data.variable_utilizada,
                        valorBono: data.valor_bono,
                        valorDescuento: data.valor_descuento,
                        condicion: data.condicion,
                        valorMeta: data.valor_meta,
                        recuento: data.recuento
                    });
                }
            })
            .catch(err => {
                console.error(err);
            });
    }, []);

    const handleSubmit = e => {
        e.preventDefault();

        setLoadingSave(true);
        Axios.post('/api/bonos-condiciones-pagos', {
            ...form,
            bonoId: bono.id
        })
            .then(res => {
                const { message } = res.data;
                notification['success']({
                    message: message
                });
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => setLoadingSave(false));
    }

    const variables = [
        {
            id: 'HoraNormales',
            name: 'HORAS'
        },
        {
            id: 'UnidadProducida',
            name: 'UNIDADES PRODUCIDAS'
        }
    ];

    const condiciones = [
        {
            id: '>',
            name: 'MAYOR QUE'
        },
        {
            id: '<',
            name: 'MENOR QUE'
        },
        {
            id: '=',
            name: 'IGUAL QUE'
        },
        {
            id: '>=',
            name: 'MAYOR O IGUAL QUE'
        },
        {
            id: '<=',
            name: 'MENOR O IGUAL QUE'
        },
    ];

    const recuentos = [
        {
            id: 'semanal',
            name: 'SEMANAL'
        },
        {
            id: 'quincenal',
            name: 'QUINCENAL'
        }
    ];

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="col-md-4">
                    Variable utilizada:<br />
                    <Select
                        style={{
                            width: "100%"
                        }}
                        value={form.variableUtilizada}
                        onChange={e => setForm({ ...form, variableUtilizada: e })}
                    >
                        {variables.map(item => (
                            <Select.Option value={item.id} key={item.id}>{item.name}</Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-2">
                    Condición:<br />
                    <Select
                        style={{
                            width: "100%"
                        }}
                        value={form.condicion}
                        onChange={e => setForm({ ...form, condicion: e })}
                    >
                        {condiciones.map(item => (
                            <Select.Option value={item.id} key={item.id}>{item.id}</Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-2">
                    Meta:<br />
                    <InputNumber
                        value={form.valorMeta}
                        onChange={e => setForm({ ...form, valorMeta: e })}
                        min={0}
                        step={0.5}
                        style={{ width: '100%' }}
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-2">
                    Valor Bono (+):<br />
                    <InputNumber
                        min={0}
                        step={0.5}
                        style={{ width: '100%' }}
                        formatter={value => `S/. ${value}`}
                        parser={value => value.replace('S/.', '')}
                        value={form.valorBono}
                        onChange={e => setForm({ ...form, valorBono: e })}
                    />
                </div>
                <div className="col-md-2">
                    Valor Descuento (-):<br />
                    <InputNumber
                        min={0}
                        step={0.5}
                        style={{ width: '100%' }}
                        formatter={value => `S/. ${value}`}
                        parser={value => value.replace('S/.', '')}
                        value={form.valorDescuento}
                        onChange={e => setForm({ ...form, valorDescuento: e })}
                    />
                </div>
                <div className="col-md-4">
                    Recuento:<br />
                    <Select
                        style={{
                            width: "100%"
                        }}
                        value={form.recuento}
                        onChange={e => setForm({ ...form, recuento: e })}
                    >
                        {recuentos.map(item => (
                            <Select.Option value={item.id} key={item.id}>{item.name}</Select.Option>
                        ))}
                    </Select>
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-12">
                    <Button
                        type="primary"
                        loading={loadingSave}
                        htmlType="submit"
                        size="small"
                        block
                    >
                        Guardar
                    </Button>
                </div>
            </div>
        </form>
    );
}
