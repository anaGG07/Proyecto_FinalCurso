<script>
export default {
    name: 'guestsIndex',
}
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import GraficaSO from '@/Components/GraficaSO.vue'
import GraficaCookies from '@/Components/GraficaCookies.vue'
import GraficaMails from '@/Components/GraficaMails.vue'
defineProps({
    guests: {
        type: Object,
        required: true,
    },
    totalRegistros: {
        type: Number,

    },
    soData:{
        type: Object,
    },
    emailData:{
        type: Object,
    },
});
function getOSAbbreviation(osName) {
    const osAbbreviations = {
        'Windows': 'WIN',
        'Linux': 'LIN',
        'Macintosh': 'MAC',
	'Mac':'MAC',
        'iOS': 'IOS',
        'Android': 'AND',
        'Unix': 'UNI',
        'Chrome OS': 'CHR',
        'Windows Phone': 'WPH',
        // Puedes agregar más sistemas operativos y sus abreviaturas aquí
    };

    return osAbbreviations[osName] || '???';
};
function textoCookies(cookieValue) {
    const cookieInterpretations = {
        'S': 'Si',
        'N': 'No',
        null: '-',
    };

    return cookieInterpretations[cookieValue] || '-';
}
function getBrowserAbbreviation(browserName) {
    const browserAbbreviations = {
        'Firefox': 'FFX',
        'Opera': 'OPR',
        'Edge': 'EDG',
        'Chrome': 'CHR',
        'Safari': 'SFR',
        'IE': 'IE'
    };

    return browserAbbreviations[browserName] || '???';
};

function maskEmail(email) {
    // Verificar que el email no sea null o undefined
    if (!email) {
        return '';
    }

    // Dividir la dirección de correo electrónico en dos partes: usuario y dominio
    const [user, domain] = email.split('@');

    // Asegurarse de que el usuario tiene al menos tres caracteres
    if (user.length < 3) {
        return email; // Si el usuario tiene menos de tres caracteres, devolver el correo sin cambios
    }

    // Crear la parte enmascarada del usuario
    const maskedUser = user.slice(0, 3) + '***';

    // Combinar la parte enmascarada del usuario con el dominio
    return maskedUser + '@' + domain;
}

function maskPhoneNumber(phoneNumber) {
    // Verificar que el número de teléfono no sea null o undefined
    if (!phoneNumber) {
        return '';
    }

    // Convertir el número de teléfono a string por si acaso se pasa como número
    const phoneStr = phoneNumber.toString();

    // Asegurarse de que el número de teléfono tiene al menos dos caracteres
    if (phoneStr.length <= 2) {
        return phoneStr; // Si el número tiene menos de dos caracteres, devolverlo sin cambios
    }

    // Crear la parte enmascarada del número de teléfono
    const maskedPhone = phoneStr[0] + '***' + phoneStr[phoneStr.length - 1];

    // Devolver el número de teléfono enmascarado
    return maskedPhone;
}

</script>

<template>
    <AppLayout title="Invitados">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                {{ totalRegistros }} Invitados
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <div class="mt-4 overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead class="text-xs font-semibold uppercase text-gray-400 dark:text-white bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2">IP</th>
                                        <th class="px-4 py-2">Nav.</th>
                                        <th class="px-4 py-2">Disp.</th>
                                        <th class="px-4 py-2">S.O.</th>
                                        <th class="px-4 py-2">Idioma</th>
                                        <th class="px-4 py-2">Cookies</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Tlf.</th>
                                        <th class="px-4 py-2">Nombre</th>
                                        <th class="px-4 py-2">Edad</th>
                                        <th class="px-4 py-2">Verif.</th>
                                        <th class="px-4 py-2">Abierto</th>
                                        <th class="px-4 py-2">Hora de conexión</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700" v-if="guests.data && guests.data.length">
                                    <template v-for="guest in guests.data" :key="guest.id">
                                        <tr>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.ip_address }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ getBrowserAbbreviation(guest.navegador) }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.plataforma === 'C' ? 'PC' : 'Movil' }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ getOSAbbreviation(guest.so) }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.language }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ textoCookies(guest.cookies) }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ maskEmail(guest.email) }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ maskPhoneNumber(guest.phone) }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.name }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.age }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.email_verified_at ? 'Sí' : 'No' }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.email_abierto === 'S' ? 'Sí' : 'No' }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.fecha_alta }}</td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tbody v-else>
                                    <tr class="bg-red-400 dark:bg-red-600 text-white text-center">
                                        <td colspan="13" class="border px-4 py-2 dark:border-gray-700">No hay Invitados para mostrar</td>
                                    </tr>
                                </tbody>
                                <tfoot v-if="guests.links" class="text-xs font-semibold uppercase text-gray-400 dark:text-white bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <td colspan="13" class="border px-4 py-4 text-right dark:border-gray-700">
                                            <Link
                                                v-if="guests.current_page > 1"
                                                :href="guests.prev_page_url"
                                                class="px-3 py-1 bg-white hover:bg-gray-600 dark:bg-gray-800 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded"
                                            >
                                                Anterior
                                            </Link>
                                            <Link
                                                v-if="guests.current_page < guests.last_page"
                                                :href="guests.next_page_url"
                                                class="ml-2 px-3 py-1 bg-white hover:bg-gray-600 dark:bg-gray-800 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded"
                                            >
                                                Siguiente
                                            </Link>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="grid grid-cols-12">
                        <div  class="col-span-8  p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <div class="text-xl text-white">Sistemas Operativos</div>
                            <GraficaSO :datos="soData[0]" :etiqueta="'SO'"></GraficaSO>
                        </div>
                        <div class="col-span-4 p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <div class="text-xl text-white"> Tipo de dispositivos </div>
                            <GraficaSO :datos="soData[1]" :etiqueta="'Dispositivo'"></GraficaSO>
                        </div>
                        <div class="col-span-4 p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <div class="text-xl text-white"> Aceptación de Cookies </div>
                            <GraficaCookies :datos="soData[2]"></GraficaCookies>
                        </div>
                        <div class="col-span-4 p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <div class="text-xl text-white"> Emails </div>
                            <GraficaMails :datos="emailData"></GraficaMails>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
