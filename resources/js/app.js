/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import ReactDOM from "react-dom";
import React from "react";
import "antd/dist/antd.css";

import Ingresos from "./containers/IngresosPersonal";
import Afp from "./containers/Afp";
import ReseteoClave from "./containers/ReseteoClave";
import Permisos from './containers/Permisos';
import Liquidaciones from "./containers/Liquidaciones/Liquidaciones";
import ConsultaTrabajadores from "./containers/ConsultaTrabajadores";
import Sanciones from "./containers/Sanciones/Sanciones";
import Sctr from "./containers/Sctr/Sctr";
import EstadoDocumentos from "./containers/EstadoDocumentos/EstadoDocumentos";
import Cuentas from "./containers/Cuentas";
import Perfil from "./containers/Perfil";
import DescansosMedicos from "./containers/DescansosMedicos";
import Aplicacion from "./containers/Aplicacion";
import Usuarios from "./containers/Usuarios";
import Panel from "./containers/Panel";
import Bonos from './containers/Bonos';
import FiniquitosMasivos from './containers/FiniquitosMasivos';

require("./bootstrap");
require("./containers/Login");

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding containers to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const initContainers = (containers = []) => {
    containers.forEach(container => {
        if (document.getElementById(container.id)) {
            ReactDOM.render(
                container.component,
                document.getElementById(container.id)
            );
        }
    });
};

const containers = [
    {
        id: "panel",
        component: <Panel />
    },
    {
        id: "ingresos",
        component: <Ingresos />
    },
    {
        id: "usuarios",
        component: <Usuarios />
    },
    {
        id: "controlador-aplicacion",
        component: <Aplicacion />
    },
    {
        id: "descansos-medicos",
        component: <DescansosMedicos />
    },
    {
        id: "perfil",
        component: <Perfil />
    },
    {
        id: "cuentas",
        component: <Cuentas />
    },
    {
        id: "estado-documentos",
        component: <EstadoDocumentos />
    },
    {
        id: "sctr",
        component: <Sctr />
    },
    {
        id: "sanciones",
        component: <Sanciones />
    },
    {
        id: "consulta-trabajadores",
        component: <ConsultaTrabajadores />
    },
    {
        id: "liquidaciones",
        component: <Liquidaciones />
    },
    {
        id: "afp",
        component: <Afp />
    },
    {
        id: 'reseteo-clave',
        component: <ReseteoClave />
    },
    {
        id: 'formularios-permisos',
        component: <Permisos />
    },
    {
        id: 'bonos',
        component: <Bonos />
    },
    {
        id: 'finiquitos',
        component: <FiniquitosMasivos />
    },
];

initContainers(containers);
