<template>
    <div class="mt-14">
        <div class="step-container">
            <div class="step-container_item grid grid-cols-[200px_1fr] mb-4">
                <div class="mr-24"><h2 class="font-semibold">Meal</h2></div>
                <div class=""><p>{{ dataMeal[formStep1.meal] }}</p></div>
            </div>
            <div class="step-container_item grid grid-cols-[200px_1fr] mb-4">
                <div class="mr-24"><h2 class="font-semibold">No. of. people</h2></div>
                <div class=""><p>{{ formStep1.count_people }}</p></div>
            </div>
            <div class="step-container_item grid grid-cols-[200px_1fr] mb-4">
                <div class="mr-24"><h2 class="font-semibold">Restaurant</h2></div>
                <div class=""><p>{{ formStep2.restaurant }}</p></div>
            </div>
            <div class="step-container_item grid grid-cols-[200px_1fr] mb-4">
                <div class="mr-24"><h2 class="font-semibold">dishes</h2></div>
                <ul class="border border-black w-[200px] p-2">
                    <li
                        v-for="(item, index) in formStep3"
                        :key="index"
                        class="pb-2"
                    >
                        {{ item.name }} - {{ item.number_dish }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex items-center justify-between mt-12">
            <el-button type="primary" plain @click="handleBack">Previous</el-button>
            <el-button type="primary" plain @click="handleContinue">Submit</el-button>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    dataMeal: {
        type: Object,
        required: true
    },
    formStep1: {
        type: Object,
        required: true
    },
    formStep2: {
        type: Object,
        required: true
    },
    formStep3: {
        type: Object,
        required: true
    },
})
const emits = defineEmits(['continue', 'back'])

const handleBack = () => {
    emits('back', {step: 4})
}

const handleContinue = () => {
    emits('continue', {step: 4})
}
</script>
