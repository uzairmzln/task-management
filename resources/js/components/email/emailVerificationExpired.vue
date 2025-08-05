<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div class="text-center">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100">
          <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
        </div>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
          Verification Link Expired
        </h2>
        <p class="mt-2 text-sm text-gray-600">
          The verification link has expired. Please request a new verification email.
        </p>
        <div class="mt-6 space-y-3">
          <button
            @click="resendVerification"
            :disabled="resending"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
          >
            {{ resending ? 'Sending...' : 'Send New Verification Email' }}
          </button>
          <button
            @click="goToLogin"  
            class="group relative w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Back to Login
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EmailVerificationExpired',
  data() {
    return {
      resending: false
    }
  },
  methods: {
    goToLogin() {
      this.$router.push('/login')
    },
    async resendVerification() {
      this.resending = true
      // Add your resend logic here if needed
      setTimeout(() => {
        this.resending = false
        this.$router.push('/login')
      }, 2000)
    }
  }
}
</script>