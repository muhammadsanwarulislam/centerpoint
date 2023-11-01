<script setup lang="ts">
definePageMeta({
    layout: "frontend",
  });
import { ref } from "vue";
import { z } from "zod";
import { useAuthStore } from "../stores/auth";
import type { FormSubmitEvent } from "@nuxt/ui/dist/runtime/types";

const schema = z.object({
  email: z.string().email("Invalid email"),
  password: z.string().min(8, "Must be at least 8 characters"),
});

type Schema = z.output<typeof schema>;

const userStore = useAuthStore();
const state = ref({
  email: undefined,
  password: undefined,
});

const submit = async (event: FormSubmitEvent<Schema>) => {
  await userStore.signIn({
    email: state.value.email,
    password: state.value.password,
  });
  return navigateTo("/");
};
</script>

<template>
  <UForm :schema="schema" :state="state" @submit="submit">
    <UFormGroup label="Email" name="email">
      <UInput v-model="state.email" />
    </UFormGroup>

    <UFormGroup label="Password" name="password">
      <UInput v-model="state.password" type="password" />
    </UFormGroup>

    <UButton type="submit"> Submit </UButton>
  </UForm>
</template>
