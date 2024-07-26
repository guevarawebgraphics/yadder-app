<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';
import GridView from "@/Pages/Grids/components/GridView.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const {props} = usePage()

const {grid} = props;

</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 mb-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex justify-between">
                        <div class="text-gray-900 text-2xl">
                            Grids
                        </div>
                        <Link :href="route('grids.create')" class="bg-primary text-white px-4 py-2 rounded-lg">Create
                            Grid
                        </Link>
                    </div>
                </div>
            </div>

            <div class="mx-auto sm:px-6 lg:px-8 p-5">
                <div class="shadow-sm sm:rounded-lg bg-white p-2 w-fit">
                    <grid-view v-if="grid" :data="grid"/>
                    <div v-else class="min-h-[200px] flex flex-col justify-center items-center">
                        <p class="mb-5 text-2xl"> Create your grid now! </p>
                        <Link class="bg-primary text-white px-4 py-2 rounded-lg" :href="route('grids.create')">Create Grid</Link>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
