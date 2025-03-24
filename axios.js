import axios from "axios";

axios.defaults.withCredentials = true;
// axios.defaults.baseURL="http://localhost:8000" 

// axios.defaults.baseURL = 'http://localhost:8000';  
axios.defaults.baseURL = 'http://localhost:8000/api'
axios.defaults.withCredentials = true // Activez les credentials

axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['Accept'] = 'application/json'
axios.interceptors.request.use(config => {  
    const token = sessionStorage.getItem('token'); 
    if (token) {  
        config.headers.Authorization = `Bearer ${token}`;  
    }  
    return config;  
});