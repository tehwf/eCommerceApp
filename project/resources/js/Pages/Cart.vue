<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  cartItems: Array
})

const updateForm = useForm({})
const deleteForm = useForm({})

const totalPrice = computed(() => {
  return props.cartItems.reduce((sum, cart) => {
    return sum + Number(cart.item.price) * Number(cart.quantity)
  }, 0)
})

const changeQuantity = (cart, newQty) => {
  if (newQty < 1) return

  if (newQty > cart.item.quantity) {
    alert('Cannot exceed available stock')
    return
  }

  router.patch(route('cart.update', cart.id), { quantity: newQty }, {
    preserveScroll: true,
    onSuccess: () => {
    }
  })
}

const removeItem = (cartId) => {
  if (confirm('Are you sure you want to remove this item?')) {
    deleteForm.delete(route('cart.destroy', cartId), {
      preserveScroll: true,
      onSuccess: () => {
        console.log('Item removed successfully')
      },
    })
  }
}
</script>

<template>
  <Head title="My Cart" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-gray-800">My Cart</h2>
    </template>

    <div class="py-12 max-w-6xl mx-auto">
      <div class="bg-white shadow rounded-lg p-6">
        <div v-if="cartItems.length">
          <div class="space-y-4">
            <div
              v-for="cart in cartItems"
              :key="cart.id"
              class="py-6 border-b last:border-b-0"
            >
              <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1 min-w-0">
                  <div class="w-24 h-24 flex-shrink-0 bg-gray-50 rounded overflow-hidden flex items-center justify-center">
                    <img
                      v-if="cart.item.image_url"
                      :src="cart.item.image_url"
                      alt="Product Image"
                      class="w-full h-full object-cover"
                    />
                    <div v-else class="text-gray-400 text-sm">No image</div>
                  </div>

                  <div class="min-w-0">
                    <h3 class="font-semibold text-lg truncate">{{ cart.item.name }}</h3>
                    <p class="text-gray-600 mt-1">RM {{ Number(cart.item.price).toFixed(2) }}</p>
                    <p class="text-sm text-gray-400 mt-1">In stock: {{ cart.item.quantity }}</p>
                  </div>
                </div>

                <div class="flex items-center space-x-2">
                  <button
                    @click="changeQuantity(cart, cart.quantity - 1)"
                    class="w-9 h-9 flex items-center justify-center rounded-md bg-gray-100 hover:bg-gray-200"
                    aria-label="decrease"
                  >−</button>

                  <div class="w-12 text-center text-base font-medium">
                    {{ cart.quantity }}
                  </div>

                  <button
                    @click="changeQuantity(cart, cart.quantity + 1)"
                    class="w-9 h-9 flex items-center justify-center rounded-md bg-gray-100 hover:bg-gray-200"
                    aria-label="increase"
                  >+</button>
                </div>

                <div class="flex-none text-right md:text-right">
                  <p class="font-semibold">RM {{ (Number(cart.item.price) * cart.quantity).toFixed(2) }}</p>
                  <button
                    @click="removeItem(cart.id)"
                    class="text-red-500 text-sm mt-1 hover:underline"
                   >
                    Remove
                   </button>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6 pt-4 border-t flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-right md:text-left w-full md:w-auto">
              <p class="text-lg font-semibold">Total: RM {{ totalPrice.toFixed(2) }}</p>
            </div>

            <div class="flex gap-3 w-full md:w-auto justify-center md:justify-end">
              <Link :href="route('products')" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Continue Shopping</Link>
              <Link
                :href="route('checkout')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md"
              >
                Proceed to Checkout
              </Link>

            </div>
          </div>
        </div>

        <div v-else class="text-center text-gray-600 py-10">
          Your cart is empty.
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
