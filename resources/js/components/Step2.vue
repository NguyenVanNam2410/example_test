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
                    v-for="option in dataMeal" :key="option.id"
                    :value="option.id"
                    :label="option.name"
                />
            </el-select>
        </el-form-item>
        <div class="flex items-center justify-end">
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
const emits = defineEmits(['continue'])
const formSubmit = ref({ ...props.form })
const refFormInformation = ref()
const formRules = computed(() => {
    return {
        restaurant: {
            required: true,
            message: 'Vui lòng chọn meal',
            trigger: 'change',
        },
    }
})

const handleContinue = () => {
    refFormInformation.value.validate((valid) => {
        if(valid) {
            emits('continue', { form: formSubmit.value, step : 1 })
        }
    })
}
</script>
