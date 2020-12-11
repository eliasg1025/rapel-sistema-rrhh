import React, { useState, useEffect } from "react";
import { Card } from 'antd';

import { CreateFiniquitoFormIndividual } from "../components/CreateFiniquitoFormIndividual";

export const RegistroIndividual = () => {
    return (
        <>
            <h4>Registro Individual</h4>
            <br />
            <Card>
                <CreateFiniquitoFormIndividual />
            </Card>
        </>
    );
}