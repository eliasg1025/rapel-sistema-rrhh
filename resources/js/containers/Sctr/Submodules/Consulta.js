import React, { useState } from 'react';
import { DatosPersonales } from '../Submodules/components/DatosPersonales';
import { BusquedaTrabajador } from './components/BusquedaTrabajador';
import { InfoSctr } from './components/InfoSctr';
import Axios from 'axios';
import { Historial } from './components/Historial';

export const Consulta = () => {

    const [trabajador, setTrabajador] = useState(null);
    const [contratos, setContratos] = useState([]);
    const [sctr, setSctr] = useState(false);
    const [reloadData, setReloadData] = useState(false);

    const handleExportOficios = () => {
        Axios({
            url: '/api/oficio/exportar/sctr',
            method: 'GET',
            responseType: 'blob'
        })
            .then(response => {
                console.log(response);
                let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = `OFICIOS-CON-SCTR.xlsx`
                link.click();
            });
    }

    return (
        <>
            <div className="row mb-1">
                <div className="col-md-5 col-sm-12">
                    <BusquedaTrabajador
                        setTrabajador={setTrabajador}
                        setContratos={setContratos}
                        setSctr={setSctr}
                        reloadData={reloadData}
                        setReloadData={setReloadData}
                    />
                </div>
                <div className="col-md-6">
                    <button className="btn btn-success" onClick={handleExportOficios}>
                        <i className="fas fa-file-excel"></i>&nbsp;Exportar Oficios
                    </button>
                </div>
            </div>
            <InfoSctr
                trabajador={trabajador}
                contratos={contratos}
                sctr={sctr}
            />
            <DatosPersonales
                trabajador={trabajador}
                contratos={contratos}
            />
            <br />
            <Historial
                reloadData={reloadData}
            />
        </>
    );
}
