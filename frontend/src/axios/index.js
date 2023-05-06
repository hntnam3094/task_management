import axios from "axios";


const http = axios.create({
  baseURL: process.env.BASE_URL_API
})

http.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token');

    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  }, error => {
    return Promise.reject(error);
  }
)

http.interceptors.response.use(
  config => {
    return config
  }, error => {
    if (error.response && error.response.data) {
      return Promise.reject(error.response.data);
    }
    return Promise.reject(error.message);
  }
)

export default http
