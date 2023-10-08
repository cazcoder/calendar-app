import { defineStore } from 'pinia';
import { trans } from 'laravel-vue-i18n';

export const useAlertStore = defineStore({
    id: 'alert',
    state: () => ({
        alert: null
    }),
    actions: {
        success(message) {
            this.alert = { msg: trans(message), title: trans('toast.success_title'), type: 'success' };
        },
        error(message) { 
            this.alert = { msg: trans(message), title: trans('toast.error_title'), type: 'error' };
        },
        clear() {
            this.alert = null;
        }
    }
});