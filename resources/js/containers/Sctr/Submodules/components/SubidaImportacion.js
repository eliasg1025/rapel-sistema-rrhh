import React from 'react';
import { Upload, message, Button } from 'antd';

export const SubidaImportacion = ({ handleImport }) => {
    return (
        <Upload>
            <Button>
                <i className="fas fa-upload"></i>&nbsp;Subir archivo
            </Button>
        </Upload>
    );
}
