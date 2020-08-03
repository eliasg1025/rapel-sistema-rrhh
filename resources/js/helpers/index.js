export function clearObject(data) {
    for (const key in data) {
        if (data[key] === null || data[key] === undefined) {
            data[key] = '';
        }
    }
    return data;
}
