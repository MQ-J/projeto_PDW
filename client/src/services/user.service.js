import axios from "axios";

import { API_BASE_URL } from "../../config";

export function createUsers(name, email, pwd) {
    return axios.post(`${API_BASE_URL}/user/`, {
        name: name,
        email: email,
        pwd: pwd
    });
}

export function updateMenu(name, email, pwd) {
    return axios.put(`${API_BASE_URL}/user/`, {
        name: name,
        email: email,
        pwd: pwd
    });
}

export function destroyMenu() {
    return axios.delete(`${API_BASE_URL}/user/`);
}