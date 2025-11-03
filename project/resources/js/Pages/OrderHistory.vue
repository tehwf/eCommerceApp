<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps({
  orders: Array,
})

const form = useForm({
  status: '',
})

const updateStatus = (order) => {
  form.status = order.status
  form.patch(route('orders.updateStatus', order.id), {
    preserveScroll: true,
    onSuccess: () => alert('Status updated successfully!'),
  })
}
</script>

<template>
  <Head title="Order History" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-gray-800">Order History</h2>
    </template>

    <div class="py-12 max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
      <div v-if="orders.length">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b bg-gray-100">
              <th class="p-3">Order ID</th>
              <th class="p-3">Items</th>
              <th class="p-3">Total</th>
              <th class="p-3">Status</th>
              <th class="p-3">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders" :key="order.id" class="border-b hover:bg-gray-50">
              <td class="p-3">{{ order.id }}</td>

              <td class="p-3">
                <ul>
                  <li v-for="item in order.items" :key="item.id">
                    {{ item.name }} (x{{ item.quantity }})
                  </li>
                </ul>
              </td>

              <td class="p-3">RM {{ parseFloat(order.total_price).toFixed(2) }}</td>

              <td class="p-3">
                <select
                  v-model="order.status"
                  @change="updateStatus(order)"
                  :class="[
                    'rounded px-3 py-1 w-40 text-sm border transition',
                    order.status === 'Pending' ? 'bg-yellow-100 text-yellow-800 border-yellow-300' :
                    order.status === 'Processing' ? 'bg-blue-100 text-blue-800 border-blue-300' :
                    order.status === 'Completed' ? 'bg-green-100 text-green-800 border-green-300' :
                    order.status === 'Cancelled' ? 'bg-red-100 text-red-800 border-red-300' :
                    'bg-gray-100 text-gray-800 border-gray-300'
                  ]"
                >
                  <option value="Pending">Pending</option>
                  <option value="Processing">Processing</option>
                  <option value="Completed">Completed</option>
                  <option value="Cancelled">Cancelled</option>
                </select>
              </td>

              <td class="p-3">{{ new Date(order.created_at).toLocaleString() }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-else class="text-center text-gray-600">
        No orders yet.
      </div>
    </div>
  </AuthenticatedLayout>
</template>
