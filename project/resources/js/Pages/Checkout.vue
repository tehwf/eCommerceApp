<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
  errors: Object,
  cartItems: Array,
  total: Number,
})

const form = useForm({
  shipping_address: '',
  card_number: ''
})

const submit = () => {
  form.post(route('checkout.place'))
}
</script>

<template>
  <AuthenticatedLayout>
      <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6">Checkout</h1>

        <!-- CART ITEMS PREVIEW -->
        <div v-if="cartItems.length" class="mb-6 border-b pb-4">
          <h2 class="text-xl font-semibold mb-4">Your Items</h2>
          <div
            v-for="item in cartItems"
            :key="item.id"
            class="flex items-center mb-3 border rounded-lg p-3"
          >
            <img
              :src="item.item.image_url"
              alt="Product Image"
              class="w-16 h-16 object-cover rounded-md mr-4"
            />
            <div class="flex-1">
              <h3 class="font-semibold text-gray-800">{{ item.item.name }}</h3>
              <p class="text-gray-600 text-sm">
                Quantity: {{ item.quantity }} × RM{{ item.item.price }}
              </p>
            </div>
            <p class="font-semibold text-gray-900">
              RM{{ (item.item.price * item.quantity).toFixed(2) }}
            </p>
          </div>

          <div class="flex justify-end font-semibold text-lg mt-3">
            Total: RM{{ total.toFixed(2) }}
          </div>
        </div>

        <!-- CHECKOUT FORM -->
        <form @submit.prevent="submit">
          <!-- Shipping Address -->
          <div class="mb-4">
            <label class="block font-medium mb-1">Shipping Address</label>
            <input
              v-model="form.shipping_address"
              type="text"
              class="w-full border rounded px-3 py-2"
              placeholder="Enter your shipping address"
            />
            <!-- Error Message -->
            <p v-if="errors.shipping_address" class="text-red-600 text-sm mt-1">
              {{ errors.shipping_address }}
            </p>
          </div>

          <!-- Card Number -->
          <div class="mb-4">
            <label class="block font-medium mb-1">Card Number</label>
            <input
              v-model="form.card_number"
              type="text"
              class="w-full border rounded px-3 py-2"
              placeholder="Enter your card number"
            />
            <!-- Error Message -->
            <p v-if="errors.card_number" class="text-red-600 text-sm mt-1">
              {{ errors.card_number }}
            </p>
          </div>

          <!-- BUTTONS -->
          <div class="mt-6 flex justify-end gap-3">
            <button
              type="button"
              @click="$inertia.visit(route('cart.index'))"
              class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
            >
              Cancel
            </button>

            <button
              type="submit"
              class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
            >
              Confirm Checkout
            </button>
          </div>
        </form>
      </div>
  </AuthenticatedLayout>
</template>
