<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
  item: Object
})

const quantity = ref(1)

const form = useForm({
    item_id: props.item.id,
    quantity: 1,
})

const addToCart = () => {
    if (quantity.value > props.item.quantity) {
        alert('Quantity added exceeded available quantity');
        return;
    }

    form.quantity = quantity.value;
    form.post(route('cart.add'), {
        onSuccess: () => alert('Item added to cart successfully!'),
        onError: () => alert('Failed to add item to cart.'),
    })
}


</script>

<template>
    <Head title="props.item.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800"> {{props.item.name}} </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">
                <img 
                    v-if="props.item.image_url"
                    :src="props.item.image_url"
                    alt="Product Image"
                    class="w-full h-80 object-cover rounded-md mb-6"
                />

                <h3 class="text-2xl font-bold mb-2"> {{props.item.name}} </h3>
                <p class="text-gray-700 mb-4"> {{props.item.description}} </p>
                <p class="text-lg font-semibold mb-2"> RM{{props.item.price}} </p>
                <p class="text-sm text-gray-500 mb-4"> Available quantity: {{props.item.quantity}} </p>

                <div class="flex items-center space-x-2 mb-4">
                    <label for="quantity"> Quantity: </label>
                    <input
                        id="quantity"
                        type="number"
                        v-model="quantity"
                        min="1"
                        :max="props.item.quantity"
                        class="border rounded p-2 w-24"
                    />
                </div>

                <button 
                    @click="$inertia.visit(route('products'))"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md"
                >
                    Return
                </button>
                <button
                    @click="addToCart"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md"
                >
                    Add to cart 
                </button>
            </div>
        </div>
    </AuthenticatedLayout>

</template>