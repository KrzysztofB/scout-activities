//const BASE_URL = "http://localhost:5000/api/"
const BASE_URL = "api/"
const FetchKopernikAPI = {
    getResults: async function() {
        const response = await makeRequest(`${BASE_URL}`+ 'totalread.php', "GET")
        const results = await response.json();
        return results;
    }

};
// export default FetchKopernikAPI;

async function makeRequest(url, method, body) {
    const jsonBody = body ? JSON.stringify(body) : undefined;
    const response = await window.fetch(url, {
        method,
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: jsonBody
    });
    if (!response.ok) {
        throw new Error("Something went wrong!");
    }
    return response;
}