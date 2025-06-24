<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const emailValid = computed(() => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return form.email ? emailRegex.test(form.email) : null;
});

const passwordValid = computed(() => {
    return form.password ? form.password.length >= 8 : null;
});

const loginWithGoogle = () => {
    window.location.href = route('login.google');
};
</script>

<template>
    <AuthBase title="Connexion" description="Connectez-vous avec Google ou votre email et mot de passe"
        :title-class="'text-3xl sm:text-4xl lg:text-5xl font-extrabold text-theme-black text-center'"
        :description-class="'text-base sm:text-lg lg:text-xl text-theme-black/60 mt-2 text-center'">

        <Head title="Connexion" />

        <div class="mb-6 text-center">
            <img src="/logo.png" alt="Logo" class="h-12 sm:h-16 mx-auto animate-fade-in" />
        </div>

        <!-- Bouton Google en haut -->
        <button type="button" @click="loginWithGoogle"
            class="w-full flex items-center justify-center gap-3 border-2 border-theme-black/20 bg-white hover:border-theme-blue hover:text-theme-blue hover:scale-105 transition-all duration-300 rounded-lg py-3 font-bold text-base shadow mb-6"
            tabindex="1" aria-label="Connexion avec Google">
            <i class="fa-brands fa-google text-theme-black/60 text-lg"></i>
            Connexion avec Google
        </button>

        <!-- Diviseur OU -->
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center">
                <span class="w-full border-t border-theme-black/20"></span>
            </div>
            <div class="relative flex justify-center">
                <span class="bg-white px-2 text-xs sm:text-sm text-theme-black/60 font-medium">OU</span>
            </div>
        </div>

        <form @submit.prevent="submit"
            class="flex flex-col gap-6 max-w-md mx-auto bg-gradient-to-b from-theme-white to-theme-blue/5 p-6 sm:p-8 rounded-lg shadow-lg animate-fade-in-up">
            <div class="grid gap-6">
                <div class="grid gap-2 relative">
                    <label for="email" class="text-sm sm:text-base font-bold text-theme-black">Adresse email</label>
                    <div class="relative">
                        <input id="email" type="email" required autofocus tabindex="2" autocomplete="email"
                            v-model="form.email" placeholder="email@exemple.com"
                            class="block w-full rounded-lg border-2 shadow-md focus:ring-2 focus:ring-theme-blue text-base pl-10 pr-4 py-3 transition-all duration-300"
                            :class="{
                                'border-theme-black/20': emailValid === null,
                                'border-green-600': emailValid === true,
                                'border-[--theme-red]': emailValid === false || form.errors.email,
                            }" aria-label="Adresse email" aria-describedby="email-error" />
                        <i
                            class="fa-solid fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-theme-black/60"></i>
                    </div>
                    <InputError :message="form.errors.email" id="email-error"
                        class="text-xs text-[--theme-red] flex items-center mt-1 animate-fade-in">
                        <i class="fa-solid fa-exclamation-circle fa-sm mr-1"></i>
                        {{ form.errors.email }}
                    </InputError>
                </div>

                <div class="grid gap-2 relative">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-sm sm:text-base font-bold text-theme-black">Mot de
                            passe</label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')"
                            class="text-xs sm:text-sm text-theme-blue hover:underline hover:text-theme-blue-dark transition-all duration-300"
                            tabindex="5">
                            Mot de passe oublié ?
                        </TextLink>
                    </div>
                    <div class="relative">
                        <input id="password" :type="showPassword ? 'text' : 'password'" required tabindex="3"
                            autocomplete="current-password" v-model="form.password" placeholder="Mot de passe"
                            class="block w-full rounded-lg border-2 shadow-md focus:ring-2 focus:ring-theme-blue text-base pl-10 pr-10 py-3 transition-all duration-300"
                            :class="{
                                'border-theme-black/20': passwordValid === null,
                                'border-green-600': passwordValid === true,
                                'border-[--theme-red]': passwordValid === false || form.errors.password,
                            }" aria-label="Mot de passe" aria-describedby="password-error" />
                        <i
                            class="fa-solid fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-theme-black/60"></i>
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-theme-black/60 hover:text-theme-blue"
                            aria-label="Afficher/masquer mot de passe" tabindex="4">
                            <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                        </button>
                    </div>
                    <InputError :message="form.errors.password" id="password-error"
                        class="text-xs text-[--theme-red] flex items-center mt-1 animate-fade-in">
                        <i class="fa-solid fa-exclamation-circle fa-sm mr-1"></i>
                        {{ form.errors.password }}
                    </InputError>
                </div>

                <div class="flex items-center">
                    <label for="remember" class="flex items-center space-x-3">
                        <input id="remember" type="checkbox" v-model="form.remember" tabindex="6"
                            class="custom-checkbox" aria-label="Se souvenir de moi" />
                        <span class="text-xs sm:text-sm text-theme-black font-medium">Se souvenir de moi</span>
                    </label>
                </div>

                <button type="submit"
                    class="btn-gradient text-base font-bold mt-4 w-full flex items-center justify-center" tabindex="7"
                    :disabled="form.processing" :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                    aria-label="Connexion">
                    <i v-if="form.processing" class="fa-solid fa-spinner animate-spin mr-2"></i>
                    <i v-else class="fa-solid fa-sign-in-alt mr-2"></i>
                    Connexion
                </button>
            </div>

            <div v-if="status"
                class="mt-4 text-center text-xs font-semibold text-green-600 bg-green-50 border border-green-600 rounded-lg p-3 flex items-center justify-center animate-fade-in">
                <i class="fa-solid fa-check-circle mr-2"></i>
                {{ status }}
            </div>

            <div class="text-center text-xs sm:text-sm text-theme-black/60 mt-6">
                Pas de compte ?
                <TextLink :href="route('register')"
                    class="text-theme-blue font-medium hover:underline hover:text-theme-blue-dark transition-all duration-300"
                    tabindex="8">
                    S’inscrire
                </TextLink>
            </div>
        </form>
    </AuthBase>
</template>