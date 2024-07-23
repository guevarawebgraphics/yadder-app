<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const form = useForm({
    password: null,
})

</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <Link href="/">
                <ApplicationLogo class="" />
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white border-2 border-[#F6921E] overflow-hidden rounded-2xl"
        >
            <div class="">
                <h1 class="text-xl font-bold text-center mb-3 text-red-600">Site Restricted</h1>

                <form class="flex flex-col gap-3" @submit.prevent="form.post('/restricted')">
                    <!-- email -->
                    <input type="password" v-model="form.password">
                    <small v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</small>

                    <button class="text-white block rounded bg-[#F6921E] border p-2" type="submit" :disabled="form.processing">Verify</button>
                </form>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
