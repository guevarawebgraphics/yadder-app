<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import draggable from 'vuedraggable';

const tasks = ref([
    { id: 1, title: 'Task 1', status: 'todo' },
    { id: 2, title: 'Task 2', status: 'in-progress' },
    { id: 3, title: 'Task 3', status: 'done' },
]);

const columns = ref([
    { name: 'To Do', status: 'todo' },
    { name: 'In Progress', status: 'in-progress' },
    { name: 'Done', status: 'done' },
]);

const getColumnTasks = (status) => computed(() => tasks.value.filter(task => task.status === status));

const onTaskDrop = (event) => {
    console.log('Drop Event:', event);
    const { newIndex, oldIndex, to, from, item } = event;
    console.log('New Index:', newIndex);
    console.log('Old Index:', oldIndex);
    console.log('Item:', item);
    console.log('To:', to);
    console.log('From:', from);

    const newStatus = to.getAttribute('data-status');
    const oldStatus = from.getAttribute('data-status');

    if (!item || !item.id) {
        console.error('Dropped item is undefined or does not have an id');
        return;
    }

    const task = tasks.value.find(task => task.id === item.id);
    if (task) {
        task.status = newStatus;
    }

    console.log('Updated Tasks:', tasks.value);
};
</script>

<template>
    <Head title="Kanban" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kanban</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex space-x-4">
                    <div
                        v-for="column in columns"
                        :key="column.status"
                        class="w-1/3 bg-gray-200 p-4 rounded"
                        :data-status="column.status"
                    >
                        <h3 class="font-semibold text-lg mb-4">{{ column.name }}</h3>
                        <draggable 
                            :list="getColumnTasks(column.status).value" 
                            group="tasks" 
                            @end="onTaskDrop"
                        >
                            <template #item="{ element }">
                                <div 
                                    class="bg-white p-2 mb-2 rounded shadow"
                                >
                                    {{ element.title }}
                                </div>
                            </template>
                        </draggable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.draggable {
    min-height: 300px;
}
</style>
