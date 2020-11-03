/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import ReactDOM from "react-dom";
import React from "react";

import Ingresos from "./components/IngresosPersonal";
import AgregarAfp from "./components/Afp/AgregarAfp";
import AgregarPermiso from "./components/Permisos/AgregarPermiso";
import AgregarReseteoClave from "./components/ReseteoClave/AgregarReseteoClave";
import AgregarSancion from "./components/Sanciones/Submodules/AgregarSancion";
import Liquidaciones from "./components/Liquidaciones/Liquidaciones";
import ConsultaTrabajadores from "./components/ConsultaTrabajadores/ConsultarTrabajadores";
import Sanciones from "./components/Sanciones/Sanciones";
import Sctr from "./components/Sctr/Sctr";
import EstadoDocumentos from "./components/EstadoDocumentos/EstadoDocumentos";
import Cuentas from "./components/Cuentas";
import Perfil from "./components/Perfil";
import DescansosMedicos from "./components/DescansosMedicos";
import Aplicacion from "./components/Aplicacion";

import 'antd/dist/antd.css';

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if (document.getElementById("ingresos")) {
    const element = document.getElementById("ingresos");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<Ingresos {...props} />, document.getElementById("ingresos"));
}

if (document.getElementById("controlador-aplicacion")) {
    const element = document.getElementById("controlador-aplicacion");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<Aplicacion {...props} />, document.getElementById("controlador-aplicacion"));
}

if (document.getElementById("descansos-medicos")) {
    const element = document.getElementById("descansos-medicos");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<DescansosMedicos {...props} />, document.getElementById("descansos-medicos"));
}

if (document.getElementById("perfil")) {
    const element = document.getElementById("perfil");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<Perfil {...props} />, document.getElementById("perfil"));
}

if (document.getElementById("cuentas")) {
    const element = document.getElementById("cuentas");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<Cuentas {...props} />, document.getElementById("cuentas"));
}

if (document.getElementById("estado-documentos")) {
    const element = document.getElementById("estado-documentos");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<EstadoDocumentos {...props} />, document.getElementById("estado-documentos"));
}

if (document.getElementById("sctr")) {
    const element = document.getElementById("sctr");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<Sctr {...props} />, document.getElementById("sctr"));
}

if (document.getElementById("sanciones")) {
    const element = document.getElementById("sanciones");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<Sanciones {...props} />, document.getElementById("sanciones"));
}

if (document.getElementById("consulta-trabajadores")) {
    const element = document.getElementById("consulta-trabajadores");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<ConsultaTrabajadores {...props} />, document.getElementById("consulta-trabajadores"));
}

if (document.getElementById('estadisticas-usuarios')) {
    const element = document.getElementById('estadisticas-usuarios');
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<EstadisticasUsuarios {...props} />, document.getElementById('estadisticas-usuarios'));
}

if (document.getElementById("agregar-cuenta")) {
    const element = document.getElementById("agregar-cuenta");
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<AgregarCuenta {...props} />, document.getElementById("agregar-cuenta"));
}

if (document.getElementById("agregar-afp")) {
    const element = document.getElementById("agregar-afp");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<AgregarAfp {...props} />, document.getElementById("agregar-afp"));
}

if (document.getElementById("agregar-permiso")) {
    const element = document.getElementById("agregar-permiso");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<AgregarPermiso {...props} />, document.getElementById("agregar-permiso"));
}

if (document.getElementById("agregar-reseteo-clave")) {
    const element = document.getElementById("agregar-reseteo-clave");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<AgregarReseteoClave {...props} />, document.getElementById("agregar-reseteo-clave"));
}

if (document.getElementById("agregar-sancion")) {
    const element = document.getElementById("agregar-sancion");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<AgregarSancion {...props} />, document.getElementById("agregar-sancion"));
}

if (document.getElementById("liquidaciones")) {
    const element = document.getElementById("liquidaciones");
    const props = Object.assign({}, element.dataset);
    ReactDOM.render(<Liquidaciones {...props} />, document.getElementById("liquidaciones"));
}
