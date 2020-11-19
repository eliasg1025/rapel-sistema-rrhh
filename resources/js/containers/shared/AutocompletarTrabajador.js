import React, { useState, useEffect } from 'react';
import { AutoComplete } from 'antd';

import Axios from 'axios';

import { clearObject } from '../../helpers';

const AutocompletarTrabajador = ({ setTrabajador, form, setForm }) => {

    const [options, setOptions] = useState([]);
    const [loading, setLoading] = useState(false);

    const handleSearch = searchText => {
        if (searchText.length >= 3) {
            Axios.get(`http://192.168.60.16/api/trabajador/buscar?t=${searchText}`)
                .then(res => {
                    setOptions(res.data.map(item => ({ value: item.nombre_completo, rut: item.rut }) ));
                })
                .catch(e => setOptions([]));
        } else {
            setOptions([]);
        }
    }

    const handleSelect = data => {
        const t = options.find(item => item.value == data);

        let intentos = 0;
        setLoading(true);
        function fetchTrabajador() {
            intentos++;
            Axios.get(`http://192.168.60.16/api/trabajador/${t.rut}`)
                .then(res => {
                    setTrabajador(clearObject(res.data.data.trabajador))
                    setLoading(false);
                })
                .catch(err => {
                    if (intentos < 5) {
                        fetchTrabajador();
                    }
                    console.log(err);
                })
        }

        fetchTrabajador();
    }

    const handleChange = data => {
        setForm({
            ...form,
            nombre_completo_jefe: data
        });
        setOptions([]);
    }

    return (
        <>
            {loading ? (
                <div className="spinner-grow text-info"></div>
            ) : (
                <AutoComplete
                    value={form.nombre_completo_jefe}
                    options={options}
                    onSelect={handleSelect}
                    onSearch={handleSearch}
                    onChange={handleChange}
                    placeholder="Buscar por nombre o apellido"
                    style={{
                        width: '100%',
                    }}
                />
            )}
        </>
    );
}

export default AutocompletarTrabajador;
