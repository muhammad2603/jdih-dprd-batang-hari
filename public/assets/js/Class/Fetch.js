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
 * @property {string} [action]
 * Method request, ex: [GET | POST | UPDATE | PATCH | DELETE]. Default adalah GET.
 * @property {HeadersInit} [headers]
 * Inisialisasi headers request
 * @property {object} [body]
 * Body request. Jika GET, body tidak dibutuhkan
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
    const { url, action, headers, body, success, errors } = fetchConfig;
    try {
        const setMethod = action ?? "GET";
        const setConfigFetch = {
            method: setMethod,
            headers: headers
        };
        if (setMethod.toLowerCase() !== "get") {
            setConfigFetch.body = body;
        }
        const response = await fetch(url, setConfigFetch);
        const result = await response.json();
        if (!response.ok) throw result;
        success(result)
    } catch (error) {
        errors(error)
    }
}

export { useFetch };