import axios from 'axios';

const server = axios.create({
    withCredentials: true,
    baseURL: '/s/',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }
});

export default server;