<template>
    <el-form
        ref="refFormInformation"
        style="max-width: 800px"
        :model="formSubmit"
        :rules="formRules"
        label-width="auto"
        class="demo-ruleForm"
        label-position="top"
        size="default"
    >
        <el-form-item label="Meal" prop="meal">
            <el-select v-model="formSubmit.restaurant" placeholder="-----------">
                <el-option
                    v-for="option in dataRestaurants" :key="option.id"
                    :value="option.id"
                    :label="option.name"
                />
            </el-select>
        </el-form-item>
        <div class="flex items-center justify-between">
            <el-button type="primary" plain @click="handleBack">Previous</el-button>
            <el-button type="primary" plain @click="handleContinue">Next</el-button>
        </div>
    </el-form>
</template>

<script setup>
import {computed, ref} from "vue";
const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    dataRestaurants: {
        type: Object,
        required: true
    }
})
const emits = defineEmits(['continue', 'back'])
const formSubmit = ref({ ...props.form })
const refFormInformation = ref()
const formRules = computed(() => {
    return {
        restaurant: {
            required: true,
            message: 'Vui lòng chọn nhà hàng',
            trigger: 'change',
        },
    }
})

const handleBack = () => {
    emits('back', { step: 2, form: formSubmit.value })
}

const handleContinue = () => {
    refFormInformation.value.validate((valid) => {
        if(valid) {
            emits('continue', { form: formSubmit.value, step : 2 })
        }
    })
}
</script>
