import axios from "axios";
import { API_BASE_URL } from "../../config";

export function getToken(name, pwd) {
    if (localStorage.getItem('auth') !== null)
        return JSON.parse(localStorage.getItem('auth'))['token']

    return axios.post(`${API_BASE_URL}/auth`, {
        name: name,
        pwd: pwd
    });
}

export function unauth() {
    return axios.delete(`${API_BASE_URL}/auth`);
}
