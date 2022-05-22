<template>
  <transition enter-active-class="ease-out duration-400"
    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-75"
    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
    leave-active-class="ease-in duration-300"
    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
    <div v-if="$page.props.flash.message" class="fixed bottom-0 right-0 w-full md:bottom-8 md:right-12 md:w-auto z-60">
      <div class="bg-green-600 text-white text-sm p-5 md:rounded shadow-lg flex justify-between">
        <div class="flex items-center">
          <svg class="w-10 h-10 text-green-800 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
           {{ $page.props.flash.message }}
        </div>
        <button class="text-gray-300 hover:text-white ml-5" @click="$page.props.flash.message = null">
          <span class="sr-only">Close</span>
          <svg class="w-4 h-4 shrink-0 fill-current" viewBox="0 0 16 16">
            <path d="M12.72 3.293a1 1 0 00-1.415 0L8.012 6.586 4.72 3.293a1 1 0 00-1.414 1.414L6.598 8l-3.293 3.293a1 1 0 101.414 1.414l3.293-3.293 3.293 3.293a1 1 0 001.414-1.414L9.426 8l3.293-3.293a1 1 0 000-1.414z" />
          </svg>
        </button>
      </div>
    </div>
  </transition>
</template>

<script>

</script>