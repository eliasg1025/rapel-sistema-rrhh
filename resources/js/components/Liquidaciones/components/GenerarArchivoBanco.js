import React from 'react';

export const GenerarArchivoBanco = ({ finiquitos, reloadData, setReloadData }) => {

    const handleSubmit = e => {
        e.preventDefault();

        console.log(finiquitos);
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="form-row">
                <div className="col-md-6"></div>
                <div className="col-md-6"></div>
            </div>
            <div className="form-row">
                <div className="col">
                    <button className="btn btn-primary btn-block" type="submit">
                        Generar
                    </button>
                </div>
            </div>
        </form>
    );
}
