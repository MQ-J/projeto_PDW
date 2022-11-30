import axios from "axios";

import { API_BASE_URL } from "../../config";

export function listBlocks(permalink) {
    return axios.get(`${API_BASE_URL}/menu/${permalink}/block`);
}

export function createBlocks(permalink, text) {
    return axios.post(`${API_BASE_URL}/menu/${permalink}/block`, {
        text: text,
    });
}

export function updateBlocks(permalink, blockId, text) {
    return axios.put(`${API_BASE_URL}/menu/${permalink}/block/${blockId}`, {
        text: text,
    });
}

export function destroyBlock(permalink, blockId) {
    return axios.delete(`${API_BASE_URL}/menu/${permalink}/block/${blockId}`);
}