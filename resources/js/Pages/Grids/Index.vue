<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';
import GridView from "@/Pages/Grids/components/GridView.vue";

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
                        <Link v-if="!grid" :href="route('grids.create')" class="btn btn-primary">Create
                            Grid
                        </Link>
                    </div>
                </div>
            </div>

            <div class="mx-auto sm:px-6 lg:px-8 p-5">
                <div v-if="grid" class="shadow-sm sm:rounded-lg bg-white p-2 w-fit">
                    <grid-view :data="grid"/>
                </div>
                <div v-else
                     class="min-h-[200px] flex flex-col justify-center items-center shadow-sm sm:rounded-lg bg-white p-2">
                    <p class="mb-5 text-2xl"> Create your grid now! </p>
                    <Link class="btn btn-primary" :href="route('grids.create')">Create Grid
                    </Link>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
