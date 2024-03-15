<template>
    <div class="">
        <div
            v-for="(item, index) in formSubmit"
            :key="index"
            class="step3-input flex gap-2 items-end"
        >
            <div class="flex-1">
                <p>Please select a no of dish</p>
                <el-select
                    v-model="item.name"
                    placeholder="-----------"
                    @change="changeDataFoodStep3()"
                    class="h-full"
                >
                    <el-option
                        class="h-[38px]"
                        v-for="(option, index) in dataFoodStep3" :key="index"
                        :value="option.name"
                        :label="option.name"
                        :disabled="option.disabled"
                    />
                </el-select>
            </div>
            <div class="flex-1">
                <p>Please select a no of dish</p>
                <el-input-number
                    v-model.number="item.number_dish"
                    type="text"
                    autocomplete="off"
                    :min="1"
                    class="w-full"
                />
            </div>
            <div v-if="formSubmit.length > 1" class="flex-1">
                <el-button
                    @click.prevent="removeDomain(item)"
                >
                    Delete
                </el-button>
            </div>
        </div>

        <el-button v-if="formSubmit.length < dataFoodStep3.length" class="mt-12" @click="addDomain">New domain</el-button>
        <div class="flex items-center justify-between mt-12">
            <el-button type="primary" plain @click="handleBack">Previous</el-button>
            <el-button type="primary" plain @click="handleContinue">Next</el-button>
        </div>
    </div>
</template>

<script setup>
import {computed, ref} from "vue";
import { ElMessage } from 'element-plus'

const props = defineProps({
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
const formSubmit = ref([...props.form])
const dataFoodStep3 = ref([...props.dataFoodStep3])
const removeDomain = (item) => {
    const index = formSubmit.value.indexOf(item)
    if (index !== -1) {
        formSubmit.value.splice(index, 1)
    }
    changeDataFoodStep3()
}

const addDomain = () => {
    formSubmit.value.push({
        name: '',
        number_dish: null,
    })
}

const handleBack = () => {
    emits('back', {step: 3, form: formSubmit.value})
}

const handleContinue = () => {
    let totalCount = formSubmit.value.reduce((count, dish) => {
        if (dish.hasOwnProperty('number_dish')) {
            return count + dish.number_dish;
        } else {
            return count;
        }
    }, 0);

    if (props.formStep1.count_people > totalCount) {
        return ElMessage.error('The number of servings must be greater than the number of people.')
    } else {
        emits('continue', {form: formSubmit.value, step: 3})
    }
}

const changeDataFoodStep3 = () => {
    const bMap = {};
    formSubmit.value.forEach(item => {
        bMap[item.name] = item;
    });

    dataFoodStep3.value.forEach(item => {
        const itemName = item.name;
        item.disabled = !!bMap[itemName];
    });
}
</script>
