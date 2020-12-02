import React, { useEffect, useState } from "react";
import { Button, Input, Select, Table, Spin, notification, Tooltip, Modal } from "antd";
import Axios from "axios";

export const ReglasBono = ({ bono, reglas, setReglas, reload, setReload }) => {

    return (
        <>
            <p style={{ fontWeight: 'bold' }}>Define a que trabajadores se les dará bono</p>
            <AgregarRegla bono={bono} reload={reload} setReload={setReload} />
            <br />
            <TablaReglas bono={bono} reload={reload} setReload={setReload} reglas={reglas} setReglas={setReglas} />
        </>
    );
};

const AgregarRegla = ({ bono, reload, setReload }) => {
    const [zonas, setZonas] = useState([]);
    const [variedades, setVariedades] = useState([]);
    const [unidadesMedidas, setUnidadesMedidas] = useState([]);
    const [labores, setLabores] = useState([]);
    const [cuarteles, setCuarteles] = useState([]);
    const [form, setForm] = useState({
        zonaId: 0,
        variedadId: 0,
        unidadMedidaId: 0,
        cuartelId: 0,
        laborId: 0,
        ciclo: "",
        rut: ""
    });

    const [loadingCreate, setLoadingCreate] = useState(false);

    useEffect(() => {
        Axios.get(`/api/zona-labor/${bono.empresa_id}`)
            .then(res => {
                setZonas(res.data);
            })
            .catch(err => {
                console.error(err);
            });

        Axios.get(`http://192.168.60.16/api/variedades/${bono.empresa_id}`)
            .then(res => {
                setVariedades(res.data.data);
            })
            .catch(err => {
                console.error(err);
            });

        Axios.get(
            `http://192.168.60.16/api/unidades-medidas/${bono.empresa_id}`
        )
            .then(res => {
                setUnidadesMedidas(res.data.data);
            })
            .catch(err => {
                console.error(err);
            });
    }, []);

    useEffect(() => {
        Axios.get(
            `http://192.168.60.16/api/labores/${bono.empresa_id}?unidadMedida=${form.unidadMedidaId}`
        )
            .then(res => {
                setLabores(res.data.data);
            })
            .catch(err => {
                console.error(err);
            });
    }, [form.unidadMedidaId]);

    useEffect(() => {
        Axios.get(`http://192.168.60.16/api/cuarteles/${bono.empresa_id}?zonaId=${form.zonaId}&variedadId=${form.variedadId}`)
            .then(res => {
                setCuarteles(res.data.data);
            })
            .catch(err => {
                console.error(err);
            })
    }, [form.zonaId, form.variedadId])

    const handleSubmit = e => {
        e.preventDefault();

        setLoadingCreate(true);
        Axios.post("/api/bonos-reglas", {
            ...form,
            bonoId: bono.id
        })
            .then(res => {
                const { data, message } = res.data;

                notification['success']({
                    message: message
                });

                setReload(!reload);
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => setLoadingCreate(false));
    };

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="col-md-4">
                    Zonas Labor:
                    <br />
                    <Select
                        value={form.zonaId}
                        showSearch
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, zonaId: e })}
                        style={{
                            width: "100%"
                        }}
                    >
                        <Select.Option value={0} key={0}>
                            TODOS
                        </Select.Option>
                        {zonas.map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id} - ${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Variedad:
                    <br />
                    <Select
                        value={form.variedadId}
                        showSearch
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, variedadId: e })}
                        style={{
                            width: "100%"
                        }}
                    >
                        <Select.Option value={0} key={0}>
                            TODOS
                        </Select.Option>
                        {variedades.map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id} - ${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Cuartel:
                    <br />
                    <Select
                        value={form.cuartelId}
                        showSearch
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, cuartelId: e })}
                        style={{
                            width: "100%"
                        }}
                    >
                        <Select.Option value={0} key={0}>
                            TODOS
                        </Select.Option>
                        {cuarteles.map(e => (
                            <Select.Option value={e.id} key={e.id}>
                                {`${e.id} - ${e.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Unidad de Medida:
                    <br />
                    <Select
                        value={form.unidadMedidaId}
                        showSearch
                        style={{ width: "100%" }}
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, unidadMedidaId: e })}
                    >
                        <Select.Option value={0} key={0}>
                            TODOS
                        </Select.Option>
                        {unidadesMedidas.map(item => (
                            <Select.Option key={item.id} value={item.id}>
                                {`${item.id} - ${item.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Labor:
                    <br />
                    <Select
                        value={form.laborId}
                        showSearch
                        style={{ width: "100%" }}
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            option.children
                                .toLowerCase()
                                .indexOf(input.toLowerCase()) >= 0
                        }
                        onChange={e => setForm({ ...form, laborId: e })}
                    >
                        <Select.Option value={0} key={0}>
                            TODOS
                        </Select.Option>
                        {labores.map(item => (
                            <Select.Option
                                key={`${item.id} - ${item.actividad_id}`}
                                value={`${item.id} - ${item.actividad_id}`}
                            >
                                {`${item.id} - ${item.actividad_id} - ${item.name}`}
                            </Select.Option>
                        ))}
                    </Select>
                </div>
                <div className="col-md-4">
                    Ciclo:
                    <br />
                    <Input
                        type="number"
                        value={form.ciclo}
                        onChange={e =>
                            setForm({ ...form, ciclo: e.target.value })
                        }
                    />
                </div>
                <br />
            </div>
            <div className="row">
                <div className="col-md-4">
                    RUT:
                    <input
                        className="form-control"
                        value={form.rut}
                        onChange={e => setForm({ ...form, rut: e.target.value })}
                    />
                </div>
            </div>
            <br />
            <div className="row">
                <div className="col-md-12">
                    <Button type="primary" htmlType="submit" size="small" block loading={loadingCreate}>
                        Agregar Regla
                    </Button>
                </div>
            </div>
        </form>
    );
};

const TablaReglas = ({ bono, reglas, setReglas, reload, setReload }) => {
    const [loading, setLoading] = useState(false);

    const confirmDelete = (record) => {
        Modal.confirm({
            title: 'Confirmar borrar regla',
            content: 'Este registro será eliminado',
            cancelText: 'Cancelar',
            okText: 'Si, borrarlo',
            onOk: () => deleteRegla(record.id)
        });
    }

    const deleteRegla = (id) => {
        Axios.delete(`/api/bonos-reglas/${id}`)
            .then(res => {
                const { message } = res.data;
                notification['success']({
                    message: message
                });
                setReload(!reload);
            })
            .catch(err =>  {
                console.error(err);
            })
    }

    const columns = [
        {
            title: 'Zona',
            dataIndex: 'zona_id'
        },
        {
            title: 'Variedad',
            dataIndex: 'variedad_id'
        },
        {
            title: 'Cuartel',
            dataIndex: 'cuartel_id'
        },
        {
            title: 'Unidad de Medida',
            dataIndex: 'unidad_medida_id'
        },
        {
            title: 'Labor',
            dataIndex: 'labor_id'
        },
        {
            title: 'Ciclo',
            dataIndex: 'ciclo'
        },
        {
            title: 'RUT',
            dataIndex: 'rut'
        },
        {
            title: 'Acciones',
            dataIndex: 'acciones',
            render: (_, record) => (
                <Tooltip title="Borrar regla">
                    <button className="btn btn-danger btn-sm" onClick={() => confirmDelete(record)}>
                        <i className="fas fa-trash"></i>
                    </button>
                </Tooltip>
            )
        },
    ];

    useEffect(() => {
        setLoading(true);
        Axios.get(`/api/bonos-reglas/bono/${bono.id}`)
            .then(res => {
                setReglas(res.data.data.map(i => {
                    return {
                        ...i,
                        key: i.id
                    }
                }));
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => setLoading(false));
    }, [reload]);

    return (
        <Spin spinning={loading}>
            <Table
                bordered
                size="small"
                scroll={{ x: 600 }}
                columns={columns}
                dataSource={reglas}
            />
        </Spin>
    );
};
