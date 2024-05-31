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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            input[type="number"] {
            -moz-appearance: textfield;
            }

            .no-scroll {
                overflow: hidden;
            }
        </style>
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    
    <body class="font-sans antialiased text-gray-900">
        <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-11/12 px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div>
                    <a href="{{ route('back') }}" class="flex items-center gap-4 mb-6">
                        <span class="material-symbols-sharp">
                            arrow_back
                        </span>
                        <h2>Back To Home</h2>
                    </a>
                    <form action="{{ route('apply.post') }}" method="POST" class="flex flex-col gap-7" enctype="multipart/form-data">
                        <!-- Name -->
                        @csrf

                        <span>
                            Personal Information
                            <span class="text-red-500">(Required)</span>
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="lastName" :value="__('Last Name')" />
                                <x-text-input id="lastName" class="block w-full mt-1" type="text" name="lastName" value="{{ old('lastName') }}" required autofocus/>
                                <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="firstName" :value="__('First Name')" />
                                <x-text-input id="firstName" class="block w-full mt-1" type="text" name="firstName" required autofocus value="{{ old('firstName') }}"/>
                                <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="middleName" :value="__('Middle Name')" />
                                <x-text-input id="middleName" class="block w-full mt-1" type="text" name="middleName" autofocus value="{{ old('middleName') }}"/>
                                
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="suffix" :value="__('Suffix')" />
                                <div>
                                    <select name="suffix" id="suffix" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('suffix', '') == '' ? 'selected' : '' }}>Please select</option>
                                        <option value="None" {{ old('suffix', '') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Jr." {{ old('suffix', '') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                        <option value="Sr." {{ old('suffix', '') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                        <option value="II" {{ old('suffix', '') == 'II' ? 'selected' : '' }}>II</option>
                                        <option value="III" {{ old('suffix', '') == 'III' ? 'selected' : '' }}>III</option>
                                        <option value="IV" {{ old('suffix', '') == 'IV' ? 'selected' : '' }}>IV</option>
                                        <option value="V" {{ old('suffix', '') == 'V' ? 'selected' : '' }}>V</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" required value="{{ old('email') }}"/>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="contactNum" :value="__('Contact Number')" />
                                <x-text-input id="contactNum" class="block w-full mt-1 appearance-none" type="number" name="contactNum" required value="{{ old('contactNum') }}" maxlength="11"/>
                                <x-input-error :messages="$errors->get('contactNum')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="applicationType" :value="__('Application Type')" />
                                <div>
                                    <select name="applicationType" id="applicationType" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('applicationType', '') == '' ? 'selected' : '' }}>Please select</option>
                                        <option value="SHS" {{ old('applicationType', '') == 'SHS' ? 'selected' : '' }}>Senior High School</option>
                                        <option value="ALS" {{ old('applicationType', '') == 'ALS' ? 'selected' : '' }}>Alternative Learning System</option>
                                        <option value="OLD" {{ old('applicationType', '') == 'OLD' ? 'selected' : '' }}>High School Graduate</option>
                                        <option value="TRANSFER" {{ old('applicationType', '') == 'TRANSFER' ? 'selected' : '' }}>Transferee</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('applicationType')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="gender" :value="__('Sex At Birth')" />
                                <div>
                                    <select name="gender" id="gender" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('gender', '') == '' ? 'selected' : '' }}>Please select</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>
                        </div>

                        <span>
                            Other Information
                            <span class="text-red-500">(Required)</span>
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="maidenName" :value="__('Maiden Name (If Married)')" />
                                <x-text-input id="maidenName" class="block w-full mt-1" type="text" name="maidenName" autofocus value="{{ old('maidenName') }}"/>
                                <x-input-error :messages="$errors->get('maidenName')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="birthDate" :value="__('Birth Date')" />
                                <x-text-input id="birthDate" class="block w-full mt-1" type="date" name="birthDate" required autofocus value="{{ old('birthDate') }}"/>
                                <x-input-error :messages="$errors->get('birthDate')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="birthPlace" :value="__('Birth Place')" />
                                <x-text-input id="birthPlace" class="block w-full mt-1" type="text" name="birthPlace" required autofocus value="{{ old('birthPlace') }}"/>
                                <x-input-error :messages="$errors->get('birthPlace')" class="mt-2" />
                            </div>

                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="address" :value="__('House No./St./Vill./Subd./Compound')" />
                                <x-text-input id="address" class="block w-full mt-1" type="text" name="address" required autofocus value="{{ old('address') }}"/>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="region" :value="__('Region')" />
                                <div>
                                    <select name="region" id="region" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('region') === null ? 'selected' : '' }}>Please select</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->region_code }}" {{ old('region') == $region->region_code ? 'selected' : '' }}>{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('region')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="province" :value="__('Province')"/>
                                <div>
                                    <select name="province" id="province" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('province') === null ? 'selected' : '' }}>Please select</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('province')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="city" :value="__('City/Municipality')" />
                                <div>
                                    <select name="city" id="city" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('city') === null ? 'selected' : '' }}>Please select</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>
                            
                            <div class="w-1/3">
                                <x-input-label for="barangay" :value="__('Barangay')" />
                                <div>
                                    <select name="barangay" id="barangay" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('barangay') === null ? 'selected' : '' }}>Please select</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                            </div>
                            
                            <div class="w-1/3">
                            </div>
                        </div>

                        <span>
                            Father's Information
                            <span class="text-red-500">(Required)</span>
                        </span>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="fatherLast" :value="__('Last Name')" />
                                <x-text-input id="fatherLast" class="block w-full mt-1" type="text" name="fatherLast" required value="{{ old('fatherLast') }}"/>
                                <x-input-error :messages="$errors->get('fatherLast')" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="fatherFirst" :value="__('First Name')" />
                                <x-text-input id="fatherFirst" class="block w-full mt-1" type="text" name="fatherFirst" required value="{{ old('fatherFirst') }}"/>
                                <x-input-error :messages="$errors->get('fatherFirst')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="fatherMiddle" :value="__('Middle Name')" />
                                <x-text-input id="fatherMiddle" class="block w-full mt-1" type="text" name="fatherMiddle" value="{{ old('fatherMiddle') }}"/>
                                <x-input-error :messages="$errors->get('fatherMiddle')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="fatherSuffix" :value="__('Suffix')" />
                                <div>
                                    <select name="fatherSuffix" id="fatherSuffix" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('fatherSuffix', '') == '' ? 'selected' : '' }}>Please select</option>
                                        <option value="None" {{ old('fatherSuffix', '') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Jr." {{ old('fatherSuffix', '') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                        <option value="Sr." {{ old('fatherSuffix', '') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                        <option value="II" {{ old('fatherSuffix', '') == 'II' ? 'selected' : '' }}>II</option>
                                        <option value="III" {{ old('fatherSuffix', '') == 'III' ? 'selected' : '' }}>III</option>
                                        <option value="IV" {{ old('fatherSuffix', '') == 'IV' ? 'selected' : '' }}>IV</option>
                                        <option value="V" {{ old('fatherSuffix', '') == 'V' ? 'selected' : '' }}>V</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('fatherSuffix')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="fatherAddress" :value="__('Address')" />
                                <x-text-input id="fatherAddress" class="block w-full mt-1" type="text" name="fatherAddress" required value="{{ old('fatherAddress') }}"/>
                                <x-input-error :messages="$errors->get('fatherAddress')" class="mt-2" />
                                <div class="flex flex-row items-center w-full h-4 gap-1 py-3 mt-2">
                                    <input type="checkbox" id="sameFather">
                                    <label for="sameFather">Same as Applicant's Address</label>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="fatherContact" :value="__('Contact Number')" />
                                <x-text-input id="fatherContact" class="block w-full mt-1" type="number" name="fatherContact" required value="{{ old('fatherContact') }}"/>
                                <x-input-error :messages="$errors->get('fatherContact')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="fatherJob" :value="__('Occupation')" />
                                <x-text-input id="fatherJob" class="block w-full mt-1" type="text" name="fatherJob" required value="{{ old('fatherJob') }}"/>
                                <x-input-error :messages="$errors->get('fatherJob')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="fatherIncome" :value="__('Income (in Pesos)')" />
                                <x-text-input id="fatherIncome" class="block w-full mt-1" type="number" name="fatherIncome" required value="{{ old('fatherIncome') }}"/>
                                <x-input-error :messages="$errors->get('fatherIncome')" class="mt-2" />
                            </div>
                        </div>

                        <span>
                            Mother's Information (Maiden Name)
                            <span class="text-red-500">(Required)</span>
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="motherLast" :value="__('Last Name')" />
                                <x-text-input id="motherLast" class="block w-full mt-1" type="text" name="motherLast" required value="{{ old('motherLast') }}"/>
                                <x-input-error :messages="$errors->get('motherLast')" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="motherFirst" :value="__('First Name')" />
                                <x-text-input id="motherFirst" class="block w-full mt-1" type="text" name="motherFirst" required value="{{ old('motherFirst') }}"/>
                                <x-input-error :messages="$errors->get('motherFirst')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="motherMiddle" :value="__('Middle Name')" />
                                <x-text-input id="motherMiddle" class="block w-full mt-1" type="text" name="motherMiddle" value="{{ old('motherMiddle') }}"/>
                                <x-input-error :messages="$errors->get('motherMiddle')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="motherSuffix" :value="__('Suffix')" />
                                <div>
                                    <select name="motherSuffix" id="motherSuffix" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('motherSuffix', '') == '' ? 'selected' : '' }}>Please select</option>
                                        <option value="None" {{ old('motherSuffix', '') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Jr." {{ old('motherSuffix', '') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                        <option value="Sr." {{ old('motherSuffix', '') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                        <option value="II" {{ old('motherSuffix', '') == 'II' ? 'selected' : '' }}>II</option>
                                        <option value="III" {{ old('motherSuffix', '') == 'III' ? 'selected' : '' }}>III</option>
                                        <option value="IV" {{ old('motherSuffix', '') == 'IV' ? 'selected' : '' }}>IV</option>
                                        <option value="V" {{ old('motherSuffix', '') == 'V' ? 'selected' : '' }}>V</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('motherSuffix')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="motherAddress" :value="__('Address')" />
                                <x-text-input id="motherAddress" class="block w-full mt-1" type="text" name="motherAddress" required value="{{ old('motherAddress') }}"/>
                                <x-input-error :messages="$errors->get('motherAddress')" class="mt-2" />
                                <div class="flex flex-row items-center w-full h-4 gap-1 py-3 mt-2">
                                    <input type="checkbox" id="sameMother">
                                    <label for="sameMother">Same as Applicant's Address</label>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="motherContact" :value="__('Contact Number')" />
                                <x-text-input id="motherContact" class="block w-full mt-1" type="number" name="motherContact" required value="{{ old('motherContact') }}"/>
                                <x-input-error :messages="$errors->get('motherContact')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="motherJob" :value="__('Occupation')" />
                                <x-text-input id="motherJob" class="block w-full mt-1" type="text" name="motherJob" required value="{{ old('motherJob') }}"/>
                                <x-input-error :messages="$errors->get('motherJob')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="motherIncome" :value="__('Income')" />
                                <x-text-input id="motherIncome" class="block w-full mt-1" type="number" name="motherIncome" required value="{{ old('motherIncome') }}"/>
                                <x-input-error :messages="$errors->get('motherIncome')" class="mt-2" />
                            </div>
                        </div>

                        <span>
                            Guardian's Information
                            <span class="">(Optional)</span>
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="guardianLast" :value="__('Last Name')" />
                                <x-text-input id="guardianLast" class="block w-full mt-1" type="text" name="guardianLast" value="{{ old('guardianLast') }}"/>
                                <x-input-error :messages="$errors->get('guardianLast')" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="guardianFirst" :value="__('First Name')" />
                                <x-text-input id="guardianFirst" class="block w-full mt-1" type="text" name="guardianFirst" value="{{ old('guardianFirst') }}"/>
                                <x-input-error :messages="$errors->get('guardianFirst')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="guardianMiddle" :value="__('Middle Name')" />
                                <x-text-input id="guardianMiddle" class="block w-full mt-1" type="text" name="guardianMiddle" value="{{ old('guardianMiddle') }}"/>
                                <x-input-error :messages="$errors->get('guardianMiddle')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="guardianSuffix" :value="__('Suffix')" />
                                <div>
                                    <select name="guardianSuffix" id="guardianSuffix" class="block w-full mt-1">
                                        <option value="" disabled {{ old('guardianSuffix', '') == '' ? 'selected' : '' }}>Please select</option>
                                        <option value="None" {{ old('guardianSuffix', '') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Jr." {{ old('guardianSuffix', '') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                        <option value="Sr." {{ old('guardianSuffix', '') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                        <option value="II" {{ old('guardianSuffix', '') == 'II' ? 'selected' : '' }}>II</option>
                                        <option value="III" {{ old('guardianSuffix', '') == 'III' ? 'selected' : '' }}>III</option>
                                        <option value="IV" {{ old('guardianSuffix', '') == 'IV' ? 'selected' : '' }}>IV</option>
                                        <option value="V" {{ old('guardianSuffix', '') == 'V' ? 'selected' : '' }}>V</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('guardianSuffix')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="guardianAddress" :value="__('Address')" />
                                <x-text-input id="guardianAddress" class="block w-full mt-1" type="text" name="guardianAddress" value="{{ old('guardianAddress') }}"/>
                                <x-input-error :messages="$errors->get('guardianAddress')" class="mt-2" />

                                <div class="flex flex-row items-center w-full h-4 gap-1 py-3 mt-2">
                                    <input type="checkbox" id="sameGuardian">
                                    <label for="sameGuardian">Same as Applicant's Address</label>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="guardianContact" :value="__('Contact Number')" />
                                <x-text-input id="guardianContact" class="block w-full mt-1" type="text" name="guardianContact" value="{{ old('guardianContact') }}"/>
                                <x-input-error :messages="$errors->get('guardianContact')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="guardianJob" :value="__('Occupation')" />
                                <x-text-input id="guardianJob" class="block w-full mt-1" type="text" name="guardianJob" value="{{ old('guardianJob') }}"/>
                                <x-input-error :messages="$errors->get('guardianJob')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="guardianIncome" :value="__('Income')" />
                                <x-text-input id="guardianIncome" class="block w-full mt-1" type="text" name="guardianIncome" value="{{ old('guardianIncome') }}"/>
                                <x-input-error :messages="$errors->get('guardianMiddle')" class="mt-2" />
                            </div>
                        </div>

                        <span>
                            School Information
                            <span class="text-red-500">(Required)</span>
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="lrn" :value="__('Learner\'s Reference No. (LRN)')" />
                                <x-text-input id="lrn" class="block w-full mt-1" type="number" name="lrn" required value="{{ old('lrn') }}"/>
                            </div>
                            <div class="relative w-1/3 search-bar">
                                <x-input-label for="school" :value="__('School/Senior High School Attended')" />
                                <x-text-input id="school" class="block w-full mt-1" type="text" name="school" required autocomplete="off" value="{{ old('school') }}"/>
                                
                                <div class="absolute hidden w-full h-auto bg-white border border-gray-300 rounded-md max-h-80 datalist">

                                </div>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="schoolEmail" :value="__('School Email Address')" />
                                <x-text-input id="schoolEmail" class="block w-full mt-1" type="email" name="schoolEmail" required value="{{ old('schoolEmail') }}"/>
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="schoolType" :value="__('School Type')" />
                                <div>
                                    <select name="schoolType" id="schoolType" required class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('schoolType') == '' ? 'selected' : '' }}>Select Type</option>
                                        <option value="public" {{ old('schoolType') == 'public' ? 'selected' : '' }}>Public</option>
                                        <option value="private" {{ old('schoolType') == 'private' ? 'selected' : '' }}>Private</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="schoolAdd" :value="__('School Address')" />
                                <x-text-input id="schoolAdd" class="block w-full mt-1" type="text" name="schoolAdd" required autofocus value="{{ old('schoolAdd') }}"/>
                                <x-input-error :messages="$errors->get('schoolAdd')" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="schoolReg" :value="__('School Region')" />
                                <div>
                                    <select name="schoolReg" id="schoolReg" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('schoolReg') === null ? 'selected' : '' }}>Please select</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->region_code }}" {{ old('region') == $region->region_code ? 'selected' : '' }}>{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('schoolReg')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="schoolProv" :value="__('School Province')" />
                                <div>
                                    <select name="schoolProv" id="schoolProv" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('schoolProv') === null ? 'selected' : '' }}>Please select</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('schoolProv')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="schoolMun" :value="__('School City/Municipality')" />
                                <div>
                                    <select name="schoolMun" id="schoolMun" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('schoolMun') === null ? 'selected' : '' }}>Please select</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('schoolMun')" class="mt-2" />
                            </div>
                            
                            <div class="w-1/3">
                                <x-input-label for="strand" :value="__('Academic Strand')" />
                                <div>
                                    <select name="strand" id="strand" required class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('strand') == '' ? 'selected' : '' }}>Select Strand</option>
                                        <option value="ABM" {{ old('strand') == 'ABM' ? 'selected' : '' }}>Accountancy, Business and Management (ABM)</option>
                                        <option value="HUMSS" {{ old('strand') == 'HUMSS' ? 'selected' : '' }}>Humanities and Social Sciences (HUMSS)</option>
                                        <option value="STEM" {{ old('strand') == 'STEM' ? 'selected' : '' }}>Science, Technology, Engineering and Mathematics (STEM)</option>
                                        <option value="GAS" {{ old('strand') == 'GAS' ? 'selected' : '' }}>General Academic Strand (GAS)</option>
                                        <option value="TVL" {{ old('strand') == 'TVL' ? 'selected' : '' }}>Technical-Vocational Livelihood (TVL)</option>
                                        <option value="SPORTS" {{ old('strand') == 'SPORTS' ? 'selected' : '' }}>Sports Track</option>
                                        <option value="ADT" {{ old('strand') == 'ADT' ? 'selected' : '' }}>Arts and Design Track</option>
                                        <option value="PBM" {{ old('strand') == 'PBM' ? 'selected' : '' }}>Pre-Baccalaureate Maritime</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="gwa" :value="__('Grade Weighted Average (GWA)')" />
                                <x-text-input id="gwa" class="block w-full mt-1" type="number" name="gwa" required value="{{ old('gwa') }}"/>
                            </div>
                        </div>

                        <span>
                            Program Choices
                            <span class="text-red-500">(Required)</span>
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="choice1" :value="__('Program Choice 1')" />
                                <div>
                                    <select name="choice1" id="choice1" required class="block w-full mt-1" required onchange="updateSelectOptions()">
                                        <option value="" disabled {{ old('choice1') == '' ? 'selected' : '' }}>Select Program Choice 1</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->course_code }}" {{ old('choice1') == $course->course_code ? 'selected' : '' }}>{{ $course->course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="choice2" :value="__('Program Choice 2')" />
                                <div>
                                    <select name="choice2" id="choice2" required class="block w-full mt-1" required onchange="updateSelectOptions()">
                                        <option value="" disabled {{ old('choice2') == '' ? 'selected' : '' }}>Select Program Choice 2</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->course_code }}" {{ old('choice2') == $course->course_code ? 'selected' : '' }}>{{ $course->course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="choice3" :value="__('Program Choice 3')" />
                                <div>
                                    <select name="choice3" id="choice3" required class="block w-full mt-1" required onchange="updateSelectOptions()">
                                        <option value="" disabled {{ old('choice3') == '' ? 'selected' : '' }}>Select Program Choice 3</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->course_code }}" {{ old('choice3') == $course->course_code ? 'selected' : '' }}>{{ $course->course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <span>
                            Required Documents (PDF ONLY)
                            <span class="text-red-500">(Required)</span>
                        </span>
                        
                        <div>
                            <x-input-label for="birthCert" :value="__('Birth Certificate (PSA)')" />
                            <x-text-input id="birthCert" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="birthCert" required accept=".pdf"/>
                            <x-input-error :messages="$errors->get('birthCert')" class="mt-2" />
                        </div>
                        
                        <div id="shsInputs" style="display: none;">
                            <x-input-label for="form137" :value="__('Form 137')" />
                            <x-text-input id="form137" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="form137" accept=".pdf" />
                            <x-input-error :messages="$errors->get('form137')" class="mt-2" />
                        </div>

                        <div id="alsInputs" style="display: none;">
                            <x-input-label for="certificate" :value="__('Certificate')" />
                            <x-text-input id="certificate" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="certificate" accept=".pdf" />
                            <x-input-error :messages="$errors->get('certificate')" class="mt-2" />
                        </div>

                        <div id="oldInputs" style="display: none;">
                            <div>
                                <x-input-label for="approvalLetter" :value="__('Letter of Approval')" />
                                <x-text-input id="approvalLetter" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="approvalLetter" accept=".pdf" />
                                <x-input-error :messages="$errors->get('approvalLetter')" class="mt-2" />
                            </div>

                            <div class="mt-8">
                                <x-input-label for="highSchoolCard" :value="__('High School Card')" />
                                <x-text-input id="highSchoolCard" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="highSchoolCard" accept=".pdf" />
                                <x-input-error :messages="$errors->get('highSchoolCard')" class="mt-2" />
                            </div>
                        </div>

                        <div id="transfereeInputs" style="display: none;">
                            <x-input-label for="transcriptRecord" :value="__('Transcript of Record')" />
                            <x-text-input id="transcriptRecord" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="transcriptRecord" accept=".pdf" />
                            <x-input-error :messages="$errors->get('transcriptRecord')" class="mt-2" />
                        </div>
                        
                        <div x-data="{ agreed: false }">
                            <div class="flex items-center">
                                <input id="terms-and-privacy" name="terms-and-privacy" type="checkbox" class="" x-model="agreed" />
                                <label for="terms-and-privacy" class="block ml-2 text-sm text-gray-900">
                                    I agree to the
                                    <button type="button" id="showFormButton1" class="text-indigo-600 hover:text-indigo-500">Data Privary Consent Form</a>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{  route('welcome.page', ['currentRoute' => 'home' ]) }}" wire:navigate>
                                    {{ __('Already registered?') }}
                                </a>

                                <button class="px-6 py-2 text-white bg-gray-700 rounded-lg ms-4" :disabled="!agreed">
                                    {{ __('Apply') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="floatingForm1" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 overflow-y-scroll bg-white shadow-lg w-70v h-80v">
                <button onclick="toggleForm1()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                <h1 class="mb-4 text-2xl font-bold text-center">DATA PRIVACY CONSENT FORM</h1>
                <p class="mb-4">The Pamantasan ng Lungsod ng Maynila (PLM) and its duly authorized representatives are
                    duty-bound and obligated under Republic Act No. 10173 (Data Privacy Act of 2012) and its Implementing Rules and Regulations (IRR), and other data privacy rules, to protect the personal and sensitive personal information that PLM collects, possesses, and retains upon your enrollment and during your stay in the University.
                </p>
                <p class="mb-4">Personal and sensitive personal information includes any information about your identity, academics, or any document containing your identity. This includes, but is not limited to, your name, address, landline/mobile number, email address, names of your parents or guardians, date of birth, academic information such as grades and attendance, and other information necessary for basic administration and instruction. By consenting to this Data Privacy Consent Form, you agree that:</p>

                <ol class="mb-4 ml-6 list-decimal">
                    <li class="mb-2">You authorize the University to collect, retain and process information relating to your PLMAT application for purposes of admission to the University and for your subsequent enrollment should you eventually qualify to be admitted in PLM. PLM shall also collect, retain and process your personal and sensitive personal information to pursue its legitimate interests as an educational and government institution.</li>
                    <li class="mb-2">You expressly authorize PLM to verify, validate and authenticate the information and documents that you submitted with relevant government and non-government sources and third parties, for purposes of your admission, enrollment, and other legitimate transactions in PLM.</li>
                    <li class="mb-2">You authorize PLM to share your personal and sensitive personal information with its affiliated or partner organizations as part of its contractual obligations, or with government agencies such as, but not exclusive to, the Commission on Higher Education (CHED), UniFAST, and the City Government of Manila, pursuant to law or legal processes.</li>
                    <li class="mb-2">You understand that photocopies or electronic copies of the personal documents that you submitted in relation to your application for admission will either be returned to you or properly disposed of by PLM if you are not accepted for admission or should you decide not to pursue your application. On the other hand, once accepted and upon enrollment, you will submit the originals of the needed documents to the Office of the University Registrar.</li>
                    <li class="mb-2">If the University has determined that you qualify for the Social Amelioration Program (SAP) of the City of Manila under City Ordinance No. 8568, you further authorize PLM and the City Government of Manila, their agents, representatives and/or outsourced service providers, to:</li>
                    <ol class="mb-2 ml-6 list-decimal">
                        <li class="mb-2">Collect, process, update or disclose personal information about you, and to obtain information about your personal and academic records, for the purpose of availing the services of the Land Bank of the Philippines (LBP), or any necessary third party, for the monthly monetary allowance program of the City Government of Manila; and</li>
                        <li class="mb-2">Establish, confirm, review or update your record with the said LBP or necessary third party, provided that the same is for a legitimate purpose, and to use, submit, or issue the same to comply with reporting obligations under applicable laws, rules and regulations.</li>
                    </ol>
                    <p class="mb-2">For this purpose, you agree to hold the City Government of Manila and PLM and the persons or entities from whom they may obtain, or with whom they may disclose or verify your personal information, free and harmless from any liability arising from the use of any such information.</p>
                    <li class="mb-2">You confirm that you are aware that under the Data Privacy Act, you have (a) the right to withdraw the consent hereby given or to object to the processing of your personal information provided there is no other legal ground or overriding legitimate interest for the processing thereof; (b) the right to reasonable access; (c) the right to rectification; and (d) the right to erasure or blocking of your personal information; subject, however to the conditions for the legitimate exercise of the said rights under the Data Privacy Act and its IRR, and subject further to the right of PLM to disqualify you from admission or enrollment to PLM or from availing of any transaction or benefit to which you may be entitled under the laws or other rules and regulations, should you withdraw your consent or request the removal of your personal information.</li>
                </ol>
            </div>
        </div>

        <script>
            function toggleForm1() {
                var form = document.getElementById('floatingForm1');
                var body = document.body;

                // Toggle the hidden class
                form.classList.toggle('hidden');

                // Toggle the no-scroll class on the body
                if (form.classList.contains('hidden')) {
                    body.classList.remove('no-scroll');
                } else {
                    body.classList.add('no-scroll');
                }
            }

            document.getElementById('showFormButton1').addEventListener('click', toggleForm1);
            
            var schools = @json($schools);
            const search = document.querySelector('.search-bar');
            const datalist = search.querySelector('.datalist');
            const input = search.querySelector('input');

            input.onkeyup = (e) =>{
                let schoolInput = e.target.value;
                let result = [];
                datalist.classList.remove('hidden');
                
                if(schoolInput){
                    result = schools.filter((data) => {
                        return data.toLocaleLowerCase().includes(schoolInput.toLocaleLowerCase());
                    });

                    result = result.map((data) => {
                        return data = '<li class="w-full px-2 py-1.5 cursor-default hover:bg-gray-300" onclick="selectOption()">' + data + '</li>';
                    });

                    console.log(result);
                }

                if (schoolInput.length < 1) {
                    result = [];
                    datalist.classList.add('hidden');
                }
                else
                {
                    displayResult(result);
                }
            }

            function selectOption(){
                input.value = event.target.innerText;
                datalist.classList.add('hidden');
            }

            function displayResult(result){
                let list;
                
                if(!result.length){
                    datalist.classList.add('hidden');
                }
                else{
                    list = result.join('');
                }
                
                datalist.innerHTML = '<ul class="h-full p-2 overflow-y-scroll max-h-80">' + list + '</ul>';
            }

            function updateSelectOptions() {
                var selects = document.querySelectorAll('select[name^="choice"]');
                var selectedValues = Array.from(selects).map(function (s) { return s.value; });

                selects.forEach(function (s) {
                    Array.from(s.options).forEach(function (option) {
                        if (option.value === "" || (selectedValues.includes(option.value) && s.value !== option.value)) {
                            option.disabled = true;
                        } else {
                            option.disabled = false;
                        }
                    });
                });
            }

            $(document).ready(function() {
                $('#applicationType').on('change', function() {
                    var selectedType = this.value;
                    var shsInputs = document.getElementById('shsInputs');
                    var alsInputs = document.getElementById('alsInputs');
                    var oldInputs = document.getElementById('oldInputs');
                    var transfereeInputs = document.getElementById('transfereeInputs');

                    shsInputs.style.display = 'none';
                    alsInputs.style.display = 'none';
                    oldInputs.style.display = 'none';
                    transfereeInputs.style.display = 'none';

                    switch (selectedType) {
                        case 'SHS':
                            shsInputs.style.display = 'block';
                            break;
                        case 'ALS':
                            alsInputs.style.display = 'block';
                            break;
                        case 'OLD':
                            oldInputs.style.display = 'block';
                            break;
                        case 'TRANSFER':
                            transfereeInputs.style.display = 'block';
                            break;
                    }
                }).trigger('change');

                $('#address').on('change', function() {
                    $('#sameFather').prop('checked', false).trigger('change');
                    $('#sameMother').prop('checked', false).trigger('change');
                });
                
                $('#region').on('change', function() {
                    var regionCode = $(this).val();
                    $('#sameFather').prop('checked', false).trigger('change');
                    $('#sameMother').prop('checked', false).trigger('change');
                    $.ajax({
                        url: '/get-provinces/' + regionCode,
                        type: 'GET',
                        success: function(data) {
                            $('#province').html(data);
                            $('#city').html('<option value="" disabled selected="true">Please select</option>');
                            $('#barangay').html('<option value="" disabled selected="true">Please select</option>');
                            var oldProvince = "{{ old('province') }}";
                            if (oldProvince) {
                                $('#province').val(oldProvince).trigger('change');
                            }
                        }
                    });
                }).trigger('change');

                $('#province').on('change', function() {
                    var provinceCode = $(this).val();
                    $('#sameFather').prop('checked', false).trigger('change');
                    $('#sameMother').prop('checked', false).trigger('change');
                    $.ajax({
                        url: '/get-cities/' + provinceCode,
                        type: 'GET',
                        success: function(data) {
                            $('#city').html(data);
                            $('#barangay').html('<option value="" disabled selected="true">Please select</option>');
                            var oldCity = "{{ old('city') }}";
                            if (oldCity) {
                                $('#city').val(oldCity).trigger('change');
                            }
                        }
                    });
                });

                $('#city').on('change', function() {
                    var cityCode = $(this).val();
                    $('#sameFather').prop('checked', false).trigger('change');
                    $('#sameMother').prop('checked', false).trigger('change');
                    $.ajax({
                        url: '/get-barangays/' + cityCode,
                        type: 'GET',
                        success: function(data) {
                            $('#barangay').html(data);
                            var oldBarangay = "{{ old('barangay') }}";
                            if (oldBarangay) {
                                $('#barangay').val(oldBarangay);
                            }
                        }
                    });
                });

                $('#sameFather').on('change', function() {
                    if ($(this).is(':checked')) {
                        var address = $('#address').val();
                        var region = $('#region option:selected').text();
                        var province = $('#province option:selected').text();
                        var city = $('#city option:selected').text();
                        var barangay = $('#barangay option:selected').text();

                        if (address != "" && region != "Please select" && province != "Please select" && city != "Please select" && barangay != "Please select") {
                            $('#fatherAddress').val([address, barangay, city, province, region].filter(Boolean).join(', '));
                        }
                        else
                        {
                            $(this).prop('checked', false);
                        }
                    } else {
                        $('#fatherAddress').val('');
                    }
                });

                $('#sameMother').on('change', function() {
                    if ($(this).is(':checked')) {
                        var address = $('#address').val();
                        var region = $('#region option:selected').text();
                        var province = $('#province option:selected').text();
                        var city = $('#city option:selected').text();
                        var barangay = $('#barangay option:selected').text();

                        if (address != "" && region != "Please Select" && province != "Please Select" && city != "Please Select" && barangay != "Please Select") {
                            $('#motherAddress').val([address, barangay, city, province, region].filter(Boolean).join(', '));
                        }
                        else
                        {
                            $(this).prop('checked', false);
                        }
                    } else {
                        $('#motherAddress').val('');
                    }
                });

                $('#sameGuardian').on('change', function() {
                    if ($(this).is(':checked')) {
                        var address = $('#address').val();
                        var region = $('#region option:selected').text();
                        var province = $('#province option:selected').text();
                        var city = $('#city option:selected').text();
                        var barangay = $('#barangay option:selected').text();

                        if (address != "" && region != "Please Select" && province != "Please Select" && city != "Please Select" && barangay != "Please Select") {
                            $('#guardianAddress').val([address, barangay, city, province, region].filter(Boolean).join(', '));
                        }
                        else
                        {
                            $(this).prop('checked', false);
                        }
                    } else {
                        $('#guardianAddress').val('');
                    }
                });

                $('#schoolReg').on('change', function() {
                    var regionCode = $(this).val();
                    $.ajax({
                        url: '/get-provinces/' + regionCode,
                        type: 'GET',
                        success: function(data) {
                            $('#schoolProv').html(data);
                            $('#schoolMun').html('<option value="" disabled selected="true">Please select</option>');
                            var oldProvince = "{{ old('schoolProv') }}";
                            if (oldProvince) {
                                $('#province').val(oldProvince).trigger('change');
                            }
                            
                        }
                    });
                }).trigger('change');

                $('#schoolProv').on('change', function() {
                    var provinceCode = $(this).val();

                    $.ajax({
                        url: '/get-cities/' + provinceCode,
                        type: 'GET',
                        success: function(data) {
                            $('#schoolMun').html(data);

                            var oldCity = "{{ old('schoolMun') }}";
                            if (oldCity) {
                                $('#city').val(oldCity).trigger('change');
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>