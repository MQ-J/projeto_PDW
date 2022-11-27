import "./global.css";
import HMR from "@roxi/routify/hmr";
import App from "./App.svelte";

import { getToken } from "./services/auth.service";
const app = HMR(App, { target: document.body }, "routify-app");

// Add a request interceptor
axios.interceptors.request.use(function (config) {
    // Do something before request is sent
    const token = getToken()

    config.headers = {
        'Authorization': `Bearer ${token}`
    }
    return config;
  }, function (error) {
    // Do something with request error
    return Promise.reject(error);
  });

export default app;

