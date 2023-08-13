<template>
    <div v-if="infos.length > 0">
        <select v-model="timeChart" @change="filterData(timeChart)" class="h-11 md:h-8 py-0 mb-5 w-full">
            <option value="byTime1">1 mois</option>
            <option value="byTime2">2 mois</option>
            <option value="byTime3">3 mois</option>
            <option value="byTime6">6 mois</option>
            <option value="byTime">1 ans</option>
            <option v-for="(year, ind) in years" :key="'optionYear' + ind" :value="'byYear' + year">Année {{ year }}</option>
            <option value="byAll">Tout</option>
        </select>
        <GChart v-if="filteredData.length > 1" type="AreaChart" :data="filteredData" :options="options"/>
        <p v-else class="text-center my-10 font-medium text-base">Aucun poids ne correspond à cette période</p>
    </div>
    <p v-else class="text-center my-16 font-bold text-lg">Aucun poids enregistré</p>
</template>

<script setup>
    import { onBeforeMount } from 'vue';
import { reactive, ref, onMounted } from 'vue';
    import { GChart } from 'vue-google-charts';

    const options = reactive({
        title: 'Votre courbe de poids',
        hAxis: { title: 'Date', titleTextStyle: { color: '#333' } },
        vAxis: { minValue: 0 },
        chartArea: { width: '75%', height: '70%' },
        height: 450,
    });

    const timeChart = ref('byTime1');

    const data = ref([]);
    const filteredData = ref([]);
    const reverseInfos = ref([]);

    const props = defineProps({
        infos: Array,
        years: Array,
    });

    onBeforeMount(() => {
        reverseInfos.value = props.infos.reverse();
    });

    onMounted(() => {
        if (reverseInfos.value.length > 0) {
            let tempArr = [
                ['Date', 'Poids']
            ];
            let tempFilteredArr = [
                ['Date', 'Poids']
            ];
            const currentDate = new Date();

            reverseInfos.value.forEach(el => {
                const date = new Date(el.record_date);
                const timestampDate = Date.parse(el.record_date);
                const result = currentDate.getTime() - timestampDate;
                
                const info = [
                    date.toLocaleDateString('FR'),
                    el.weight,
                ]

                tempArr.push(info);
                
                if (result < 2592000000) {
                    tempFilteredArr.push(info);
                }
            });

            if (tempFilteredArr.length === 1) {
                timeChart.value = 'byAll';
                data.value = tempArr;
                
                return filteredData.value = tempArr;
            }

            data.value = tempArr;
            filteredData.value = tempFilteredArr;
        }
    });

    const filterData = (option) => {
        let time = 0;
        let tempFilteredArr = [
            ['Date', 'Poids']
        ];
        
        if(option === "byTime1") {
            time = 2592000000;
        } else if(option === "byTime2") {
            time = 5184000000;
        } else if(option === "byTime3") {
            time = 7776000000; 
        } else if(option === "byTime6") {
            time = 15552000000;  
        } else if(option === "byTime") {
            time = 31104000000;
        } else if(option === "byAll") {
            return filteredData.value = data.value;
        } else {
            const slicedOption = option.slice(6);
           
            const filteredByYearsArr = reverseInfos.value.filter(el => {
                const splitedDate = el.record_date.split('-');
                
                if(splitedDate[0] === slicedOption) {
                    return el;
                }
            });

            filteredByYearsArr.forEach(el => {
                const date = new Date(el.record_date);

                const info = [
                    date.toLocaleDateString('FR'),
                    el.weight,
                ];

                tempFilteredArr.push(info);
            });
            
            return filteredData.value = tempFilteredArr;;
        }

        if (reverseInfos.value.length > 0) {
            const currentDate = new Date();

            reverseInfos.value.forEach(el => {
                const date = new Date(el.record_date);
                const timestampDate = Date.parse(el.record_date);
                const result = currentDate.getTime() - timestampDate;
                
                const info = [
                    date.toLocaleDateString('FR'),
                    el.weight,
                ]
                
                if (result < time) {
                    tempFilteredArr.push(info);
                }
            });

            return filteredData.value = tempFilteredArr;
        }
    };
</script>