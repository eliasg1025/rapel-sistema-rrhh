import React, { useState, useEffect } from 'react';
import { AutoComplete } from 'antd';
import Axios from 'axios';

import { clearObject } from '../../helpers';

const mockVal = (str, repeat = 1) => ({
    value: str.repeat(repeat),
});

const AutocompletarTrabajador = props => {
    const { setTrabajador } = props;

    const [value, setValue] = useState('');
    const [options, setOptions] = useState([]);

    const handleSearch = searchText => {
        if (searchText.length >= 3) {
            Axios.get(`http://192.168.60.16/api/trabajador/buscar?t=${searchText}`)
                .then(res => {
                    setOptions(res.data.map(item => {
                        return { value: item.nombre_completo, rut: item.rut }
                    }));
                });
        } else {
            setOptions([]);
        }
    }

    const handleSelect = data => {
        let t = options.find(item => item.value = data);

        Axios.get(`http://192.168.60.16/api/trabajador/${t.rut}`)
            .then(res => setTrabajador(clearObject(res.data.data.trabajador)))
            .catch(err => console.error(err));
    }

    const handleChange = data => {
        setValue(data);
    }

    return (
        <AutoComplete
            value={value}
            options={options}
            onSelect={handleSelect}
            onSearch={handleSearch}
            onChange={handleChange}
            placeholder="Buscar por nombre o apellido"
            style={{
                width: '100%',
            }}
        />
    );
}

export default AutocompletarTrabajador;
