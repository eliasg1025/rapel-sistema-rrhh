import React, { useState, useEffect } from "react";
import { Card, DatePicker, Select, Button } from "antd";
import moment from "moment";

import { empresa } from "../../../../data/default.json";

const FilterForm = props => {
    const [loading, setLoading] = useState();

    useEffect(() => {
        /* if (
            (props.filtro?.dni === '' || props.filtro?.dni?.length >= 8) &&
            (props.filtro?.nombre.length >= 3)
        ) {
        } */

        fetchData();
    }, [props.reload]);

    const fetchData = async () => {
        setLoading(true);
        await Promise.all([
            props.getTrabajadores(),
            props.getTrabajadoresObservados()
        ]);
        setLoading(false);
    };

    const handleChange = e => {
        const { name, value } = e.target;
        props.setFiltro({
            ...props.filtro,
            [name]: value
        });
    };

    return (
        <Card>
            <form onSubmit={e => e.preventDefault()}>
                <div className="row">
                    <div className="col-md-4">
                        Desde - Hasta:
                        <br />
                        <DatePicker.RangePicker
                            size="small"
                            placeholder={["Desde", "Hasta"]}
                            style={{ width: "100%" }}
                            onChange={(date, dateString) => {
                                props.setFiltro({
                                    ...props.filtro,
                                    desde: dateString[0],
                                    hasta: dateString[1]
                                });
                            }}
                            value={[
                                moment(props.filtro.desde),
                                moment(props.filtro.hasta)
                            ]}
                        />
                    </div>
                    <div className="col-md-4">
                        Empresa:
                        <br />
                        <Select
                            size="small"
                            showSearch
                            placeholder="Empresa"
                            optionFilterProp="children"
                            style={{ width: "100%" }}
                            filterOption={(input, option) =>
                                option.children
                                    .toLowerCase()
                                    .indexOf(input.toLowerCase()) >= 0
                            }
                            value={props.filtro.empresa_id}
                            onChange={e => {
                                props.setFiltro({
                                    ...props.filtro,
                                    empresa_id: e
                                });
                            }}
                        >
                            {empresa.map(option => (
                                <Select.Option value={option.id} key={option.id}>
                                    {option.name}
                                </Select.Option>
                            ))}
                        </Select>
                    </div>
                    <div className="col-md-4">
                        Grupo:
                        <br />
                        <input
                            className="form-control"
                            name="grupo"
                            placeholder="Buscar por N° Grupo"
                            type="number"
                            onChange={handleChange}
                        />
                    </div>
                    <div className="col-md-4">
                        DNI:
                        <br />
                        <input
                            autoComplete="off"
                            className="form-control"
                            name="dni"
                            placeholder="Buscar por DNI"
                            onChange={handleChange}
                        />
                    </div>
                    <div className="col-md-4">
                        Nombre/Apellidos:
                        <br />
                        <input
                            autoComplete="off"
                            className="form-control"
                            name="nombre"
                            placeholder="Buscar por Nombre o Apellidos"
                            onChange={handleChange}
                        />
                    </div>
                </div>
                <br />
                <div className="row">
                    <div className="col">
                        <Button
                            htmlType="submit"
                            size="small"
                            block
                            type="primary"
                            onClick={() => props.setReload(!props.reload)}
                            loading={loading}
                        >
                            Buscar
                        </Button>
                    </div>
                </div>
            </form>
        </Card>
    );
};

export default FilterForm;
