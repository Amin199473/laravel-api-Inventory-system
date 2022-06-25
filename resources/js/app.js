require('./bootstrap')


import { createApp } from 'vue';
import router from './routes.js';

//import user Class
import User from './helpers/User.js';
window.User = User;

//import Noty
import Notification from './helpers/Notification.js';
window.Notification = Notification;


//import sweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast



const app = createApp({});
app.use(router);

app.mount('#app')
