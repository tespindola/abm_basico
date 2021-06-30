import axios from 'axios';

const server = axios.create({
    withCredentials: true,
    baseURL: '/s/',
});

export default server;