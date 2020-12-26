import React, { useState, useEffect } from "react";
import { Card } from 'antd';
import moment from 'moment';

import { CreateFiniquitoFormIndividual, TablaFiniquitosIndividual } from "../components";

export const RegistroIndividual = () => {

    const initalFormState = {
        id: "",
        empresa_id: "",
        regimen_id: "",
        tipo_cese_id: "",
        fecha_inicio_periodo: "",
        fecha_termino_contrato: "",
        zona_labor: "",
        tiempo_servicio: 0,
        fecha_finiquito: moment().format("YYYY-MM-DD")
    };

    const [reload, setReload] = useState(false);
    const [form, setForm] = useState(initalFormState);

    return (
        <>
            <h4>Cartas de Renuncia</h4>
            <br />
            <Card
                style={{ border: form?.id ? '1.5px solid #1890FF' : '' }}
            >
                <CreateFiniquitoFormIndividual
                    reload={reload}
                    setReload={setReload}
                    form={form}
                    setForm={setForm}
                />
            </Card>
            <br />
            <TablaFiniquitosIndividual
                reload={reload}
                setReload={setReload}
                form={form}
                setForm={setForm}
            />
        </>
    );
}
