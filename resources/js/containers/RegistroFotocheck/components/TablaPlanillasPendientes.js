import React, { useState } from "react";
import { Table, Button, notification, Tooltip } from "antd";
import Modal from "../../Modal";
import Axios from "axios";

export const TablaPlanillasPendientes = ({
    data,
    loading,
    reload,
    setReload
}) => {
    const initialFormState = {
        fecha_planilla: '',
        hora_entrada: '',
        hora_salida: '',
    };

    const [viewModal, setViewModal] = useState(false);
    const [activeRecord, setActiveRecord] = useState(null);
    const [form, setForm] = useState(initialFormState);
    const [planillas, setPlanillas] = useState([]);

    const edit = record => {
        console.log(record);
        setViewModal(true);
        setActiveRecord(record);
        setForm(initialFormState);
        setPlanillas([]);
    };

    const columns = [
        {
            title: "DNI",
            dataIndex: "trabajador",
            render: item => item?.rut
        },
        {
            title: "Trabajador",
            dataIndex: "trabajador",
            render: item =>
                item?.apellido_paterno +
                " " +
                item?.apellido_materno +
                " " +
                item?.nombre
        },
        /* {
            title: "Estado",
            dataIndex: "estado",
            render: item =>
                item === 0 ? (
                    <Tag color="blue">GENERADO</Tag>
                ) : (
                    <Tag color="green">GUARDADO</Tag>
                )
        }, */
        {
            title: "Acciones",
            dataIndex: "id",
            render: (_, record) => (
                <>
                    <Tooltip title="Asignar Fecha">
                        <button
                            className="btn btn-primary btn-sm"
                            onClick={() => edit(record)}
                        >
                            <i className="fas fa-calendar-plus"></i>
                        </button>
                    </Tooltip>
                    <Tooltip title="Eliminar Registro">
                        <button className="btn btn-danger btn-sm">
                            <i className="fas fa-trash"></i>
                        </button>
                    </Tooltip>
                </>
            )
        }
    ];

    const handleAgregarFecha = () => {
        const exist = planillas.findIndex(planilla => planilla.fecha_planilla === form.fecha_planilla);
        if (exist !== -1) {
            notification['warning']({
                message: 'No puede ingresar la misma fecha 2 veces',
            });
            return;
        }

        setPlanillas([...planillas, { ...form, key: form.fecha_planilla }]);
        setForm(initialFormState);
        return;
    }

    const handleTerminar = () => {

        Axios.put(`/api/planillas-manuales/${activeRecord.id}`, { fechas: planillas })
            .then(res => {
                notification['success']({
                    message: res.data.message
                });

                setReload(!reload);
                setViewModal(false);
                setForm(initialFormState);
                setPlanillas([]);
            })
            .catch(err => {
                console.log(err);
                notification['error']({
                    message: err.response.data.message
                });
            });
    }

    return (
        <>
            <Table
                size="small"
                bordered
                columns={columns}
                dataSource={data}
                loading={loading}
            />
            <Modal
                isVisible={viewModal}
                setIsVisible={setViewModal}
                title="Asignar fecha"
                width={760}
            >
                <div className="row">
                    <div className="col-md-4">
                        RUT:
                        <br />
                        <input
                            className="form-control"
                            value={activeRecord?.trabajador.rut}
                            readOnly
                        />
                    </div>
                    <div className="col-md-8">
                        Trabajador:
                        <br />
                        <input
                            className="form-control"
                            value={`${activeRecord?.trabajador.apellido_paterno} ${activeRecord?.trabajador.apellido_materno} ${activeRecord?.trabajador.nombre}`}
                            readOnly
                        />
                    </div>
                    <div className="col-md-4">
                        Fecha: <br />
                        <input
                            type="date"
                            className="form-control"
                            value={form.fecha_planilla}
                            onChange={e => setForm({ ...form, fecha_planilla: e.target.value })}
                        />
                    </div>
                    <div className="col-md-4">
                        Hora Entrada: <br />
                        <input
                            type="time"
                            className="form-control"
                            value={form.hora_entrada}
                            onChange={e => setForm({ ...form, hora_entrada: e.target.value })}
                        />
                    </div>
                    <div className="col-md-4">
                        Hora Salida: <br />
                        <input
                            type="time"
                            className="form-control"
                            value={form.hora_salida}
                            onChange={e => setForm({ ...form, hora_salida: e.target.value })}
                        />
                    </div>
                </div>
                <br />
                <Button type="dashed" block className="mb-3" onClick={handleAgregarFecha}>
                    <i className="fas fa-plus"></i>&nbsp;Agregar Fecha
                </Button>

                <Table
                    bordered
                    size="small"
                    dataSource={planillas}
                    columns={[
                        {
                            title: 'Fecha',
                            dataIndex: 'fecha_planilla',
                        },
                        {
                            title: 'Hora Entrada',
                            dataIndex: 'hora_entrada'
                        },
                        {
                            title: 'Hora Salida',
                            dataIndex: 'hora_salida'
                        },
                        {
                            title: 'Acciones',
                            render: () => (
                                <>
                                    <button className="btn btn-sm btn-danger">
                                        <i className="fas fa-trash"></i>
                                    </button>
                                </>
                            )
                        }
                    ]}
                />
                <br />
                <Button
                    type="primary"
                    onClick={handleTerminar}
                    disabled={planillas.length === 0}
                    block
                >
                    Guardar
                </Button>
            </Modal>
        </>
    );
};
