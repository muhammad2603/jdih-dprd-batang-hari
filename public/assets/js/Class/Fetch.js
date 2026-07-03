/**
 * @callback SuccessCallback
 * @param {{ status: boolean, message: string, new_token: string }} response
 * Response body dari server
 * @returns {*}
*/

/**
 * @callback ErrorCallback
 * @param {{ status: boolean, message: string, new_token: string }} error
*/

/**
 * @typedef {Object} FetchConfig
 * 
 * @property {string} url
 * URL endpoint
 * @property {string} action
 * Method request. Ex: GET|POST|UPDATE|PATCH|DELETE
 * @property {HeadersInit} [headers]
 * Inisialisasi headers request
 * @property {SuccessCallback} success
 * Callback ketika fetch berhasil
 * @property {ErrorCallback} errors
 * Callback ketika fetch gagal
*/

/**
 * Ambil data dari server
 * 
 * @param {FetchConfig} fetchConfig
 * @returns {void}
 */
const useFetch = async (fetchConfig) => {
    const { url, action, headers, success, errors } = fetchConfig;
    try {
        const response = await fetch(url, { method: action, headers: headers });
        const result = await response.json();
        if (!response.ok) throw result;
        success(result)
    } catch (error) {
        errors(error)
    }
}

export { useFetch };