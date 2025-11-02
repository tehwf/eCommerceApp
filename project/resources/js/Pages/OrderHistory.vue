<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
  orders: Array
})
</script>

<template>
  <Head title="Order History" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-gray-800">My Orders</h2>
    </template>

    <div class="max-w-5xl mx-auto bg-white p-6 shadow mt-6 rounded-lg">
      <div v-if="orders.length">
        <div v-for="order in orders" :key="order.id" class="border-b pb-4 mb-4">
          <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-semibold">Order #{{ order.id }}</h3>
            <span
              class="px-2 py-1 rounded text-sm"
              :class="{
                'bg-yellow-100 text-yellow-700': order.status === 'Pending',
                'bg-blue-100 text-blue-700': order.status === 'Shipped',
                'bg-green-100 text-green-700': order.status === 'Completed'
              }"
            >
              {{ order.status }}
            </span>
          </div>

          <p class="text-gray-700">Shipping Address: {{ order.shipping_address }}</p>
          <p class="text-gray-700">Card No: {{ order.card_number }}</p>
          <p class="text-gray-800 font-semibold">
            Total: RM{{ Number(order.total_price).toFixed(2) }}
          </p>


          <h4 class="mt-3 font-semibold">Items:</h4>
          <ul class="list-disc pl-5">
            <li v-for="oi in order.items" :key="oi.id">
              {{ oi.item.name }} (x{{ oi.quantity }}) - RM {{ (oi.price * oi.quantity).toFixed(2) }}
            </li>
          </ul>
        </div>
      </div>

      <div v-else class="text-center text-gray-600 mt-10">
        You haven’t placed any orders yet.
      </div>
    </div>
  </AuthenticatedLayout>
</template>
