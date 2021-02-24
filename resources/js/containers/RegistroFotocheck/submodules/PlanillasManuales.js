import React, { useState, useEffect } from "react";
import { Card, DatePicker, Select } from "antd";
import moment from 'moment';
import Axios from 'axios';

import { TablaPlanillas } from "../components";

export const PlanillasManuales = () => {

    const [loading, setLoading] = useState(false);
    const [empresas, setEmpresas] = useState([]);
    const [planillas, setPlanillas] = useState([]);
    const [form, setForm] = useState({
        desde: moment()
            .subtract(7, 'days')
            .format("YYYY-MM-DD")
            .toString(),
        hasta: moment()
            .format("YYYY-MM-DD")
            .toString(),
        empresa_id: 9,
    });

    useEffect(() => {
        function fetchEmpresas() {
            Axios.get('/api/empresa')
                .then(res => setEmpresas(res.data))
                .catch(err => {})
        }

        fetchEmpresas();
    }, []);

    useEffect(() => {
        setLoading(true);
        function fetchPlanillas() {
            Axios.get(`/api/planillas-manuales?tipo=renovaciones_fotocheck&empresa_id=${form.empresa_id}`)
                .then(res => {
                    setPlanillas(res.data.data.map(item => {
                        return {
                            ...item,
                            key: item.id,
                        }
                    }));
                })
                .catch(err => {})
                .finally(() => setLoading(false))
        }

        fetchPlanillas();
    }, [form]);

    return (
        <>
            <h4>Planillas Manuales</h4>
            <br />
            <Card>
                <form>
                    <div className="row">
                        <div className="col-md-4">
                            Desde - Hasta:
                            <br />
                            <DatePicker.RangePicker
                                placeholder={["Desde", "Hasta"]}
                                style={{ width: "100%" }}
                                onChange={(date, dateString) => {
                                    setForm({
                                        ...form,
                                        desde: dateString[0],
                                        hasta: dateString[1]
                                    });
                                }}
                                value={[moment(form.desde), moment(form.hasta)]}
                            />
                        </div>
                        <div className="col-md-4">
                            Empresa:
                            <br />
                            <Select
                                value={form.empresa_id}
                                showSearch
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    option.children
                                        .toLowerCase()
                                        .indexOf(input.toLowerCase()) >= 0
                                }
                                onChange={e =>
                                    setForm({ ...form, empresa_id: e })
                                }
                                style={{
                                    width: "100%"
                                }}
                            >
                                {/* <Select.Option value={0} key={0}>TODOS</Select.Option> */}
                                {empresas.map(e => (
                                    <Select.Option value={e.id} key={e.id}>
                                        {`${e.id} - ${e.name}`}
                                    </Select.Option>
                                ))}
                            </Select>
                        </div>
                    </div>
                </form>
            </Card>
            <br />
            <TablaPlanillas
                data={planillas}
                loading={loading}
            />
        </>
    );
};
