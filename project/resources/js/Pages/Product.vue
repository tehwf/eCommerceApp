<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

defineProps({
    items: Array
});

</script>


<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Products for sale
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 ">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div
                                v-for="item in items"
                                :key="item.id"
                                class="border rounded-lg p-4 shadow hover:shadow-lg transition">
                                
                                <Link :href="route('catalogue.show', item.id)" >
                                    <img
                                    v-if="item.image_url"
                                    :src="item.image_url"
                                    alt="Item image"
                                    class="w-full h-48 object-cover rounded-md mb-2"
                                    />
                                    <h3 class="text-lg font-semibold">{{ item.name }}</h3>
                                    <p class="text-gray-600 mb-2">{{ item.description }}</p>
                                    <p class="font-bold text-gray-800">RM {{ item.price }}</p>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
