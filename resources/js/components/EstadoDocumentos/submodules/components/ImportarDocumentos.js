import React, { useState } from 'react';
import Modal from '../../../Modal';

import { SubirArchivo } from '../../../shared/SubirArchivo';
import Axios from 'axios';
import Swal from 'sweetalert2';

export const ImportarDocumentos = ({ tipoDocumento, reloadData, setReloadData, loading, setLoading }) => {

    const { usuario } = JSON.parse(sessionStorage.getItem('data'));

    const [isVisible, setIsVisible] = useState(false);
    const [form, setForm] = useState({
        empresa_id: 9,
    });

    const handleSubmit = e => {
        e.preventDefault();
        const url = `/api/documentos-turecibo/generar-archivo`;
        const formData = new FormData();
        formData.append('file', form.file);
        formData.append('empresa_id', form.empresa_id);
        formData.append('tipo_documento_turecibo_id', tipoDocumento.id);

        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }

        Swal.fire({
            title: 'Generando archivo de subida',
            text: 'Este proceso puede tardar unos minutos',
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        setLoading(true);
        Axios.post(url, formData, config)
            .then(res => {

                const { data } = res.data;

                insertarDatos(data);
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
                Swal.fire('Error al generar archivo', '', 'error');
            });
    }

    const insertarDatos = data => {
        Swal.fire({
            title: 'Ingresando registros',
            text: 'Este proceso puede tardar unos minutos',
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        Axios.post('/api/documentos-turecibo/massive', {
            data,
            empresa_id: form.empresa_id,
            tipo_documento_turecibo_id: tipoDocumento.id,
            usuario_id: usuario.id
        })
            .then(res => {

                Swal.fire({
                    title: 'Proceso terminado',
                    icon: 'info',
                    html: `Completados ${res.data.completados} de ${res.data.total}.<br /> <b>${res.data.errores?.length || 0} errores <a href="#">Descargar aquí</a></b>`
                })
                    .then(res => {
                        setIsVisible(false);
                        setLoading(false);
                        setReloadData(!reloadData);
                    });
            })
            .catch(err => {
                console.log(err);
                setLoading(false);
                Swal.fire('Error al generar archivo', '', 'error');
            })
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
