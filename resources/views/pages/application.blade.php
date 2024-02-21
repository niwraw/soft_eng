<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-sans antialiased text-gray-900">
        <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-11/12 px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div>
                    <form action="{{ route('apply.post') }}" method="POST" class="flex flex-col gap-7">
                        <!-- Name -->
                        @csrf

                        <span>Personal Information</span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="lastName" :value="__('Last Name')" />
                                <x-text-input id="lastName" class="block w-full mt-1" type="text" name="lastName" required autofocus/>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="firstName" :value="__('First Name')" />
                                <x-text-input id="firstName" class="block w-full mt-1" type="text" name="firstName" required autofocus/>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="middleName" :value="__('Middle Name')" />
                                <x-text-input id="middleName" class="block w-full mt-1" type="text" name="middleName" required autofocus/>
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
                                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" required/>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="contactNum" :value="__('Contact Number')" />
                                <x-text-input id="contactNum" class="block w-full mt-1" type="text" name="contactNum" required/>
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
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
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
            </div>
        </div>
    </body>
</html>