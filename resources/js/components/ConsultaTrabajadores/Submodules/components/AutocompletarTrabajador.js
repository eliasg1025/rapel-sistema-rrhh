import React, { useState, useEffect } from 'react';
import { AutoComplete } from 'antd';
import Axios from 'axios';
import Swal from "sweetalert2";

const AutocompletarTrabajador = ({ setTrabajador, setPeriodos, setAlertas }) => {

    const { usuario, submodule } = JSON.parse(sessionStorage.getItem('data'));

    const [options, setOptions] = useState([]);
    const [loading, setLoading] = useState(false);

    const handleSearch = searchText => {
        if (searchText.length >= 5) {
            Axios.get(`http://192.168.60.16/api/trabajador/buscar-todos?t=${searchText}`)
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
            Axios.get(`http://192.168.60.16/api/trabajador/${t.rut}/info-periodos`)
                .then(res => {
                    const { trabajador, alertas, periodos } = res.data;

                    setTrabajador(trabajador);
                    setPeriodos(periodos.map(i => {
                        return {
                            ...i,
                            key: `${i.empresa_id}${i.contrato_id}`,
                            empresa: i.empresa_id === '9' ? 'RAPEL' : 'VERFRUT',
                            sueldo: i.sueldo_bruto <= 2000 ? i.sueldo_bruto : <i className="fas fa-ban" />
                        }
                    }));
                    setAlertas(alertas);

                    Axios.post('/api/consulta-trabajador', {
                        usuario_id: usuario.id,
                        rut: t.rut,
                        activo: periodos.reduce((a, p) => parseInt(p.indicador_vigencia) + a, 0)
                    })
                        .then(res => console.log(res))
                        .catch(err => console.log(err));


                    setLoading(false);

                    Swal.fire('Trabajador encontrado', '', 'success');
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
        setOptions([]);
    }

    return (
        <>
            {loading ? (
                <div className="spinner-grow text-info"></div>
            ) : (
                <div className="row mb-3">
                    <div className="col">
                        <AutoComplete
                            options={options}
                            onSelect={handleSelect}
                            onSearch={handleSearch}
                            onChange={handleChange}
                            placeholder="Buscar por nombre o apellido"
                            style={{
                                width: '100%',
                            }}
                        />
                    </div>
                </div>
            )}
        </>
    );
}

export default AutocompletarTrabajador;
