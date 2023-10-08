<script setup>
import Toast from '../components/Toast.vue'
import { useAlertStore } from '../store/toast.js';
import useAjax from '../composables/ajax.js'
const { ajax } = useAjax()
import { ref, reactive } from 'vue'
import { GlobeAltIcon, FlagIcon, GlobeAmericasIcon } from '@heroicons/vue/24/outline'
import LangFlag from 'vue-lang-code-flags'

let metrics = reactive({year: 0, month: 0, week: 0});
let recentVisits = [];
let visits = [];

async function fetchData() { 
    const toastStore = useAlertStore(); 

    let response = await ajax('get', 'dashboard'); 
    if(response.status === 200){ 
      recentVisits = response.data.recentVisits;
      metrics.year = response.data.yearMetric;
      metrics.month = response.data.monthMetric;
      metrics.week = response.data.weekMetric; 
      visits = response.data.visits;
    } else {
      toastStore.error('dashboard.fetch_error');
    }
}
fetchData();
</script>

<template>

  <Toast />



  <div class="container w-full mx-auto">

<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

    <!--Console Content-->
    
    <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
            <!--Metric Card-->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
              <div class="flex flex-row -mx-3">
              <div class="flex-none w-2/3 max-w-full px-3">
              <div>
              <p class="mb-0 font-sans font-semibold leading-normal text-sm">{{$t('dashboard.metrics_year')}}</p>
              <h5 class="mb-0 font-bold">
              {{ metrics.year }} {{$t('dashboard.metrics_countries')}}
              </h5>
              </div>
              </div>
              <div class="px-3 text-right basis-1/3">
              <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                <GlobeAltIcon class="ni leading-none ni-money-coins text-lg relative text-white" />
              </div>
              </div>
              </div>
              </div>
            </div>
            
            <!--/Metric Card-->
        </div>
        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
            <!--Metric Card-->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
              <div class="flex flex-row -mx-3">
              <div class="flex-none w-2/3 max-w-full px-3">
              <div>
              <p class="mb-0 font-sans font-semibold leading-normal text-sm">{{$t('dashboard.metrics_month')}}</p>
              <h5 class="mb-0 font-bold">
              {{ metrics.month }} {{$t('dashboard.metrics_countries')}}
              </h5>
              </div>
              </div>
              <div class="px-3 text-right basis-1/3">
              <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                <FlagIcon class="ni leading-none ni-money-coins text-lg relative text-white" />
              </div>
              </div>
              </div>
              </div>
            </div>
            <!--/Metric Card-->
        </div>
        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
            <!--Metric Card-->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
              <div class="flex flex-row -mx-3">
              <div class="flex-none w-2/3 max-w-full px-3">
              <div>
              <p class="mb-0 font-sans font-semibold leading-normal text-sm">{{$t('dashboard.metrics_week')}}</p>
              <h5 class="mb-0 font-bold">
              {{ metrics.week }} {{$t('dashboard.metrics_countries')}}
              </h5>
              </div>
              </div>
              <div class="px-3 text-right basis-1/3">
              <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                <GlobeAmericasIcon class="ni leading-none ni-money-coins text-lg relative text-white" />
              </div>
              </div>
              </div>
              </div>
            </div>
            <!--/Metric Card-->
        </div>
        
    </div>

    <!--Divider-->
    <hr class="border-b-2 border-gray-400 mx-4">

    <div v-if="visits.length > 0" class="w-full p-3">
            <!--Table Card-->
            <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
          <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
          <div class="flex flex-wrap mt-0 -mx-3">
          <div class="flex-none w-7/12 max-w-full px-3 mt-0 lg:w-1/2 lg:flex-none">
          <h6>{{$t('dashboard.your_travels')}}</h6>
          </div>
          </div>
          </div>
          <div class="flex-auto p-6 px-0 pb-2">
          <div class="overflow-x-auto ps">
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
          <thead class="align-bottom">
          <tr>
          <th class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">{{$t('dashboard.country')}}</th>
          <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">{{$t('dashboard.dates')}}</th>
          </tr>
          </thead>
            <tbody>
            <tr v-for="row in visits" :key="row.id">
            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
            <div class="flex px-2 py-1">
            <div>
            <img src="../assets/img/small-logos/logo-xd.svg" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-sm h-9 w-9 rounded-xl" alt="xd">
            </div>
            <div class="flex flex-col justify-center">
            <h6 class="mb-0 leading-normal text-sm"><img class="mr-2" style="display:inline;" :src="'img/flags/24x24/' + row.code.toLowerCase() + '.png'"> {{ row.name }}</h6>
            </div>
            </div>
            </td>

            <td class="p-2 leading-normal align-middle bg-transparent border-b text-sm whitespace-nowrap">
            <span class="font-semibold leading-tight"> {{ row.dates }} </span>
            </td>
            
          </tr>

          </tbody>
          </table>
          <div class="ps__rail-x" style="left: 0px; top: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; left: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
          </div>
          </div>
            <!--/table Card-->
        </div>

    <div v-else>
      <div class="w-full p-3">
        <div class="p-8 relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
          {{$t('dashboard.no_data')}}
        </div>
       
      </div>

    </div>

    <div class="flex flex-row flex-wrap flex-grow mt-2">

        <div class="w-full md:w-1/2 p-3">
            GRAPH 1
        </div>

        <div class="w-full md:w-1/2 p-3">
            <!--Graph Card-->
            GRAPH 2
            <!--/Graph Card-->
        </div>

        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
            <!--Graph Card-->
            GRAPH 3
            <!--/Graph Card-->
        </div>

        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
            <!--Graph Card-->
            GRAPH 4
            <!--/Graph Card-->
        </div>

        

        


    </div>

    <!--/ Console Content-->

</div>


</div>
</template>
