<script>
export default {
    name: 'ProjectsIndex',
}
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    projects: {
        type: Object,
        required: true,
    },
})

const deleteProject = id => {
    if (confirm('¿Estás seguro de querer eliminar este proyecto?')) {
        Inertia.delete(route('projects.destroy', id))
    }
}
</script>

<template>
    <AppLayout title="Proyectos">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Proyectos
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between">
                            <Link
                                :href="route('projects.create')"
                                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Crear proyecto
                            </Link>
                        </div>
                        <div class="mt-4">
                            <table class="table-auto w-full">
                                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2">Nombre</th>
                                        <th class="px-4 py-2">Autor</th>
                                        <th class="px-4 py-2">Descripción</th>
                                        <th class="px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100" v-if="projects.total > 0">
                                    <template v-for="project in projects.data">
                                        <tr>
                                            <td class="border px-4">{{ project.name }}</td>
                                            <td class="border px-4">{{ project.user.name }}</td>
                                            <td class="border px-4">{{ project.description }}</td>
                                            <td class="border px-4 py-4" style="width: 300px">
                                                <Link
                                                    :href="route('projects.edit', project.id)"
                                                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                                                >
                                                    Editar
                                                </Link>
                                                <Link
                                                    :href="route('projects.show', project.id)"
                                                    class="ml-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                                                >
                                                    Ver
                                                </Link>
                                                <Link
                                                    class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                    @click="deleteProject(project.id)"
                                                >
                                                    Eliminar
                                                </Link>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tbody v-else>
                                    <tr class="bg-red-400 text-white text-center">
                                        <td colspan="4" class="border px-4 py-2">No hay proyectos para mostrar</td>
                                    </tr>
                                </tbody>
                                <tfoot
                                    v-if="projects.last_page > 1"
                                    class="text-xs font-semibold uppercase text-gray-400 bg-gray-50"
                                >
                                    <tr>
                                        <td colspan="4" class="border px-4 py-4 text-right">
                                            <Link
                                                v-if="projects.current_page > 1"
                                                :href="projects.prev_page_url"
                                                class="px-3 py-1 bg-indigo-500 hover:bg-gray-600 text-white rounded"
                                            >
                                                Anterior
                                            </Link>
                                            <Link
                                                v-if="projects.current_page < projects.last_page"
                                                :href="projects.next_page_url"
                                                class="ml-2 px-3 py-1 bg-indigo-500 hover:bg-gray-600 text-white rounded"
                                            >
                                                Siguiente
                                            </Link>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
