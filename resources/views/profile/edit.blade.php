<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- FORM INFORMASI PROFIL -->
            <div class="p-4 sm:p-8 bg-white shadow-sm rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Perbarui informasi akun dan alamat email Anda.
                    </p>
                </header>

                <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Nama -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                        @if (session('status'))
                            <div class="text-sm text-gray-600">{{ session('status') }}</div>
                        @endif
                    </div>
                </form>
            </div>

            <!-- FORM KARTU KREDIT (KERENTANAN) -->
            <div class="p-4 sm:p-8 bg-white shadow-sm rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Informasi Pembayaran</h2>
                    <p class="mt-1 text-sm text-red-600">
                        <strong>PERINGATAN:</strong> Data yang Anda masukkan akan disimpan secara tidak aman.
                    </p>
                </header>

                <!-- PERUBAHAN: KEMBALI KE CARA STANDAR LARAVEL -->
                <form method="POST" action="{{ route('profile.payment.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mt-4">
                        <x-input-label for="card_holder_name" :value="__('Nama Pemegang Kartu')" />
                        <x-text-input id="card_holder_name" name="card_holder_name" type="text" class="mt-1 block w-full" :value="old('card_holder_name', $user->card_holder_name)" autocomplete="cc-name" />
                        <x-input-error :messages="$errors->get('card_holder_name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="card_number" :value="__('Nomor Kartu')" />
                        <x-text-input id="card_number" name="card_number" type="text" class="mt-1 block w-full" :value="old('card_number', $user->card_number)" autocomplete="cc-number" />
                        <x-input-error :messages="$errors->get('card_number')" class="mt-2" />
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="card_expiry" :value="__('Masa Berlaku (MM/YY)')" />
                            <x-text-input id="card_expiry" name="card_expiry" type="text" class="mt-1 block w-full" :value="old('card_expiry', $user->card_expiry)" placeholder="MM/YY" autocomplete="cc-exp" />
                            <x-input-error :messages="$errors->get('card_expiry')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="card_cvv" :value="__('CVV')" />
                            <x-text-input id="card_cvv" name="card_cvv" type="text" class="mt-1 block w-full" :value="old('card_cvv', $user->card_cvv)" autocomplete="cc-csc" />
                            <x-input-error :messages="$errors->get('card_cvv')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Simpan Pembayaran') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>