<template>
  <div class="flex h-screen w-screen items-center overflow-hidden px-2">
      <div class="relative flex w-96 flex-col space-y-5 rounded-lg border bg-white px-5 py-10 shadow-xl sm:mx-auto">
          <div class="-z-10 absolute top-4 left-1/2 h-full w-5/6 -translate-x-1/2 rounded-lg bg-gradient-to-l from-slate-800 to-violet-900 sm:-right-10 sm:top-auto sm:left-auto sm:w-full sm:translate-x-0"></div>
          
          <div class="mx-auto mb-2 space-y-3">
              <h1 class="text-center text-3xl font-bold text-gray-700">Sign in</h1>
              <p class="text-gray-500">Sign in to access your account</p>
          </div>
          
          <form @submit.prevent="submitLogin" novalidate>
              <div class="relative mt-2 w-full">
                  <input 
                      type="email" 
                      v-model="form.email" 
                      id="email" 
                      :class="['border-1 peer block w-full appearance-none rounded-lg border', 
                               emailError ? 'border-red-500' : 'border-gray-300']"
                      class="bg-transparent px-2.5 pt-4 pb-2.5 text-sm text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-0" 
                      placeholder=" " 
                      required
                  />
                  <label 
                      for="email" 
                      class="origin-[0] peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:px-2 peer-focus:text-blue-600 absolute left-1 top-2 z-10 -translate-y-4 scale-75 transform cursor-text select-none bg-white px-2 text-sm text-gray-500 duration-300"
                  > 
                      Enter Your Email 
                  </label>
                  <p v-if="emailError" class="text-red-500 text-sm mt-1">{{ emailError }}</p>
              </div>
  
              <div class="relative mt-5 w-full">
                  <input 
                      type="password" 
                      v-model="form.password" 
                      id="password" 
                      :class="['border-1 peer block w-full appearance-none rounded-lg border', 
                               passwordError ? 'border-red-500' : 'border-gray-300']"
                      class="bg-transparent px-2.5 pt-4 pb-2.5 text-sm text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-0" 
                      placeholder=" " 
                      required
                  />
                  <label 
                      for="password" 
                      class="origin-[0] peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:px-2 peer-focus:text-blue-600 absolute left-1 top-2 z-10 -translate-y-4 scale-75 transform cursor-text select-none bg-white px-2 text-sm text-gray-500 duration-300"
                  > 
                      Enter Your Password 
                  </label>
                  <p v-if="passwordError" class="text-red-500 text-sm mt-1">{{ passwordError }}</p>
              </div>
              
              <div v-if="loginError" class="mt-4 text-center text-red-500">
                  {{ loginError }}
              </div>
              
              <div class="flex w-full items-center mt-5">
                  <button 
                      type="submit" 
                      :disabled="isLoading"
                      class="shrink-0 inline-block w-36 rounded-lg bg-gradient-to-l from-slate-800 to-violet-900 py-3 font-bold text-center text-white disabled:opacity-50"
                  >
                      {{ isLoading ? 'Logging in...' : 'Login' }}
                  </button>
                  <a class="w-full text-center text-sm font-medium text-gray-600 hover:underline" href="#">
                      Forgot your password?
                  </a>
              </div>
              
              <p class="text-center mt-4 text-gray-600">
                  Don't have an account?
                  <RouterLink to="/register" class="whitespace-nowrap font-semibold text-gray-900 hover:underline">
                      Sign up
                  </RouterLink>
              </p>
          </form>
      </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { handeAuthStore } from '../utilities';

export default {
  setup() {
       const router = useRouter();

      const form = ref({
          email: '',
          password: ''
      });

      const isLoading = ref(false);
      const loginError = ref('');
      const emailError = ref('');
      const passwordError = ref('');

      const validateEmail = (email) => {
          const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          return re.test(email);
      };

      const validateForm = () => {
          emailError.value = '';
          passwordError.value = '';
          loginError.value = '';

          if (!form.value.email) {
              emailError.value = 'Email is required';
              return false;
          }
          if (!validateEmail(form.value.email)) {
              emailError.value = 'Invalid email format';
              return false;
          }
          if (!form.value.password) {
              passwordError.value = 'Password is required';
              return false;
          }
          if (form.value.password.length < 6) {
              passwordError.value = 'Password must be at least 6 characters';
              return false;
          }

          return true;
      };

      const getToken = async () => {
          await axios.get('/sanctum/csrf-cookie');
      };

      const submitLogin = async () => {
          if (!validateForm()) return;

          isLoading.value = true;
          loginError.value = '';

          try {
              // await getToken();
              const response = await axios.post('http://localhost:8000/api/login', {
                  email: form.value.email,
                  password: form.value.password
              });

              axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
 
              const data = await getMe(response.data.token);
              handeAuthStore(data)
              sessionStorage.setItem('token', response.data.token)
              router.push('/contacts/index');
          } catch (error) {
              loginError.value = error.response?.data?.message || 'Login failed. Please try again.';
              console.error('Login failed:', error.response ? error.response.data : error.message);
          } finally {
              isLoading.value = false;
          }
      };


      const getMe = async (token) => {
          try {
              const response = await axios.get('http://localhost:8000/api/me');
              return response.data  
          } catch (error) {
              console.error('Error retrieving user information', error);
          }
      };

      return {
          form,
          submitLogin,
          isLoading,
          loginError,
          emailError,
          passwordError
      };
  }
};
</script>