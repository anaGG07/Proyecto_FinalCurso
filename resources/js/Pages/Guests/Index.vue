<script>
export default {
    name: 'guestsIndex',
}
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    guests: {
        type: Object,
        required: true,
    },
})

const deleteguest = id => {
    if (confirm('¿Estás seguro de querer eliminar este proyecto?')) {
        Inertia.delete(route('guests.destroy', id))
    }
}

const formatDate = (date) => {
  return moment(date).format('DDMMYYYY HHmmss');
}
</script>

<template>
    <AppLayout title="Invitados">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Invitados
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="mt-4">
                            <table class="table-auto w-full">
                                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2">IP</th>
                                        <th class="px-4 py-2">Agente</th>
                                        <th class="px-4 py-2">Ref</th>
                                        <th class="px-4 py-2">Idioma</th>
                                        <th class="px-4 py-2">Hora de conexion</th>
                                        <!-- <th class="px-4 py-2">Acciones</th> -->
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100" v-if="guests">
                                    <template v-for="guest in guests" :key="guest.id">
                                        <tr>
                                            <td class="border px-4">{{ guest.ip_address }}</td>
                                            <td class="border px-4">{{ guest.user_agent }}</td>
                                            <td class="border px-4">{{ guest.referrer }}</td>
                                            <td class="border px-4">{{ guest.language }}</td>
                                            <td class="border px-4">{{ guest.created_at }}</td>
                                            <!-- <td class="border px-4 py-4" style="width: 300px">
                                                <Link
                                                    :href="route('guests.edit', guest.id)"
                                                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                                                >
                                                    Editar
                                                </Link>
                                                <Link
                                                    :href="route('guests.show', guest.id)"
                                                    class="ml-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                                                >
                                                    Ver
                                                </Link>
                                                <Link
                                                    class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                    @click="deleteguest(guest.id)"
                                                >
                                                    Eliminar
                                                </Link>
                                            </td> -->
                                        </tr>
                                    </template>
                                </tbody>
                                <tbody v-else>
                                    <tr class="bg-red-400 text-white text-center">
                                        <td colspan="4" class="border px-4 py-2">No hay Invitados para mostrar</td>
                                    </tr>
                                </tbody>
                                <!-- <tfoot
                                    v-if="guests.last_page > 1"
                                    class="text-xs font-semibold uppercase text-gray-400 bg-gray-50"
                                >
                                    <tr>
                                        <td colspan="4" class="border px-4 py-4 text-right">
                                            <Link
                                                v-if="guests.current_page > 1"
                                                :href="guests.prev_page_url"
                                                class="px-3 py-1 bg-indigo-500 hover:bg-gray-600 text-white rounded"
                                            >
                                                Anterior
                                            </Link>
                                            <Link
                                                v-if="guests.current_page < guests.last_page"
                                                :href="guests.next_page_url"
                                                class="ml-2 px-3 py-1 bg-indigo-500 hover:bg-gray-600 text-white rounded"
                                            >
                                                Siguiente
                                            </Link>
                                        </td>
                                    </tr>
                                </tfoot> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
