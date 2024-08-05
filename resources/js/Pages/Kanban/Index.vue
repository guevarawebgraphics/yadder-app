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

    // Debug: Log the 'to' and 'from' elements
    console.log('to element:', to);
    console.log('from element:', from);

    const newStatus = to ? to.closest('[data-status]')?.getAttribute('data-status') : null;
    const oldStatus = from ? from.closest('[data-status]')?.getAttribute('data-status') : null;

    // Debug: Log the statuses
    console.log('newStatus:', newStatus);
    console.log('oldStatus:', oldStatus);

    if (!newStatus || !oldStatus) {
        console.error('Dropped element does not have a valid status');
        return;
    }

    if (!item || !item.__draggable_context) {
        console.error('Dropped item is undefined');
        return;
    }

    const taskElement = item.__draggable_context.element;

    if (!taskElement || !taskElement.id) {
        console.error('Dropped element is undefined or does not have an id');
        return;
    }

    const task = tasks.value.find(task => task.id === taskElement.id);
    if (task) {
        task.status = newStatus;

        // Remove the task from its old position and add it to the new one
        const taskIndex = tasks.value.indexOf(task);
        tasks.value.splice(taskIndex, 1);
        tasks.value.splice(newIndex, 0, task);
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
                            itemKey="id"
                            class="min-h-[50px]"
                        >
                            <template #item="{ element }">
                                <div 
                                    class="bg-white p-2 mb-2 rounded shadow"
                                >
                                    {{ element.title }}
                                </div>
                            </template>
                            <!-- Empty placeholder to ensure the column is always droppable -->
                            <template #footer>
                                <div v-if="getColumnTasks(column.status).value.length === 0" class="h-10"></div>
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
