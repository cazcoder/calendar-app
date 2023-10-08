import { defineStore } from 'pinia'
import useAjax from '../composables/ajax.js'
import { useAlertStore } from './toast.js';
import { reactive } from 'vue'
import { useUserStore }  from './user'

const { ajax } = useAjax()

export const useCountryStore = defineStore('country', {
  state: () => ({
      countries: [],
      legend: [],
      monthColors: [],
      dayCountries: [], //Used for country multiselect control
      clickedDay: '',
  }),
  getters: {
    
  },
  actions: {
    
    /**
     * Fetch all countries and country selections for a given date - used when opening the modal to assign countries
     */
    async fetchModalData(clickedDate) { 
      const toastStore = useAlertStore(); 
      let data = {date: clickedDate};

      let response = await ajax('post', 'countries/get_assigned', data); 
      if(response.status === 200){ 
        this.countries = response.data.countries;
        this.dayCountries = response.data.dayCountries; 
      } else {
        toastStore.error('toast.country_fetch_error');
      }
    },

    /**
     * Save assigned countries
     */
    async saveModalData(clickedDate, assignedCountries) { 
      const toastStore = useAlertStore(); 
      const userStore = useUserStore() 
      let data = {date: clickedDate, countries: assignedCountries}; 

      let response = await ajax('post', 'countries/save_assigned', data); 
      if(response.status === 200){
        this.legend = response.data.legend;
        this.monthColors = response.data.monthColors;
        toastStore.success('toast.save_countries_success');
      } else {
        this.groupedCountries = [];
        toastStore.error('toast.save_countries_error');
      }
    },

    /**
     * Fetch the legend and colors for each day of the month, called when navigating and upon initial page load
     */
    async fetchLegendAndMonthColors(year, month) {
      const toastStore = useAlertStore(); 
      const userStore = useUserStore() 
      let data = {year: year, month: month};

      let response = await ajax('post', 'countries/index', data); 
      if(response.status === 200){
        this.legend = response.data.legend; 
        this.monthColors = response.data.monthColors; 
      } else {
        toastStore.error('toast.fetch_calendar_data_error');
      }
    }
  },
})