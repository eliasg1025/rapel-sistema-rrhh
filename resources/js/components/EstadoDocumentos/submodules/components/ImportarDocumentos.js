import React, { useState } from 'react';
import Modal from '../../../Modal';

import { SubirArchivo } from '../../../shared/SubirArchivo';
import Axios from 'axios';

export const ImportarDocumentos = ({ tipoDocumento, reloadData, setReloadData, loading, setLoading }) => {

    const [isVisible, setIsVisible] = useState(false);
    const [form, setForm] = useState({
        empresa_id: 9,
    });

    const handleSubmit = e => {
        e.preventDefault();
        const url = `/api/documentos-turecibo/importar`;
        const formData = new FormData();
        formData.append('file', form.file);
        formData.append('empresa_id', form.empresa_id);
        formData.append('tipo_documento_turecibo_id', tipoDocumento.id);

        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }

        setLoading(true);
        Axios.post(url, formData, config)
            .then(res => {
                console.log(res);

                const { message } = res.data;

                setLoading(false);
                Swal.fire(message, '', 'success')
                    .then(res => {
                        setIsVisible(false);
                        setReloadData(!reloadData);
                    });
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
            });
    }

    return (
        <>
            <button className="btn btn-primary" onClick={() => setIsVisible(true)}>
                <i className="fas fa-file-import"></i> Importar Registros
            </button>
            <Modal
                isVisible={isVisible}
                setIsVisible={setIsVisible}
                title={`Importar Documentos: ${tipoDocumento.name}`}
            >
                <form onSubmit={handleSubmit}>
                    <div className="form-row">
                        <div className="col-md-12">
                            <select className="form-control" onChange={e => setForm({ ...form, empresa_id: e.target.value })}>
                                <option value={9} key={9}>RAPEL</option>
                                <option value={14} key={14}>VERFRUT</option>
                            </select>
                        </div>
                    </div>
                    <br />
                    <div className="form-row">
                        <div className="col-md-12">
                            <SubirArchivo
                                form={form}
                                setForm={setForm}
                            />
                        </div>
                    </div>
                    <br />
                    <div className="form-row">
                        <div className="col">
                            <button type="submit" className="btn btn-primary btn-block">
                                {!loading ? 'Importar' : (
                                    <>
                                        <i className="fas fa-spinner fa-spin" />&nbsp;Cargando
                                    </>
                                )}
                            </button>
                        </div>
                    </div>
                </form>
            </Modal>
        </>
    );
}
