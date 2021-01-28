import React, { useState } from "react";
import { Card, Table, Button, notification } from "antd";
import Axios from "axios";

import Modal from '../../Modal';

import { SubirArchivo } from '../../shared/SubirArchivo';

export const Inicio = () => {

    const [reload, setReload] = useState(false);
    const [loading, setLoading] = useState(false);
    const [actividades, setActividades] = useState([]);
    const [viewModal, setViewModal] = useState(false);
    const [form, setForm] = useState({
        rut: '',
    });

    const consultar = () => {
        console.log(loading);

        setReload(!reload);
        setLoading(true);
        Axios.get(`/api/sqlsrv/actividad-trabajador/${form.rut}/ultima`)
            .then(res => {
                setActividades(res.data.data.map(item => {
                    return {
                        ...item,
                        key: item.rut
                    };
                }));
                notification["success"]({
                    message: res.data.message
                });
            })
            .catch(err => {
                console.error(err.response);

                notification["warning"]({
                    message: err.response.data.message
                });
            })
            .finally(() => {
                setReload(!reload);
                setLoading(false);
            });
    }

    const importar = () => {
        const formData = new FormData();

        for (const key in form) {
            if (form.hasOwnProperty(key)) {
                formData.append(key, form[key]);
            }
        }

        setLoading(true);
        Axios.post(`/api/sqlsrv/actividad-trabajador/importar`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
            .then(res => {
                console.log(res);
                setActividades(res.data.data.map(item => {
                    return {
                        ...item,
                        key: item.rut
                    };
                }));
                notification["success"]({
                    message: res.data.message
                });
            })
            .catch(err => {
                console.error(err.response);
                notification["warning"]({
                    message: err.response.data.message
                });
            })
            .finally(() => {
                setViewModal(false);
                setLoading(false);
            });
    }

    const handleSubmit = e => {
        e.preventDefault();
        consultar();
    }

    const handleSubmitImportar = e => {
        e.preventDefault();
        importar();
    }

    const exportar = () => {
        const headings = [
            'RUT',
            'NOMBRES Y APELLIDOS',
            'EMPRESA',
            'ULTIMO DIA LABORADO',
            'ZONA LABOR',
            'CUARTEL',
            'LABOR',
            'HORAS',
        ];

        const d = actividades.map(item => {
            return {
                rut: item.rut,
                nombre_completo: item.nombre_completo,
                empresa: item.empresa,
                fecha_actividad: item.fecha_actividad,
                zona_labor: item.zona_labor,
                cuartel: item.cuartel,
                labor: item.labor,
                horas: item.horas,
            };
        });

        Axios({
            url: '/descargar',
            data: {headings, data: d},
            method: 'POST',
            responseType: 'blob'
        })
            .then(response => {
                //console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `CONSULTA_ULTIMO_DIA_LABORADO.xlsx`
                link.click();
            });
    }

    const columns = [
        {
            title: 'RUT',
            dataIndex: 'rut',
        },
        {
            title: 'Nombres y apellidos',
            dataIndex: 'nombre_completo',
        },
        {
            title: 'Empresa',
            dataIndex: 'empresa'
        },
        {
            title: 'Ultimo día laborado',
            dataIndex: 'fecha_actividad',
        },
        {
            title: 'Zona Labor',
            dataIndex: 'zona_labor',
        },
        {
            title: 'Cuartel',
            dataIndex: 'cuartel',
        },
        {
            title: 'Labor',
            dataIndex: 'labor',
        },
        {
            title: 'Horas',
            dataIndex: 'horas',
        },
    ];

    return (
        <>
            <h4>Consulta Ultima Actividad</h4>
            <br />
            <Card>
                <div className="alert alert-primary">
                    Busca un trabajador o carga un documento .xlsx para consulta
                    sobre la ultima actividad del trabajador
                </div>
                <form onSubmit={handleSubmit}>
                    <div className="row">
                        <div className="col-md-4">
                            <input
                                className="form-control"
                                value={form.rut}
                                onChange={e => setForm({ ...form, rut: e.target.value })}
                            />
                        </div>
                    </div>
                    <div className="row mt-3">
                        <div className="col-md-12">
                            <Button
                                type="primary"
                                htmlType="submit"
                                size="small"
                                className="btn btn-primary"
                                style={{ height: '25.45px' }}
                                loading={loading}
                                disabled={form.rut.length < 8}
                            >
                                <i className="fas fa-search"></i> Consultar
                            </Button>
                            <button
                                type="button"
                                className="btn btn-success ml-2"
                                onClick={() => setViewModal(true)}
                            >
                                <i className="far fa-file-excel"></i> Importar
                            </button>
                        </div>
                    </div>
                </form>
            </Card>
            <br />
            {actividades.length > 0 && (
                <>
                    <div className="row">
                        <div className="col-md-12">
                            <button
                                type="button"
                                className="btn btn-success"
                                onClick={exportar}
                            >
                                Exportar
                            </button>
                        </div>
                    </div>
                    <br />
                </>
            )}
            <Table
                size="small"
                scroll={{ x: 500 }}
                columns={columns}
                dataSource={actividades}
                loading={loading}
            />
            <Modal
                title="Consulta Ultimo Dia"
                isVisible={viewModal}
                setIsVisible={setViewModal}
            >
                <form onSubmit={handleSubmitImportar}>
                    <SubirArchivo
                        form={form}
                        setForm={setForm}
                    />
                    <br />
                    <Button
                        htmlType="submit"
                        type="primary"
                        loading={loading}
                        disabled={!form.file}
                    >
                        Importar
                    </Button>
                </form>
            </Modal>
        </>
    );
};
