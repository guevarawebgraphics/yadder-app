<script setup>

import {Link} from "@inertiajs/vue3";
</script>

<template>
    <ul>
        <li>
            <Link
                class="py-3 px-6 hover:bg-primary hover:text-white block transition-all ease-in-out duration-300 "
                :href="route('dashboard')">Dashboard
            </Link>
        </li>

        <li>
            <Link
                class="py-3 px-6 hover:bg-primary hover:text-white block transition-all ease-in-out duration-300 "
                :href="route('grids')">Grids
            </Link>
        </li>

        <li>
            <Link
                class="py-3 px-6 hover:bg-primary hover:text-white block transition-all ease-in-out duration-300 "
                :href="route('profile.edit')">Profile
            </Link>
        </li>
        <li v-if="can('view roles')">
            <Link
                class="py-3 px-6 hover:bg-primary hover:text-white block transition-all ease-in-out duration-300 "
                :href="route('roles-and-permissions')">Roles & Permissions
            </Link>
        </li>
    </ul>
</template>

<style scoped>

</style>
