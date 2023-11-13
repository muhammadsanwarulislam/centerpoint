<script setup lang="ts">
import { reactive } from 'vue';
import { useAuthStore } from "../stores/auth";
import { z } from 'zod'
import type { FormSubmitEvent } from '#ui/types'

definePageMeta({
  middleware: "is-logged-in",
  layout: "frontend",
});

const userStore = useAuthStore();
const schema = z.object({
  email: z.string().email('Invalid email'),
  password: z.string().min(8, 'Must be at least 8 characters'),
  password_confirmation: z.string()
  
}).refine((data) => data.password === data.password_confirmation, {
    message: "Passwords don't match",
    path: ["password_confirmation"], // path of error
  });

type Schema = z.output<typeof schema>

const state = reactive({
  name: undefined,
  email: undefined,
  password: undefined,
  password_confirmation: undefined,

})

async function onSubmit (event: FormSubmitEvent<Schema>) {
  await userStore.signUp({
    name: state.name,
    email: state.email,
    password: state.password,
    password_confirmation:state.password_confirmation,
  });
  return navigateTo("/login");
}
</script>

<template>
  <div class="shadow-md rounded-md w-96">
    <UForm :schema="schema" :state="state" class="space-y-4" @submit="onSubmit">
      <UFormGroup label="Name" name="name">
        <UInput v-model="state.name" />
      </UFormGroup>

      <UFormGroup label="Email" name="email">
        <UInput v-model="state.email" />
      </UFormGroup>
  
      <UFormGroup label="Password" name="password">
        <UInput v-model="state.password" type="password" />
      </UFormGroup>
      
      <UFormGroup label="Password Confirmation" name="password_confirmation">
        <UInput v-model="state.password_confirmation" type="password"/>
      </UFormGroup>

      <UButton type="submit">
        Submit
      </UButton>
    </UForm>
  </div>
</template>



