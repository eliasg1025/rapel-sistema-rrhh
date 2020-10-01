import React, { useEffect, useState } from "react";
import { Input } from "antd";

export const PagoIndividual = () => {
    const [form, setForm] = useState({
        tipo_pago: "",
        rut: "",
        periodo: ""
    });

    const handleSubmit = event => {
        event.preventDefault();
    };

    const handleChange = event => setForm({ ...form, [event.target.name]: event.target.value });

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="form-row">
                    <div className="col-md-6">
                        <input
                            type="text" name="rut" className="form-control"
                            onChange={handleChange}
                        />
                    </div>
                    <div className="col-md-6">
                        <input
                            type="submit" className="btn btn-primary"
                        />
                    </div>
                </div>
            </form>
            <hr />
        </>
    );
};
