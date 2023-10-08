<script setup>
import Input from '../components/Form/Input.vue'
import Alert from '../components/Alert.vue'
import { ref, reactive } from 'vue'
import { useUserStore }  from '../store/user'
import { useVuelidate } from '@vuelidate/core'
import { required, email as emailAddress, minLength, helpers} from '@vuelidate/validators'
import router from "../router";

const store = useUserStore()

let loginError = ref('');

const formData = reactive({
  email: '',
  password: ''
})

let rules = {
  email: { required, emailAddress},
  password: {
      minLength: minLength(6), required, containsPasswordRequirement: helpers.withMessage(() => $t('fieldhint.password'), (value) =>
          /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/.test(value.toString()))
  }
}
const v$ = useVuelidate(rules, formData);

async function loginUser(){
  const isFormCorrect = await v$.value.$validate(); 

  if(!isFormCorrect){
    loginError.value = 'validation';
  } else {
    let loggedIn = await store.login(formData);
   
    if(!loggedIn){
      loginError.value = 'account';
    } else {
      
    }
  }
}
</script>

<template>
  
  <main class="mt-0 transition-all duration-200 ease-soft-in-out">
      <section>
        <div class="relative flex items-center p-0 overflow-hidden bg-center bg-cover min-h-75-screen">
          <div class="container z-10">
            <div class="flex flex-wrap mt-0 -mx-3">
              <div class="flex flex-col w-full max-w-full px-3 mx-auto md:flex-0 shrink-0 md:w-6/12 lg:w-5/12 xl:w-4/12">
                <div class="relative flex flex-col min-w-0 mt-20 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border">
                  <div class="p-6 pb-0 mb-0 bg-transparent border-b-0 rounded-t-2xl">
                    <h3 class="relative z-10 font-bold text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text">{{ $t('login.intro') }}</h3>
                    <p class="mb-0">{{ $t('login.intro_text') }}</p>
                  </div>
                  <div class="flex-auto p-6">
                    
                    <Alert v-if="loginError" ref="alert" color="fuchsia" :text="loginError == 'validation' ? $t('form.validation_error') : $t('login.account_error')" class="mb-3.5" />

                    <form role="form">
                      <Input id="email" :label="$t('fields.email')" type="email" v-model="formData.email" />
                      <Input id="pwd" :hint="$t('fieldhint.password')" :label="$t('fields.password')" type="password" v-model="formData.password" />
                      <div class="text-center">
                          <button @click="loginUser" type="button" class="inline-block w-full px-6 py-3 mt-6 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs ease-soft-in tracking-tight-soft bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85">Sign in</button>
                      </div>
                    </form>
                  </div>
                  <div class="p-6 px-1 pt-0 text-center bg-transparent border-t-0 border-t-solid rounded-b-2xl lg:px-2">
                    <p class="mx-auto mb-6 leading-normal text-sm">
                      {{ $t('login.signup_text') }}
                      <router-link :to="{ name: 'app.register' }" class="relative z-10 font-semibold text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text">{{ $t('login.sign_up') }}</router-link>
                    </p>
                  </div>
                </div>
              </div>
              <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 md:w-6/12">
                <div class="absolute top-0 hidden w-3/5 h-full -mr-32 overflow-hidden -skew-x-10 -right-40 rounded-bl-xl md:block">
                  <div class="absolute inset-x-0 top-0 z-0 h-full -ml-16 bg-cover skew-x-10" style="background-image: url('img/curved-images/curved6.jpg')"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  </main>
  
</template>



