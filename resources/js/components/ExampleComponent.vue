<template>
    <div class="mt-6 w-full flex justify-center">
        <el-steps style="width: 800px" :active="stepActive" finish-status="success" simple>
            <el-step title="Step 1" />
            <el-step title="Step 2" />
            <el-step title="Step 3" />
            <el-step title="Review" />
        </el-steps>
    </div>

    <div class="w-[800px] mx-auto mt-4">
        <Step1
            v-if="stepActive === 1"
            :form="formStep1"
            :dataMeal="dataMeal"
            @continue="handleContinue"
        />
        <Step2
            :form="formStep2"
            :dataRestaurants="dataRestaurants"
            v-if="stepActive === 2"
            @back="handleBackStepForm"
            @continue="handleContinue"
        />
        <Step3
            :form="formStep3"
            :formStep1="formStep1"
            :dataFoodStep3="dataFoodStep3"
            v-if="stepActive === 3"
            @back="handleBackStepForm"
            @continue="handleContinue"
        />
        <Step4
            :formStep1="formStep1"
            :formStep2="formStep2"
            :formStep3="formStep3"
            :dataMeal="dataMeal"
            v-if="stepActive === 4"
            @back="handleBackStepForm"
            @continue="handleContinue"
        />
    </div>
</template>

<script setup>
    import axios from 'axios';
    import {onMounted, ref} from "vue";
    import { ElMessage } from 'element-plus'
    import Step1 from "./Step1.vue";
    import Step2 from "./Step2.vue";
    import Step3 from "./Step3.vue";
    import Step4 from "./Step4.vue";

    const stepActive = ref(1)
    const data = ref([])
    const dataMeal = ref({
        1: 'breakfast',
        2: 'lunch',
        3: 'dinner',
    })
    const dataRestaurants = ref()
    const dataFoodStep3 = ref()
    const formStep1 = ref({
        count_people: null,
        meal: null,
    })
    const formStep2 = ref({
        restaurant: null,
    })
    const formStep3 = ref([
        { name: '', number_dish: null, }
    ])

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
                formStep1.value = form
                stepActive.value--
                break
            case 2:
                formStep2.value = form
                stepActive.value--
                break
            case 3:
                formStep3.value = form
                stepActive.value--
                break
            case 4:
                stepActive.value--
                break
        }
    }

    const handleContinue = async ({ form, step }) => {
        switch (step) {
            case 1:
                formStep1.value = form
                const breakfastRestaurants = [];
                data.value.forEach(dish => {
                    if (dish.availableMeals.includes(dataMeal.value[formStep1.value.meal])) {
                        if (!breakfastRestaurants.includes(dish.restaurant)) {
                            breakfastRestaurants.push(dish.restaurant);
                        }
                    }
                });
                dataRestaurants.value = breakfastRestaurants
                stepActive.value++
                break
            case 2:
                formStep2.value = form
                dataFoodStep3.value = data.value.filter(dish => {
                    return dish.availableMeals.includes(dataMeal.value[formStep1.value.meal]) && dish.restaurant === formStep2.value.restaurant
                }).map(dish => {
                    return {
                        name: dish.name,
                        disabled: false
                    };
                });
                stepActive.value++
                break
            case 3:
                formStep3.value = form
                stepActive.value++
                break
            case 4:
                await handleDish()
                await fetchData()
                break
        }
    }

    const handleDish = async () => {
        const data = {
            'meal': formStep1.value.meal,
            'count_people': formStep1.value.count_people,
            'restaurant': formStep2.value.restaurant,
            'dishs': formStep3.value
        }
        try {
            const response = await axios.post('/api/dish', data);
            if (response.data.status_code === 200) {
                ElMessage({
                    message: response.data.message,
                    type: 'success',
                })
                stepActive.value = 1

                formStep1.value ={
                    count_people: null,
                    meal: null,
                }
                formStep2.value = {
                    restaurant: null,
                }
                formStep3.value = [
                    { name: '', number_dish: null, }
                ]
            } else {
                ElMessage.error('Error')
            }

        } catch (error) {
            ElMessage.error(error)
        }
    }

    onMounted(async () => {
        await fetchData()
    })
</script>
