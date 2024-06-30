import './bootstrap';
import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';
import 'flowbite';
import html2pdf from 'html2pdf.js';

// import vue components
import { createApp } from 'vue';
import Dropdown from './components/Dropdown.vue';

window.Alpine = Alpine;
window.html2pdf = html2pdf;

Alpine.start();

document.addEventListener("DOMContentLoaded", function() {
    AOS.init();
});


// create vue app
createApp({})
  .component('dropdown', Dropdown)
  .mount('#app')