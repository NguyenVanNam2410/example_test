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
        <el-form-item label="Please select a meal" prop="meal">
            <el-select v-model="formSubmit.meal" placeholder="-----------">
                <el-option
                    v-for="(option, index) in dataMeal" :key="option.id"
                    :value="index"
                    :label="option"
                />
            </el-select>
        </el-form-item>
        <el-form-item label="Please enter number of people" prop="count_people">
            <el-input-number
                v-model.number="formSubmit.count_people"
                type="text"
                autocomplete="off"
                :min="1"
                :max="10"
                class="w-full"
            />
        </el-form-item>

        <div class="flex items-center justify-end">
            <el-button type="primary" plain @click="handleContinue">Next</el-button>
        </div>
    </el-form>
</template>

<script setup>
import {computed, reactive, ref} from "vue";
const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    dataMeal: {
        type: Object,
        required: true
    }
})
const emits = defineEmits(['continue'])
const formSubmit = ref({ ...props.form })
const refFormInformation = ref()
const formRules = computed(() => {
    return {
        count_people: {
            required: true,
            validator: validateNumber,
            message: 'Please enter number of people',
            trigger: 'blur',
        },
        meal: {
            required: true,
            message: 'Please select a meal',
            trigger: 'change',
        },
    }
})

const validateNumber = (rule, value, cb) => {
    const regex = /^[0-9]+$/
    if(!regex.test(value)) {
        cb(new Error())
    }else{
        cb()
    }
}

const handleContinue = () => {
    refFormInformation.value.validate((valid) => {
        if(valid) {
            emits('continue', { form: formSubmit.value, step : 1 })
        }
    })
}
</script>
