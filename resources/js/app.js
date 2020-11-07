/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import ReactDOM from "react-dom";
import React from "react";
import "antd/dist/antd.css";

import Ingresos from "./components/IngresosPersonal";
import Afp from "./components/Afp";
import ReseteoClave from "./components/ReseteoClave";
import Permisos from './components/Permisos';
import Liquidaciones from "./components/Liquidaciones/Liquidaciones";
import ConsultaTrabajadores from "./components/ConsultaTrabajadores";
import Sanciones from "./components/Sanciones/Sanciones";
import Sctr from "./components/Sctr/Sctr";
import EstadoDocumentos from "./components/EstadoDocumentos/EstadoDocumentos";
import Cuentas from "./components/Cuentas";
import Perfil from "./components/Perfil";
import DescansosMedicos from "./components/DescansosMedicos";
import Aplicacion from "./components/Aplicacion";
import Usuarios from "./components/Usuarios";
import Panel from "./components/Panel";

require("./bootstrap");
require("./components/Login");

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
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
];

initContainers(containers);
