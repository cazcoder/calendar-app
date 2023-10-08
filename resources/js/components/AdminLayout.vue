<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon, PresentationChartBarIcon, CalendarDaysIcon, ArrowLeftOnRectangleIcon, UserCircleIcon } from '@heroicons/vue/24/outline'
import { useRoute, useLink } from 'vue-router'
import { ref } from 'vue'
import { trans } from 'laravel-vue-i18n';
import { useUserStore }  from '../store/user'
const store = useUserStore()

//@todo - figure out how to use router link with disclosure button - href must be removed
const navigation = [
  {id: 1, route: { name: 'app.dashboard' }, href: '/', icon: PresentationChartBarIcon, title: trans('pageheader.dashboard')},
  {id: 2, route: { name: 'app.calendar' }, href: '/calendar', icon: CalendarDaysIcon, title: trans('pageheader.calendar')},
  {id: 3, route: { name: 'app.profile' }, href: '/profile', icon: UserCircleIcon, title: trans('pageheader.edit_profile')},
  /*{id: 4, click: 'logout', href: '/logout', icon: UserCircleIcon, title: trans('pageheader.logout')} */
];

const route = useRoute();
let headerText = ref('');

const isSelectedRoute = (item) => {
  const route = useRoute();
  if(route.name == item.route.name){ 
    headerText.value = item.title;
    return true;
  } else {
    return false;
  }
}

</script>

<template>
 
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" />
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                  <router-link v-for="item in navigation" :key="item.id" :to="{ name: item.route.name }" :class="[isSelectedRoute(item) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']">
                    <component :is="item.icon" :class="isSelectedRoute(item) ? 'text-white' : ''" class="h-6 w-6 mr-2" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" />
                    {{ item.title }}
                  </router-link>
                  
                  <a @click="store.logout()" href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"><ArrowLeftOnRectangleIcon class="text-white h-6 w-6 mr-2" /> {{ $t('pageheader.logout') }}</a>
              </div>
            </div>
          </div>
          
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
              <span class="absolute -inset-0.5" />
              <span class="sr-only">{{ trans('screenreader.openmainmenu') }}</span>
              <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
          <DisclosureButton v-for="item in navigation" :key="item.id" as="a" :href="item.href" :class="[isSelectedRoute(item)  ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']">{{ item.title }}</DisclosureButton>
          <a @click="store.logout" href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">{{ $t('pageheader.logout') }}</a>
        </div>
      </DisclosurePanel>
    </Disclosure>
    
    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ headerText }}</h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <RouterView></RouterView>
      </div>
    </main>
  </div>
</template>



