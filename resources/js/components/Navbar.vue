<script setup>
import { ArrowLeftOnRectangleIcon } from '@heroicons/vue/24/outline'
import { useUserStore }  from '../store/user'
import router from "../router";

const store = useUserStore()

async function logout() {
  await store.logout();
  router.push({name: 'app.login'});
}
</script>

<template>
  <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          

          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
           
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
             
              <li class="flex items-center">
                <a @click="logout" style="cursor:pointer;" class="block px-0 py-2 text-sm font-semibold transition-all ease-nav-brand text-slate-500">
                  <ArrowLeftOnRectangleIcon class="h-6 w-6" />
                  <span class="hidden sm:inline">Logout</span>
                </a>
              </li>

              <li class="flex items-center pl-4 xl:hidden">
                <a href="javascript:;" class="block p-0 transition-all ease-nav-brand text-sm text-slate-500" sidenav-trigger>
                  <div class="w-4.5 overflow-hidden">
                    <i class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-slate-500 transition-all"></i>
                    <i class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-slate-500 transition-all"></i>
                    <i class="ease-soft relative block h-0.5 rounded-sm bg-slate-500 transition-all"></i>
                  </div>
                </a>
              </li>
              
            </ul>
          </div>
        </div>
      </nav>
</template>




