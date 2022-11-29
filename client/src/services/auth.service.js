import axios from "axios"
import { API_BASE_URL } from "../../config";

export function getToken(username, pwd) {
    const res = axios.post(`${API_BASE_URL}/auth`, {
        name: username,
        pwd: pwd
    });
    return res
}

export function unauth() {
    localStorage.clear()
    return axios.delete(`${API_BASE_URL}/auth`);
}

export function getAuthedUser(){
    const auth = localStorage.getItem('auth') 
    if (auth !== null)
        return JSON.parse(auth)
    else if (window.location.href.indexOf('auth') == -1)
        window.location.href = '/auth'
}

export function setLocalStorage() {
    
}