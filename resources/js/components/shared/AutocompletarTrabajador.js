import React, { useState } from 'react';
import { AutoComplete } from 'antd';
import Axios from 'axios';

const mockVal = (str, repeat = 1) => ({
    value: str.repeat(repeat),
});

const AutocompletarTrabajador = props => {
    const { setTrabajador } = props;

    const [trabajadores, settrabajadores] = useState([]);
    const [value, setValue] = useState('');
    const [options, setOptions] = useState([]);

    const handleSearch = searchText => {
        if (searchText.length >= 3) {
            Axios.get(`http://192.168.60.16/api/trabajador/buscar?t=${searchText}`)
                .then(res => {
                    console.log(res.data);
                    const x = res.data.map((item, index) => {
                        return { value: item.nombre_completo }
                    });
                    setOptions(x);
                });
        } else {
            setOptions([]);
        }
    }

    const handleSelect = data => {
        console.log(data);
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
