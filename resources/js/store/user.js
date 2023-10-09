import { defineStore } from 'pinia'
import useAjax from '../composables/ajax.js'
import { useAlertStore } from './toast.js';
import { inject } from 'vue'
import router from "../router";

const { ajax } = useAjax()
const user = window.User;
//console.log(user);

export const useUserStore = defineStore('user', {
  state: () => ({
      user: user,
  }),
  getters: {
    loggedIn(state) {
      if(state.user){
        return true;
      } else {
        return false;
      }
    }
  },
  actions: {
    async login(data) {
      let response = await ajax('post', 'login', data); 
      if(response.status === 200){
        this.user = response.data;
        router.push({name: 'app.dashboard'});
        return true;
      } else { 
        return false;
      }
    },

    async logout() {
      let response = await ajax('get', 'logout'); 
      if(response.status === 200){
        this.user = null;
        window.User = null;
        router.push({name: 'app.login'});
        //return true;
      } else { 
        return false;
      }
    },

    async register(data) {
      let response = await ajax('post', 'register', data); 
      if(response.status === 200){
        this.user = response.data;
        router.push({name: 'app.dashboard'});
      } else { 
        return false;
      }
    },

    async update(data) {
      const toastStore = useAlertStore(); 
      let response = await ajax('post', 'profile', data); 
      if(response.status === 200){
        toastStore.success('toast.update_profile_success');
        return true;
      } else { 
        toastStore.error('toast.update_profile_error');
        return false;
      }
    },

    async retrieve() {
      //console.log(user);
      //console.log(this.user);
      let response = await ajax('get', 'profile');
      if(response.status === 200){
        return response.data;
      } else { 
        return null;
      }
    },
  },
})