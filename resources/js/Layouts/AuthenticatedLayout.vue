<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

import {Link, usePage} from '@inertiajs/vue3';
import {watchEffect} from "vue";
import Navigation from "@/Layouts/Partials/Navigation.vue";

const {props} = usePage()

watchEffect(() => {
    window.Laravel = window.Laravel || {}
    if (props.permissions) {
        window.Laravel.jsPermissions = props.permissions;
    }
})

</script>

<template>
    <div>
        <div class="h-screen bg-gray-100 flex">
            <div class="pb-6 bg-white w-[260px] h-screen shadow-lg flex flex-col flex-grow-0 flex-shrink-0 border-r">
                <div class="max-w-[200px] mx-auto py-6">
                    <application-logo/>
                </div>
                <navigation/>

                <ul class="mt-auto">
                    <li>
                        <Link
                            class="text-red-500 py-3 px-6 hover:bg-red-400 hover:text-white block w-full text-left transition-all ease-in-out duration-300 "
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >Logout
                        </Link>
                    </li>
                </ul>
            </div>
            <div class="flex-grow flex-shrink-0 overflow-auto" style="max-width: calc(100% - 260px); width: calc(100% - 260px)">
                <slot/>
            </div>
        </div>
    </div>
</template>
