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
        </style>
    </head>
    
    <body class="font-sans antialiased text-gray-900">
        <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-11/12 px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div>
                    <form action="{{ route('apply.post') }}" method="POST" class="flex flex-col gap-7" enctype="multipart/form-data">
                        <!-- Name -->
                        @csrf

                        <span>Personal Information</span>
                        
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
                                <x-text-input id="middleName" class="block w-full mt-1" type="text" name="middleName" required autofocus value="{{ old('middleName') }}"/>
                                
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="suffix" :value="__('Suffix')" />
                                <div>
                                    <select name="suffix" id="suffix" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('suffix') == '' ? 'selected' : '' }}>Please select</option>
                                        <option value="" {{ old('suffix') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Jr." {{ old('suffix') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                        <option value="Sr." {{ old('suffix') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                        <option value="II" {{ old('suffix') == 'II' ? 'selected' : '' }}>II</option>
                                        <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                                        <option value="IV" {{ old('suffix') == 'IV' ? 'selected' : '' }}>IV</option>
                                        <option value="V" {{ old('suffix') == 'V' ? 'selected' : '' }}>V</option>
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
                                <x-input-label for="applicationType" :value="__('Appication Type')" />
                                <div>
                                    <select name="applicationType" id="applicationType" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('applicationType') == '' ? 'selected' : '' }}>Please select</option>
                                        <option value="SHS" {{ old('applicationType') == 'SHS' ? 'selected' : '' }}>Senior High School</option>
                                        <option value="ALS" {{ old('applicationType') == 'ALS' ? 'selected' : '' }}>Alternative Learning System</option>
                                        <option value="OLD" {{ old('applicationType') == 'OLD' ? 'selected' : '' }}>High School Graduate</option>
                                        <option value="TRANSFER" {{ old('applicationType') == 'TRANSFER' ? 'selected' : '' }}>Transferee</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('applicationType')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="gender" :value="__('Gender')" />
                                <div>
                                    <select name="gender" id="gender" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('gender') === null ? 'selected' : '' }}>Please select</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>
                        </div>

                        <span>Other Information</span>
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

                        <span>Father's Information</span>
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
                                <x-text-input id="fatherMiddle" class="block w-full mt-1" type="text" name="fatherMiddle" required value="{{ old('fatherMiddle') }}"/>
                                <x-input-error :messages="$errors->get('fatherMiddle')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="fatherSuffix" :value="__('Suffix')" />
                                <div>
                                    <select name="fatherSuffix" id="fatherSuffix" class="block w-full mt-1" required>
                                        <option value="" disabled {{ old('suffix') == '' ? 'selected' : '' }}>Please select</option>
                                        <option value="" {{ old('suffix') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Jr." {{ old('suffix') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                        <option value="Sr." {{ old('suffix') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                        <option value="II" {{ old('suffix') == 'II' ? 'selected' : '' }}>II</option>
                                        <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                                        <option value="IV" {{ old('suffix') == 'IV' ? 'selected' : '' }}>IV</option>
                                        <option value="V" {{ old('suffix') == 'V' ? 'selected' : '' }}>V</option>
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

                        <span>Mother's Information (Maiden Name)</span>
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="motherLast" :value="__('Last Name')" />
                                <x-text-input id="motherLast" class="block w-full mt-1" type="text" name="motherLast" required/>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="motherFirst" :value="__('First Name')" />
                                <x-text-input id="motherFirst" class="block w-full mt-1" type="text" name="motherFirst" required/>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="motherMiddle" :value="__('Middle Name')" />
                                <x-text-input id="motherMiddle" class="block w-full mt-1" type="text" name="motherMiddle" required/>
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="motherSuffix" :value="__('Suffix')" />
                                <div>
                                    <select name="motherSuffix" id="motherSuffix" class="block w-full mt-1" required>
                                        <option value="" disabled selected="true">Please select</option>
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
                                <x-input-label for="motherAddress" :value="__('Address')" />
                                <x-text-input id="motherAddress" class="block w-full mt-1" type="text" name="motherAddress" required/>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="motherContact" :value="__('Contact Number')" />
                                <x-text-input id="motherContact" class="block w-full mt-1" type="text" name="motherContact" required/>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="motherJob" :value="__('Occupation')" />
                                <x-text-input id="motherJob" class="block w-full mt-1" type="text" name="motherJob" required/>
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="motherIncome" :value="__('Income')" />
                                <x-text-input id="motherIncome" class="block w-full mt-1" type="text" name="motherIncome" required/>
                            </div>
                        </div>

                        <span>Guardian's Information</span>
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="guardianLast" :value="__('Last Name')" />
                                <x-text-input id="guardianLast" class="block w-full mt-1" type="text" name="guardianLast"/>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="guardianFirst" :value="__('First Name')" />
                                <x-text-input id="guardianFirst" class="block w-full mt-1" type="text" name="guardianFirst"/>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="guardianMiddle" :value="__('Middle Name')" />
                                <x-text-input id="guardianMiddle" class="block w-full mt-1" type="text" name="guardianMiddle"/>
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="guardianSuffix" :value="__('Suffix')" />
                                <div>
                                    <select name="guardianSuffix" id="guardianSuffix" class="block w-full mt-1">
                                        <option value="" disabled selected="true">Please select</option>
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
                                <x-input-label for="guardianAddress" :value="__('Address')" />
                                <x-text-input id="guardianAddress" class="block w-full mt-1" type="text" name="guardianAddress"/>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="guardianContact" :value="__('Contact Number')" />
                                <x-text-input id="guardianContact" class="block w-full mt-1" type="text" name="guardianContact"/>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="guardianJob" :value="__('Occupation')" />
                                <x-text-input id="guardianJob" class="block w-full mt-1" type="text" name="guardianJob"/>
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="guardianIncome" :value="__('Income')" />
                                <x-text-input id="guardianIncome" class="block w-full mt-1" type="text" name="guardianIncome"/>
                            </div>
                        </div>

                        <span>School Information</span>
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="lrn" :value="__('Learner\'s Reference No. (LRN)')" />
                                <x-text-input id="lrn" class="block w-full mt-1" type="text" name="lrn" required/>
                            </div>
                            <div class="relative w-1/3 search-bar">
                                <x-input-label for="school" :value="__('School/Senior High School Attended')" />
                                <x-text-input id="school" class="block w-full mt-1" type="text" name="school" required autocomplete="off"/>
                                
                                <div class="absolute hidden w-full h-auto bg-white border border-gray-300 rounded-md max-h-80 datalist">

                                </div>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="schoolEmail" :value="__('School Email Address')" />
                                <x-text-input id="schoolEmail" class="block w-full mt-1" type="email" name="schoolEmail" required/>
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="schoolType" :value="__('School Type')" />
                                <div>
                                    <select name="schoolType" id="schoolType" required class="block w-full mt-1" required>
                                        <option value="">Select Type</option>
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="strand" :value="__('Academic Strand')" />
                                <div>
                                    <select name="strand" id="strand" required class="block w-full mt-1" required>
                                        <option value="" disabled selected="true">Select Strand</option>
                                        <option value="ABM">Accountancy, Business and Management (ABM)</option>
                                        <option value="HUMSS">Humanities and Social Sciences (HUMSS)</option>
                                        <option value="STEM">Science, Technology, Engineering and Mathematics (STEM)</option>
                                        <option value="GAS">General Academic Strand (GAS)</option>
                                        <option value="TVL">Technical-Vocational Livelihood (TVL)</option>
                                        <option value="SPORTS">Sports Track</option>
                                        <option value="ADT">Arts and Design Track</option>
                                        <option value="PBM">Pre-Baccalaureate Maritime</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="gwa" :value="__('Grade Weighted Average (GWA)')" />
                                <x-text-input id="gwa" class="block w-full mt-1" type="text" name="gwa" required/>
                            </div>

                            <div class="w-1/3">
                            </div>

                            <div class="w-1/6">
                            </div>
                        </div>

                        <span>Program Choices</span>
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="choice1" :value="__('Program Choice 1')" />
                                <div>
                                    <select name="choice1" id="choice1" required class="block w-full mt-1" required onchange="updateSelectOptions()">
                                        <option value="" disabled selected="true">Select Program Choice 1</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->course_code }}">{{ $course->course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="choice2" :value="__('Program Choice 2')" />
                                <div>
                                    <select name="choice2" id="choice2" required class="block w-full mt-1" required onchange="updateSelectOptions()">
                                        <option value="" disabled selected="true">Select Program Choice 2</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->course_code }}">{{ $course->course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="choice3" :value="__('Program Choice 3')" />
                                <div>
                                    <select name="choice3" id="choice3" required class="block w-full mt-1" required onchange="updateSelectOptions()">
                                        <option value="" disabled selected="true">Select Program Choice 3</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->course_code }}">{{ $course->course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <span>Required Documents (PDF ONLY)</span>
                        <div>
                            <x-input-label for="birthCert" :value="__('Birth Certificate (PSA)')" />
                            <x-text-input id="birthCert" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="birthCert" required accept=".pdf"/>
                            <x-input-error :messages="$errors->get('birthCert')" class="mt-2" />
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

        <script>
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
                $('#region').on('change', function() {
                    var regionCode = $(this).val();
                    $.ajax({
                        url: '/get-provinces/' + regionCode,
                        type: 'GET',
                        success: function(data) {
                            $('#province').html(data);
                            var oldProvince = "{{ old('province') }}";
                            if (oldProvince) {
                                $('#province').val(oldProvince).trigger('change');
                            }
                            $('#city').html('<option value="" disabled selected="true">Please select</option>');
                            $('#barangay').html('<option value="" disabled selected="true">Please select</option>');
                        }
                    });
                }).trigger('change');

                $('#province').on('change', function() {
                    var provinceCode = $(this).val();
                    $.ajax({
                        url: '/get-cities/' + provinceCode,
                        type: 'GET',
                        success: function(data) {
                            $('#city').html(data);
                            var oldCity = "{{ old('city') }}";
                            if (oldCity) {
                                $('#city').val(oldCity).trigger('change');
                            }
                            $('#barangay').html('<option value="" disabled selected="true">Please select</option>');
                        }
                    });
                });

                $('#city').on('change', function() {
                    var cityCode = $(this).val();
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

                        if (address != "" && region != "Please Select" && province != "Please Select" && city != "Please Select" && barangay != "Please Select") {
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
            });
        </script>
    </body>
</html>