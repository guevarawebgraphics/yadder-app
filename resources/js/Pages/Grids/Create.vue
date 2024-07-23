<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    name: ''
});

</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>


        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Create Grid</h2>
                        </header>
                        <form @submit.prevent="form.post(route('grids.store'))">
                            <TextInput

                                id="password"
                                v-model="form.name"
                                type="text"
                                class="mt-1 mb-3 block w-full"
                            />

                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                        </form>
                    </section>
                </div>
            </div>

        </div>


    </AuthenticatedLayout>
</template>

<style scoped>

</style>
