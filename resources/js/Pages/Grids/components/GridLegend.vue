<script setup>

const {zone} = defineProps(['zone'])

</script>

<template>
    <table class="w-[200px] border border-collapse mx-auto my-5">
        <tbody>
        <tr class="border">
            <td
                class="border text-center text-[8px] w-1/3 p-2"
                :class="{'bg-primary text-white': zone === 1}"
            >
                Zone 1
            </td>
            <td
                class="border text-center text-[8px] w-1/3 p-2"
                :class="{'bg-primary text-white': zone === 2}"
            >
                Zone 2
            </td>
            <td class="border text-center text-[8px] w-1/3 p-2"
                :class="{'bg-primary text-white': zone === 3}"
            >
                Zone 3
            </td>
        </tr>
        <tr class="border">
            <td class="border text-center text-[8px] w-1/3 p-2"
                :class="{'bg-primary text-white': zone === 8}"

            >
                Zone 8
            </td>
            <td class="border text-center text-[8px] w-1/3 p-2 bg-gray-100 font-semibold "> MAIN GOAL</td>
            <td class="border text-center text-[8px] w-1/3 p-2"
                :class="{'bg-primary text-white': zone === 4}"
            >
                Zone 4
            </td>
        </tr>
        <tr class="border">
            <td class="border text-center text-[8px] w-1/3 p-2"
                :class="{'bg-primary text-white': zone === 7}"

            >
                Zone 7
            </td>
            <td class="border text-center text-[8px] w-1/3 p-2"
                :class="{'bg-primary text-white': zone === 6}"

            >
                Zone 6
            </td>
            <td class="border text-center text-[8px] w-1/3 p-2"
                :class="{'bg-primary text-white': zone === 5}"
            >
                Zone 5
            </td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
