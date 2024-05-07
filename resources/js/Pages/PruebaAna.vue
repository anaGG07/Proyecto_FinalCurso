<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import WelcomeAna from '@/Components/WelcomeAna.vue';
</script>

<template>
    <AppLayout title="Prueba">
        <template #header>
            <h2 class="font-semibold text-xl text-red-800 leading-tight">
                Prueba
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <WelcomeAna/>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
