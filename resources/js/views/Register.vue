<script setup>
import Input from '../components/Form/Input.vue'
import Alert from '../components/Alert.vue'
import { ref, reactive } from 'vue'
import { useUserStore }  from '../store/user'
import router from "../router";
import { useVuelidate } from '@vuelidate/core'
import { required, email as emailAddress, minLength, helpers} from '@vuelidate/validators'

const store = useUserStore()
let registerError = ref('');

const formData = reactive({
  name: '',
  email: '',
  password: ''
})

let rules = {
  name: { required },
  email: { required, emailAddress},
  password: {
      minLength: minLength(6), required, containsPasswordRequirement: helpers.withMessage(() => $t('fieldhint.password'), (value) =>
          /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/.test(value.toString()))
  }
}

const v$ = useVuelidate(rules, formData);

async function registerUser(){
  const isFormCorrect = await v$.value.$validate();  

  if(!isFormCorrect){
    registerError.value = 'validation';
  } else {
    let registered = await store.register(formData);
    if(!registered){
      registerError.value = 'account';
    } else {
      registerError.value = '';
    }
  }
}
</script>

<template>
  <main class="mt-0 transition-all duration-200 ease-soft-in-out">
    
      <section class="min-h-screen mb-32">
        <div class="relative flex items-start pt-12 pb-56 m-4 overflow-hidden bg-center bg-cover min-h-50-screen rounded-xl" style="background-image: url('img/curved-images/curved14.jpg')">
          <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 opacity-60"></span>
          <div class="container z-10">
            <div class="flex flex-wrap justify-center -mx-3">
              <div class="w-full max-w-full px-3 mx-auto mt-0 text-center lg:flex-0 shrink-0 lg:w-5/12">
                <h1 class="mt-12 mb-2 text-white">{{ $t('register.intro') }}</h1>
                <p class="text-white">{{ $t('register.intro_text') }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="flex flex-wrap -mx-3 -mt-48 md:-mt-56 lg:-mt-48">
            <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
              <div class="relative z-0 flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-6">
                  <Alert v-if="registerError" ref="alert" color="fuchsia" :text="registerError == 'validation' ? $t('form.validation_error') : $t('register.account_error')" class="mb-3.5" />
                  <form role="form text-left">
                    <div class="mb-4">
                      <Input id="name" label="Name" type="text" v-model="formData.name" />
                    </div>
                    <div class="mb-4">
                      <Input id="email" :label="$t('fields.email')" label="Email" type="email" v-model="formData.email" />
                    </div>
                    <div class="mb-4">
                      <Input id="pwd" :hint="$t('fieldhint.password')" :label="$t('fields.password')" type="password" v-model="formData.password" />
                    </div>
                    <div class="text-center">
                      <button @click="registerUser" type="button" class="inline-block w-full px-6 py-3 mt-6 mb-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:scale-102 hover:shadow-soft-xs leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:border-slate-700 hover:bg-slate-700 hover:text-white">{{ $t('register.sign_up') }}</button>
                    </div>
                    <p class="mt-4 mb-0 leading-normal text-sm">{{ $t('register.signin_text') }}
                      <router-link :to="{ name: 'app.login' }" class="font-bold text-slate-700">{{ $t('register.sign_in') }}</router-link>
                    </p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  
</template>

