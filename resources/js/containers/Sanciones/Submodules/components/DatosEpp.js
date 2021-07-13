import React, { useState, useEffect } from 'react';
import { Button, Select } from 'antd';
import Axios from 'axios';

export const DatosEpp = props => {

    const { handleSubmit, form, setForm, empresas, zonasLabor, cuarteles } = props;

    const motivos = [
        'NO USA EPP(s)',
        'NO TRAJO EEP(s)',
        'NO REPORTAR TRABAJADOR SIN EPP(s)'
    ];

    const epps = [
        'LENTE DE SEGURIDAD',
        'GUANTES',
        'GORRO ARABE',
        'RESPIRADOR',
        'ZAPATOS DE SEGURIDAD',
        'CASCO',
        'MASCARILLA',
        //'OTRO'
    ];

    const [loading, setLoading] = useState(false);


    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="form-group col-md-6 col-lg-4">
                    Empresa: <br />
                    <select
                        type="text"
                        name="empresa_id"
                        placeholder="Empresa"
                        className="form-control"
                        value={form.empresa_id}
                        onChange={e =>
                            setForm({ ...form, empresa_id: e.target.value })
                        }
                    >
                        <option value="" key="0" disabled />
                        {empresas.map(e => (
                            <option value={e.id} key={e.id}>
                                {e.id} - {e.name}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Fecha Incidencia: <br />
                    <input
                        type="date"
                        name="fecha_incidencia"
                        className="form-control"
                        value={form.fecha_incidencia}
                        onChange={e =>
                            setForm({
                                ...form,
                                fecha_incidencia: e.target.value
                            })
                        }
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    Trabajador: <br />
                    <input
                        type="text"
                        name="nombre_completo"
                        placeholder="Trabajador"
                        readOnly={true}
                        className="form-control"
                        value={form.nombre_completo}
                        onChange={e =>
                            setForm({
                                ...form,
                                nombre_completo: e.target.value
                            })
                        }
                    />
                </div>
                <div className="form-group col-md-6 col-lg-6">
                    Zona labor:
                    <br />
                    <Select
                        value={form.zona_labor_id}
                        showSearch
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setForm({ ...form, zona_labor_id: e })
                        }
                        size="small"
                        style={{
                            width: "100%"
                        }}
                    >
                        {zonasLabor.map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id} - ${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="form-group col-md-6 col-lg-6">
                    Área/Campo:
                    <br />
                    <Select
                        value={form.cuartel_id}
                        showSearch
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setForm({ ...form, cuartel_id: e })
                        }
                        size="small"
                        style={{
                            width: "100%"
                        }}
                    >
                        {cuarteles.map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id} - ${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="form-group col-md-6 col-lg-6">
                    Motivo(s):
                    <br />
                    <Select
                        value={form.motivo}
                        showSearch
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e =>
                            setForm({ ...form, motivo: e })
                        }
                        style={{
                            width: "100%"
                        }}
                    >
                        {motivos.map(e => (
                            <Select.Option value={e} key={e}>
                                {`${e}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                {form.motivo !== 'NO REPORTAR TRABAJADOR SIN EPP(s)' && (
                    <div className="form-group col-md-6 col-lg-6">
                        EPP(s):<br />
                        <Select
                            mode="tags"
                            allowClear
                            style={{ width: '100%' }}
                            value={form.epps}
                            onChange={e =>
                                setForm({ ...form, epps: e })
                            }
                        >
                            {epps.map(e => (
                                <Select.Option value={e} key={e}>
                                    {e}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                )}
                <div className="form-group col-md-12">
                    Observación:
                    <br />
                    <textarea
                        className="form-control"
                        value={form.observacion}
                        onChange={e =>
                            setForm({ ...form, observacion: e.target.value })
                        }
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col">
                    <Button
                        htmlType="submit"
                        loading={loading}
                        block
                        type="primary"
                        disabled={
                            form.empresa_id === "" ||
                            form.nombre_completo === "" ||
                            form.motivo === ''
                        }
                    >
                        Registrar
                    </Button>
                </div>
            </div>
        </form>
    );
}
