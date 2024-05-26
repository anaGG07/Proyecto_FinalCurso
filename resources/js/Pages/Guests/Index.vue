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
    }
});



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
                        <div class="mt-4">
                            <table class="table-auto w-full">
                                <thead class="text-xs font-semibold uppercase text-gray-400 dark:text-white bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2">IP</th>
                                        <th class="px-4 py-2">Navegador</th>
                                        <th class="px-4 py-2">Plataforma</th>
                                        <th class="px-4 py-2">S.O.</th>
                                        <th class="px-4 py-2">Idioma</th>
                                        <th class="px-4 py-2">Cookies</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Telefono</th>
                                        <th class="px-4 py-2">Nombre</th>
                                        <th class="px-4 py-2">Edad</th>
                                        <th class="px-4 py-2">Hora de conexion</th>

                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700" v-if="guests.data && guests.data.length">
                                    <template v-for="guest in guests.data" :key="guest.id">
                                        <tr>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.ip_address }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.navegador }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.plataforma === 'C' ? 'Ordenador' : 'Movil' }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.so }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.language }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.cookies }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.email }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.phone }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.name }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.age }}</td>
                                            <td class="border px-4 dark:border-gray-700 dark:text-white">{{ guest.fecha_alta }}</td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tbody v-else>
                                    <tr class="bg-red-400 dark:bg-red-600 text-white text-center">
                                        <td colspan="7" class="border px-4 py-2 dark:border-gray-700">No hay Invitados para mostrar</td>
                                    </tr>
                                </tbody>
                                <tfoot v-if="guests.links" class="text-xs font-semibold uppercase text-gray-400 dark:text-white bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <td colspan="12" class="border px-4 py-4 text-right dark:border-gray-700">
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
                            <GraficaSO :datos="soData[0]" :etiqueta="'Sistema Operativo'"></GraficaSO>
                        </div>
                        <div class="col-span-4 p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <GraficaSO :datos="soData[1]" :etiqueta="'Dispositivo'"></GraficaSO>
                            <!-- <GraficaCookies :datos="soData[1]"></GraficaCookies> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
