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
  password: z.string().min(8, 'Must be at least 8 characters')
})

type Schema = z.output<typeof schema>

const state = reactive({
  email: undefined,
  password: undefined
})

async function onSubmit (event: FormSubmitEvent<Schema>) {
  await userStore.signIn({
    email: state.email,
    password: state.password,
  });
  return navigateTo("/");
}
</script>

<template>
  <div class="shadow-md rounded-md w-96">
    <UForm :schema="schema" :state="state" class="space-y-4" @submit="onSubmit">
      <UFormGroup label="Email" name="email">
        <UInput v-model="state.email" />
      </UFormGroup>
  
      <UFormGroup label="Password" name="password">
        <UInput v-model="state.password" type="password" />
      </UFormGroup>
  
      <UButton type="submit">
        Submit
      </UButton>
    </UForm>
  </div>
</template>



