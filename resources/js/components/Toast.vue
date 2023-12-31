<script setup>
import { notify, Notification, NotificationGroup } from "notiwind";
import { ExclamationTriangleIcon, CheckCircleIcon } from '@heroicons/vue/24/outline'
import { storeToRefs } from 'pinia';
import { watch } from 'vue'

import { useAlertStore } from '../store/toast';

const alertStore = useAlertStore();
const { alert } = storeToRefs(alertStore);
watch(alert, () => {
    notify(
      {
        group: "top",
        title: alert.value.title,
        text: alert.value.msg,
        type: alert.value.type
      },
      4000
    );
})

</script>

<template>
  <NotificationGroup group="top">
      <div
        class="fixed inset-0 flex items-start justify-end p-6 px-4 py-6 pointer-events-none"
      >
        <div class="w-full max-w-sm">
          <Notification
            v-slot="{ notifications, close }"
            enter="ease-out duration-300 transition"
            enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
            enter-to="translate-y-0 opacity-100 sm:translate-x-0"
            leave="transition ease-in duration-500"
            leave-from="opacity-100"
            leave-to="opacity-0"
            move="transition duration-500"
            move-delay="delay-300"
          >
            <div
              v-for="notification in notifications"
              :key="notification.id"
              class="w-full max-w-sm mt-4 overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
            >
              <div class="p-4">
                <div class="flex items-start">
                  <div class="shrink-0">
                    <CheckCircleIcon v-if="notification.type === 'success'" class="w-6 h-6 text-green-400" />
                    <ExclamationTriangleIcon v-else-if="notification.type === 'error'" class="w-6 h-6 text-red-400" />
                  </div>
                  <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="font-semibold text-gray-800">
                      {{ notification.title }}
                    </p>
                    <p class="text-sm font-semibold text-gray-500">
                      {{ notification.text }}
                    </p>
                  </div>
                  <div class="flex ml-4 shrink-0">
                    <button
                      class="inline-flex text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400"
                      @click="close(notification.id)"
                    >
                      <span class="sr-only">Close</span>
                      <svg
                        class="w-5 h-5"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </Notification>
        </div>
      </div>
    </NotificationGroup>
</template>

