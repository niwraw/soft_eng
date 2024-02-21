<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Spatia\PdfToImage\Pdf;
use Org_Hoigl\GhostScript\Ghostscript;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }

    public function checkFiles(): void
    {
        
    }
}; ?>

<div>
    <form wire:submit="register" class="flex flex-col gap-7">
        <!-- Name -->

        <span>Personal Information</span>
        
        <div class="flex flex-row gap-3">
            <div class="w-1/3">
                <x-input-label for="lastName" :value="__('Last Name')" />
                <x-text-input wire:model="" id="lastName" class="block w-full mt-1" type="text" name="lastName" required autofocus/>
            </div>

            <div class="w-1/3">
                <x-input-label for="firstName" :value="__('First Name')" />
                <x-text-input wire:model="" id="firstName" class="block w-full mt-1" type="text" name="firstName" required autofocus/>
            </div>

            <div class="w-1/3">
                <x-input-label for="middleName" :value="__('Middle Name')" />
                <x-text-input wire:model="" id="middleName" class="block w-full mt-1" type="text" name="middleName" required autofocus/>
            </div>

            <div class="w-1/6">
                <x-input-label for="suffix" :value="__('Suffix')" />
                <div>
                    <select name="suffix" id="suffix" class="block w-full mt-1" required>
                        <option value="">Please select</option>
                        <option value="">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="I">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="flex flex-row gap-3">
            <div class="w-1/3">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email" required/>
            </div>

            <div class="w-1/3">
                <x-input-label for="contactNum" :value="__('Contact Number')" />
                <x-text-input wire:model="" id="contactNum" class="block w-full mt-1" type="text" name="contactNum" required/>
            </div>

            <div class="w-1/3">
                <x-input-label for="applicationType" :value="__('Appication Type')" />
                <div>
                    <select name="applicationType" id="applicationType" class="block w-full mt-1" required>
                        <option value="">Please select</option>
                        <option value="SHS">Senior High School</option>
                        <option value="ALS">Alternative Learning System</option>
                        <option value="OLD">High School Graduate</option>
                        <option value="TRANSFER">Transferee</option>
                    </select>
                </div>
            </div>

            <div class="w-1/6">
                <x-input-label for="gender" :value="__('Gender')" />
                <div>
                    <select name="gender" id="gender" class="block w-full mt-1" required>
                        <option value="">Please select</option>
                        <option value="">Male</option>
                        <option value="">Female</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="flex items-center">
          <input id="terms-and-privacy" name="terms-and-privacy" type="checkbox" class="" />
          <label for="terms-and-privacy" class="block ml-2 text-sm text-gray-900"
            >I agree to the
            <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms</a>
            and
            <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>.
          </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Apply') }}
            </x-primary-button>
        </div>
    </form>
</div>
