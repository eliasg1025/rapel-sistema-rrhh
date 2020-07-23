import React, { useState, useEffect } from 'react';
import Axios from 'axios';

const DatosAfp = ({
    handleSubmit,
    form,
    setForm,
    afps,
    setAfps,
}) => {

    const [empresas, setEmpresas] = useState([]);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        let intento = 0;
        function fetchEmpresas(cb) {
            intento++;
            Axios.get('/api/empresa')
                .then(res => setEmpresas(res.data))
                .catch(err => {
                    if (intento < 5) {
                        fetchEmpresas();
                    }
                })
                .finally(cb);
        }

        setLoading(true);
        fetchEmpresas(() => {
            setLoading(false);
        });
    }, []);

    useEffect(() => {
        function fetchAfps() {
            Axios.get(`http://192.168.60.16/api/afp/${form.empresa_id}`)
                .then(res => setAfps(res.data.data))
                .catch(err => {
                    console.log(err);
                });
        }
        if (form.empresa_id !== '') {
            fetchAfps();
        }
    }, [form.empresa_id])

    return (
        <form onSubmit={handleSubmit}>
            <div className="row">
                <div className="form-group col-md-6 col-lg-4">
                    <input
                        type="text" name="nombre_completo" placeholder="Trabajador" readOnly={true}
                        className="form-control"
                        value={form.nombre_completo}
                        onChange={e => setForm({ ...form, nombre_completo: e.target.value })}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    <input
                        type="text" name="fecha_inicio" placeholder="Fecha Inicio Contrato" readOnly={true}
                        className="form-control"
                        value={form.fecha_inicio}
                        onChange={e => setForm({ ...form, fecha_inicio: e.target.value })}
                    />
                </div>
                <div className="form-group col-md-6 col-lg-4">
                    <select
                        type="text" name="empresa_id" placeholder="Empresa"
                        className="form-control"
                        value={form.empresa_id}
                        onChange={e => setForm({ ...form, empresa_id: e.target.value })}
                    >
                        {empresas.map(e => <option value={e.id} key={e.id}>{e.id} - {e.name}</option>)}
                    </select>
                </div>
                <div className="form-group col-md-6 col-lg-4 d-none">
                    <select
                        type="text" name="afp_id" placeholder="Elige AFP"
                        className="form-control"
                        value={form.afp_id}
                        onChange={e => setForm({ ...form, afp_id: e.target.value })}
                    >
                        {afps.map(e => <option value={e.id} key={e.id}>{e.id} - {e.name}</option>)}
                    </select>
                </div>
            </div>
            <div className="row">
                <div className="col">
                    {loading ? (
                        <div className="spinner-grow text-info"></div>
                    ) : (
                        <button
                            type="submit" className="btn btn-primary btn-block"
                        >
                            Registrar
                        </button>

                    )}
                </div>
            </div>
        </form>
    );
};

export default DatosAfp;
