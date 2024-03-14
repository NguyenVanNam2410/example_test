<template>
    <div class="mt-6 w-full flex justify-center">
        <el-steps style="width: 800px" :active="stepActive" finish-status="success" simple>
            <el-step title="Step 1" />
            <el-step title="Step 2" />
            <el-step title="Step 3" />
            <el-step title="Step 4" />
        </el-steps>
    </div>

    <div class="w-[800px] mx-auto mt-4">
        <Step1
            v-if="stepActive === 1"
            :form="ruleForm"
            :dataMeal="dataMeal"
            @continue="handleContinue"
        />
        <Step2
            :form="ruleForm"
            :dataRestaurants="dataRestaurants"
            v-if="stepActive === 2"
            @back="handleBackStepForm"
            @continue="handleContinue"
        />
    </div>
</template>

<script setup>
    import axios from 'axios';
    import {onMounted, ref} from "vue";
    import Step1 from "./Step1.vue";
    import Step2 from "./Step2.vue";
    const stepActive = ref(1)
    const data = ref([])
    const dataMeal = ref([
        { id: 1, name: 'breakfast'},
        { id: 2, name: 'lunch' },
        { id: 3, name: 'dinner'},
    ])
    const dataRestaurants = ref()
    const ruleForm = ref({
        count_people: null,
        meal: null,
    })
    const errors = ref({})

    const fetchData = async () => {
        try {
            const response = await axios.post('/api/data');
            if (response.data.status_code === 200) {
                data.value = response.data.data.dishes;
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    const next = () => {
        if (stepActive.value++ > 2) stepActive.value = 0
    }

    const handleBackStepForm = ({ step, form }) => {
        switch (step) {
            case 1:
                ruleForm.value = form
                stepActive.value--
                break
            case 2:
                formLevel.value = form
                stepActive.value--
                break
            case 3:
                formSocial.value = form
                stepActive.value--
                break
        }
    }

    const handleContinue = async ({ form, step }) => {
        console.log(step)
        switch (step) {
            case 1:
                ruleForm.value = form
                stepActive.value++
                break
            case 2:
                // formSocial.value = form
                stepActive.value++
                break
            case 3:
                // formLevel.value = form
                stepActive.value++
                break
            case 4:
                // step.value = form
                // await handleAsyncStorePersonnel()
                break
        }
    }
    onMounted(async () => {
        await fetchData()
    })
</script>
