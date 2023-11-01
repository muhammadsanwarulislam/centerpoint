<script setup lang="ts">
definePageMeta({
    layout: "frontend",
  });
import { ref } from "vue";
import { z } from "zod";
import type { FormSubmitEvent } from "@nuxt/ui/dist/runtime/types";
import { useAuthStore } from "../stores/auth";

const schema = z
  .object({
    name: z.string(),
    email: z.string().email("Invalid email"),
    password: z.string().min(8, "Must be at least 8 characters"),
    password_confirmation: z.string(),
  })
  .refine(
    (data: { password: string; password_confirmation: string }) =>
      data.password === data.password_confirmation,
    {
      message: "Passwords don't match",
      path: ["password_confirmation"],
    }
  );

type Schema = z.output<typeof schema>;

const userStore = useAuthStore();
const state = ref({
  name: undefined,
  email: undefined,
  password: undefined,
  password_confirmation: undefined,
});

const submit = async (event: FormSubmitEvent<Schema>) => {
  await userStore.signUp({
    name: state.value.email,
    email: state.value.email,
    password: state.value.password,
    password_confirmation: state.value.password_confirmation,
  });
  return navigateTo("/login");
};
</script>

<template>
  <UForm :schema="schema" :state="state" @submit="submit">
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
      <UInput v-model="state.password_confirmation" type="password" />
    </UFormGroup>

    <UButton type="submit"> Submit </UButton>
  </UForm>
</template>
