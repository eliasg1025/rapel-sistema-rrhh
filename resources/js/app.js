/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import ReactDOM from "react-dom";
import React from "react";
import AgregarCuenta from "./components/Cuentas/AgregarCuenta";
import AgregarAfp from "./components/Afp/AgregarAfp";
import AgregarPermiso from "./components/Permisos/AgregarPermiso";
import AgregarReseteoClave from "./components/ReseteoClave/AgregarReseteoClave";
import AgregarSancion from "./components/Sanciones/AgregarSancion";

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/Login');
require('./layouts/MainLayout');
require('./layouts/TrabajadoresLayout');
require('./layouts/UsuariosLayout');
require('./layouts/RegistroIndividualLayout');
require('./layouts/RegistroMasivoLayout');
require('./components/Cuentas/AgregarCuenta');
require('./components/Cuentas/TablaCuentas');
require('./components/Cuentas/TablaCuentasAdmin');
require('./components/Afp/AgregarAfp');
require('./components/Permisos/AgregarPermiso');
require('./components/Sanciones/AgregarSancion');


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
