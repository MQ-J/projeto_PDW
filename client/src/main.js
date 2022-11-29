import "./global.css";
import HMR from "@roxi/routify/hmr";
import App from "./App.svelte";
import axios from "axios";

import { getAuthedUser } from "./services/auth.service";
const app = HMR(App, { target: document.body }, "routify-app");

axios.interceptors.request.use(
    function (config) {
        if (
            (config.url.indexOf("auth") == -1 &&
                config.url.indexOf("user") == -1) ||
            (config.url.indexOf("user") != -1 &&
                config.method !== "post" &&
                config.url.indexOf("auth") != -1 &&
                config.method !== "post")
        ) {
            config.headers["Authorization"] =
                "Bearer " + getAuthedUser()["token"];
        }
        // Do something before request is sent
        return config;
    },
    function (error) {
        // Do something with request error
        return Promise.reject(error);
    }
);

export default app;
