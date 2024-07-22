<script setup>
import {useForm} from '@inertiajs/vue3'
import GuestLayout from "@/Layouts/GuestLayout.vue";

const form = useForm({
    password: null,
})

</script>

<template>
    <GuestLayout>
        <div class="">
            <h1 class="text-4xl font-bold text-center mb-3 text-red-600">Site Restricted</h1>

            <form class="flex flex-col gap-3" @submit.prevent="form.post('/restricted')">
                <!-- email -->
                <input type="password" v-model="form.password">
                <small v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</small>

                <button class="block rounded bg-gray-700 border p-2" type="submit" :disabled="form.processing">Verify</button>
            </form>
        </div>
    </GuestLayout>

</template>

<style scoped>

</style>
