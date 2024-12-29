<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-4">
            <div>
                <h2 class="mt-4 text-center text-3xl font-extrabold text-gray-900">
                    Connexion à votre compte
                </h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form class="mt-4 space-y-4" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <x-input-label for="email" :value="__('Adresse email')" class="sr-only" />
                        <x-text-input id="email" 
                                     class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                                     type="email" 
                                     name="email" 
                                     :value="old('email')" 
                                     placeholder="Adresse email"
                                     required 
                                     autofocus 
                                     autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Mot de passe')" class="sr-only" />
                        <x-text-input id="password" 
                                     class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                     type="password"
                                     name="password"
                                     placeholder="Mot de passe"
                                     required 
                                     autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" 
                               type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                               name="remember">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Forgot Password -->
                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" 
                               class="font-medium text-blue-600 hover:text-blue-500">
                                Mot de passe oublié?
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" 
                                 xmlns="http://www.w3.org/2000/svg" 
                                 viewBox="0 0 20 20" 
                                 fill="currentColor" 
                                 aria-hidden="true">
                                <path fill-rule="evenodd" 
                                      d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" 
                                      clip-rule="evenodd" />
                            </svg>
                        </span>
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
