<script setup>
import Alert from '../components/Alert.vue'
import Input from '../components/Form/Input.vue'
import Textarea from '../components/Form/Textarea.vue'
import Toast from '../components/Toast.vue'
import { useUserStore }  from '../store/user'
import { useAlertStore } from '../store/toast'
import { ref, provide, reactive } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, email as emailAddress, minLength, sameAs, helpers} from '@vuelidate/validators'
import { trans } from 'laravel-vue-i18n';

const store = useUserStore()
const toastStore = useAlertStore()

let formData = reactive({
  name: '',
  email: '',
  password: '',
  description: '',
})

let rules = {
  name: { required },
  email: { required, emailAddress},
}

async function updateProfile(){
  if(formData.password){
  rules.password = { minLength: minLength(6), required, containsPasswordRequirement: helpers.withMessage(() => $t('fieldhint.password'), (value) =>
          /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/.test(value.toString())) };
  }

  const v$ = useVuelidate(rules, formData);
  const isFormCorrect = await v$.value.$validate();  

  if(!isFormCorrect){
    toastStore.error('form.validation_error');  
  } else {
    await store.update(formData);
  }
}

async function getProfile(){
  let response = await store.retrieve();
  if(response){
    let profile = response.user;
    formData.name = profile.name;
    formData.email = profile.email;
    formData.description = profile.description;
  }
}
getProfile(); 
</script>

<template>
  <section class="bg-white dark:bg-gray-900 rounded-2xl">
  <Toast />
 
  <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
    <Alert style="margin-bottom:40px;" color="slate" :text="trans('profile.required_fields')"  />
      <form action="#">
          <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
              <div class="sm:col-span-2">
                <Input id="name" :label="$t('fields.name')" type="name" v-model="formData.name" />
              </div>
              <div class="w-full">
                <Input id="email" :label="$t('fields.email')" type="email" v-model="formData.email" />
              </div>
              <div class="w-full">
                <Input id="pwd" :hint="$t('fieldhint.password')" :label="$t('fields.password')" type="password" v-model="formData.password" />
              </div>
              <div class="sm:col-span-2">
                <Textarea id="description" :label="$t('fields.description')" v-model="formData.description" />
              </div>
          </div>
          <button @click="updateProfile" type="button" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">{{ $t('button.save_profile') }}</button>
      </form>
  </div>
</section>
</template>
