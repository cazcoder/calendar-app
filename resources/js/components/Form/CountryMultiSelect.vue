<template>
  <div class="ui vertical segment mb-3 mt-3">
    <multiSelect
      :options="options"
      :selected-options="items"
      placeholder="select item"
      @select="onSelect"
    >
    </multiSelect>
   </div>  
</template>

<script>
import { MultiSelect } from "vue-search-select"
import { useCountryStore }  from '../../store/country'

const countryStore = useCountryStore()

export default {
  data () {
    return {
      options: [],
      searchText: '', // If value is falsy, reset searchText & searchItem
      items: [],
      lastSelectItem: {},
      clickedDay: '',
      text: ''
    }
  },
  components: {
    MultiSelect
  },
  methods: {
    onSelect (items, lastSelectItem) {
      this.items = items
      this.lastSelectItem = lastSelectItem
      //hand info to parent so that when the assign button is clicked the country selections are set
      this.$emit('selectedCountryItem', this.items);
    },
    // deselect option
    reset () {
      this.items = [] // reset
    },
  },

  async created(){ 
    let clickedDay = countryStore.clickedDay;
    
    await countryStore.fetchModalData(clickedDay); 
    this.options = countryStore.countries;
    this.items = countryStore.dayCountries;
  }
}
</script>


