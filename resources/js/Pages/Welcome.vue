<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    id: {
        type: Number,
        required: true,
    },
    ipAddress: {
        type: String,
        required: true,
    },
    userAgent: {
        type: String,
        required: true,
    },
    referrer: {
        type: String,
        required: false,
    },
    language: {
        type: String,
        required: false,
    },
});

const showCookieBanner = ref(true);
const showForm = ref(false);

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

function acceptCookies() {
    sendCookieDecision(true);
    showCookieBanner.value = false;
}

function rejectCookies() {
    sendCookieDecision(false);
    showCookieBanner.value = false;
}

function sendCookieDecision(accepted) {
    axios.post('/api/cookies', {
        id: props.id,
        cookies: accepted ? 'S' : 'N',
        ipAddress: props.ipAddress,
        userAgent: props.userAgent,
        referrer: props.referrer || '',
        language: props.language || '',
    }).then(response => {
        console.log('Decisión de Cookies enviada:', response.data);
    }).catch(error => {
        console.error('Error enviando la decisión de cookies:', error);
    });
}

function openForm() {
    showForm.value = true;
}

function submitForm(event) {
    event.preventDefault();
    const email = event.target.email.value;
    const phone = event.target.phone.value;
    const name = event.target.name.value;
    const age = event.target.age.value;

    Inertia.post('/api/store-form', {
        email: email,
        phone: phone,
        name: name,
        age: age,
        id: props.id,
    }, {
        onFinish: () => {
            Inertia.visit('/gracias');
        }
    });
}
</script>

<template>
    <Head title="Welcome" />

    <div class="flex flex-col min-h-screen bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <main class="mt-6 flex flex-grow items-center justify-center">
            <div v-if="!showCookieBanner && !showForm" class="flex flex-col items-center justify-center w-full">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-lg shadow-lg text-center max-w-lg mx-auto">
                    <h2 class="text-lg font-semibold mb-4 text-black dark:text-white">Descripción del Proyecto</h2>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                        Este proyecto tiene como objetivo demostrar cómo los usuarios pueden ser vulnerables a prácticas
                        de ingeniería social a través del uso de tecnologías cotidianas como códigos QR y enlaces en redes
                        sociales. Desarrollaremos un sistema integrado que incluye la creación de un código QR y un enlace
                        asociado, ambos dirigidos a una web propia. Esta aplicación web recolectará datos no sensibles de
                        los usuarios y servirá para educarlos sobre la importancia de leer y entender los términos y
                        condiciones antes de interactuar con contenido digital.
                    </p>
                    <h3 class="text-md font-semibold mb-4 text-black dark:text-white">Intenciones y Transparencia</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                        La información sobre el propósito de la recolección de datos estará disponible de manera clara y
                        accesible en el sitio web, incluida en las secciones de cookies, términos y condiciones, y otros
                        lugares relevantes. Esto tiene como objetivo subrayar la importancia de que los usuarios presten
                        atención y lean detenidamente la información presentada antes de interactuar con elementos digitales.
                    </p>
                    <div class="mt-4">
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">¿Deseas aportar más información?</p>
                        <button @click="openForm" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="showForm" class="flex flex-col items-center justify-center w-full">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-lg shadow-lg text-center max-w-lg mx-auto">
                    <h2 class="text-lg font-semibold mb-4 text-black dark:text-white">Formulario de Información</h2>
                    <form @submit="submitForm" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm text-black" />
                        </div>
                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Edad</label>
                            <input type="number" id="age" name="age" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm text-black" />
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm text-black" />
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono
                                (opcional)</label>
                            <input type="tel" id="phone" name="phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm text-black" />
                        </div>
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">Enviar</button>
                    </form>
                </div>
            </div>
        </main>

        <footer class="py-2 text-center text-sm text-black dark:text-white/70" style="font-family: 'Arial', sans-serif;">
            <p class="text-lg font-bold">Análisis de Vulnerabilidades Humanas en Seguridad Cibernética</p>
            <p class="text-xs">&copy; All rights reserved</p>
        </footer>
    </div>

    <div v-if="showCookieBanner" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-lg shadow-lg text-center max-w-lg mx-auto">
            <h2 class="text-lg font-semibold mb-4 text-black dark:text-white">Aviso de Cookies</h2>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                Usamos cookies para mejorar su experiencia en nuestro sitio web. Este proyecto tiene como objetivo
                demostrar cómo los usuarios pueden ser vulnerables a prácticas de ingeniería social a través del uso de
                tecnologías cotidianas como códigos QR y enlaces en redes sociales. Al continuar navegando, aceptas nuestro uso de
                cookies. Analizaremos tu comportamiento para educarte sobre la importancia de leer y entender los términos y
                condiciones antes de interactuar con contenido digital. Puedes aceptar o rechazar las cookies según tu
                preferencia. Al aceptar o rechazar las cookies, se registrará información para este propósito educativo.
            </p>
            <div class="flex justify-center space-x-4">
                <button @click="acceptCookies" class=" text-white px-4 py-2 rounded-md hover:bg-red-700">Aceptar</button>
                <button @click="rejectCookies" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700">Rechazar</button>
            </div>
        </div>
    </div>
</template>
