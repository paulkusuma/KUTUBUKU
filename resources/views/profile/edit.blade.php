<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include 'profile.partials.update-profile-information-form'
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include 'profile.partials.update-password-form'
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include 'profile.partials.delete-user-form'
                </div>
            </div>

            <!-- TAMBAHKAN FORM SIMPAN KARTU KREDIT -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4">Informasi Kartu Kredit</h3>
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <!-- FORM UNTUK DATA PROFILUM (Nama, Email) -->
                        <x-profile-update-form-form :user="$user"></x-profile-update-form>

                        <!-- FORM UNTUK DATA KARTU KREDIT -->
                        <h4 class="text-base font-semibold leading-6 text-gray-900 mt-6">Detail Kartu Kredit</h4>
                        <div class="grid grid grid-cols-1 gap-y-6">
                            <div>
                                <x-label for="card_number" class="block text-sm font-medium text-gray-700">Nomor Kartu</x-label>
                                <x-text-input type="text" id="card_number" name="card_number" wire:model="card_number" :value="$user->card_number" autocomplete="cc-number" required />
                            </div>
                            <div>
                                <x-label for="card_expiry" class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa (MM/YY)</x-label>
                                <x-text-input type="text" id="card_expiry" name="card_expiry" wire:model="card_expiry" placeholder="MM/YY" required />
                            </div>
                            <div>
                                <x-label for="card_cvv" class="block text-sm font-medium text-gray-700">CVV</x-label>
                                <x-text-input type="text" id="card_cvv" name="card_cvv" maxlength="4" required />
                            </div>
                            <div>
                                <x-label for="card_holder_name" class="block text-sm font-medium text-gray-700">Nama Pemegang Kartu</x-label>
                                <x-text-input type="text" id="card_holder_name" name="card_holder_name" wire:model="card_holder_name" required />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>