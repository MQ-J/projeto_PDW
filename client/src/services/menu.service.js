import axios from "axios";

import { API_BASE_URL } from "../../config";

export function listMenus() {
    return axios.get(`${API_BASE_URL}/menu/`);
}

export function createMenus(name) {
    return axios.post(`${API_BASE_URL}/menu/`, {
        name: name,
    });
}

export function updateMenu(permalink, name) {
    return axios.put(`${API_BASE_URL}/menu/${permalink}/`, {
        name: name,
    });
}

export function destroyMenu(permalink) {
    return axios.delete(`${API_BASE_URL}/menu/${permalink}/`);
}