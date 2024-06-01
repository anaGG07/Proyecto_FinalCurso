
<template>
    <Head title="Gracias" />

    <div class="flex flex-col min-h-screen bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <main class="mt-6 flex flex-grow items-center justify-center">
            <div v-if="!showCookieBanner && !showForm" class="flex flex-col items-center justify-center w-full">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-lg shadow-lg text-center max-w-lg mx-auto"><br>
                    <h2 class="text-lg font-semibold mb-4 text-black dark:text-white">¡GRACIAS POR PARTICIPAR!</h2>                
                </div>
            </div>
        </main>
    </div>

</template>
