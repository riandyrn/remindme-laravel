import axios from "axios";
import { configure } from "axios-hooks";
import globalRouter from "./globalRouter";

const api = axios.create({
    baseURL: "http://remindme.test",
    headers: {
        "Content-Type": "application/json",
    },
});

// Add a request interceptor
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("access_token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

// Add a response interceptor
api.interceptors.response.use(
    (response) => response,
    async (error) => {
        const originalRequest = error.config;

        // If the error status is 401 and there is no originalRequest._retry flag,
        // it means the token has expired and we need to refresh it
        if (error.response) {
            if (error.response.status === 401 && !originalRequest._retry) {
                originalRequest._retry = true;

                try {
                    const refreshToken = localStorage.getItem("refresh_token");
                    const { data } = await axios.put(
                        "/api/session",
                        {},
                        {
                            headers: {
                                Authorization: `Bearer ${refreshToken}`,
                            },
                        }
                    );

                    localStorage.setItem(
                        "access_token",
                        data.data.access_token
                    );

                    // Retry the original request with the new token
                    originalRequest.headers.Authorization = `Bearer ${data.data.access_token}`;
                    return axios(originalRequest);
                } catch (error) {
                    // Handle refresh token error or redirect to login
                    globalRouter.navigate("/", { replace: true });
                }
            }
        }

        return Promise.reject(error);
    }
);

configure({ axios: api });

export default api;
