<script setup>
 import { PresentationChartBarIcon, CalendarDaysIcon, UserCircleIcon } from '@heroicons/vue/24/outline'
 import { ref, computed } from 'vue'
 import { useRouter, useRoute } from 'vue-router'

 let sidebarLinks = [
  {id: 1, route: { name: 'app.dashboard' }, icon: PresentationChartBarIcon, title: 'Dashboard'},
  {id: 2, route: { name: 'app.calendar' }, icon: CalendarDaysIcon, title: 'Calendar'},
  {id: 3, route: { name: 'app.profile' }, icon: UserCircleIcon, title: 'Edit your Profile'}
];
const route = useRoute();
const isSelectedRoute = (sidebarLink) => {
  const route = useRoute();
  return route.name == sidebarLink.route.name;
}

</script>

<template> 
  <aside class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent">
      <div class="h-19.5">
        <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
        <router-link :to="{ name: 'app.dashboard' }" class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700">
        <img src="img/logo-ct.png" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
          <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Demo App</span>
        </router-link>
      </div>

      <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />
      
      <div class="items-center block w-auto max-h-screen h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">
          <li class="mt-0.5 w-full" v-for="sidebarLink in sidebarLinks" :key="sidebarLink.id">
            <router-link :to="{ name: sidebarLink.route.name }" :class="isSelectedRoute(sidebarLink) ? 'shadow-soft-xl rounded-lg bg-white px-4 font-semibold text-slate-700' : ''" class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors">
              <div :class="isSelectedRoute(sidebarLink) ? 'bg-gradient-to-tl from-purple-700 to-pink-500' : ''" class="shadow-soft-2xl mr-2 flex items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                <component :is="sidebarLink.icon" :class="isSelectedRoute(sidebarLink) ? 'text-white' : ''" class="h-6 w-6" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" />
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">{{ sidebarLink.title }}</span>
            </router-link>
          </li>
        </ul>
      </div>

      
    </aside>
</template>


<style scoped>
/*aside .selected-blog-link {color:red;}*/
</style>
