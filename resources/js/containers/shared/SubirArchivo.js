import React, { useState, createRef } from 'react';

export const SubirArchivo = ({ form, setForm }) => {

    const fileInput = createRef();

    const handleChange = e => {
        setForm({ ...form, file: fileInput.current.files[0] });
    }

    return (
        <>
            <input
                type="file" ref={fileInput}
                className="form-control-file"
                onChange={handleChange}
            />
        </>
    );
}
