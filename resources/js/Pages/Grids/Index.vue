<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';
import GridView from "@/Pages/Grids/components/GridView.vue";

const {props} = usePage()

</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6  flex justify-between">
                        <div class="text-gray-900 text-2xl">
                            Grids
                        </div>
                        <Link :href="route('grids.create')" class="bg-primary text-white px-4 py-2 rounded-lg">Create
                            Grid
                        </Link>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid ">
                        <Link :href="route('grids.create')" class="bg-white p-5 border rounded-lg"
                              v-for="grid in props.grids">
                                <grid-view :name="grid.name"/>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
