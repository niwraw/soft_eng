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
                    <button type="button" onclick="history.back()" class="flex items-center gap-4 mb-6">
                        <span class="material-symbols-sharp">
                            arrow_back
                        </span>
                        <h2>Back</h2>
                    </button>
                    <form action="{{ route('applicant.update.information', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]) }}" method="POST" class="flex flex-col gap-7" enctype="multipart/form-data">
                        <!-- Name -->
                        @csrf

                        <span>
                            Personal Information
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="lastName" :value="__('Last Name')" />
                                <x-text-input id="lastName" class="block w-full mt-1" type="text" name="lastName" value="{{ $personal->lastName }}" required/>
                                <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="firstName" :value="__('First Name')" />
                                <x-text-input id="firstName" class="block w-full mt-1" type="text" name="firstName" required autofocus value="{{ $personal->firstName }}"/>
                                <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="middleName" :value="__('Middle Name')" />
                                <x-text-input id="middleName" class="block w-full mt-1" type="text" name="middleName" autofocus value="{{ $personal->middleName }}"/>
                                <x-input-error :messages="$errors->get('middleName')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="suffix" :value="__('Suffix')" />
                                <div class="relative mt-1">
                                    <x-text-input id="suffix" class="block w-full mt-1" type="text" name="suffix" autofocus value="{{ $personal->suffix }}" readonly/>
                                    <button type="button" onclick="editAppSuffix()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-700 hover:text-blue-500">
                                        <span class="material-symbols-sharp">edit</span>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input id="email" class="block w-full mt-1 bg-gray-200" type="email" name="email" required value="{{ $personal->email }}" disabled/>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="contactNum" :value="__('Contact Number')" />
                                <x-text-input id="contactNum" class="block w-full mt-1 bg-gray-200 appearance-none" type="number" name="contactNum" required value="{{ $personal->contactNum }}" maxlength="11" disabled/>
                                <x-input-error :messages="$errors->get('contactNum')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="applicationType" :value="__('Application Type')" />
                                <x-text-input id="applicationType" class="block w-full mt-1 bg-gray-200" name="applicationType" required value="{{ $personal->applicationType }}" disabled/>
                                <x-input-error :messages="$errors->get('applicationType')" class="mt-2"/>
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="gender" :value="__('Sex At Birth')" />
                                <div class="relative mt-1">
                                    <x-text-input id="gender" class="block w-full mt-1" name="gender" required value="{{ ucfirst($personal->gender) }}" readonly/>
                                    <button type="button" onclick="editGender()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-700 hover:text-blue-500">
                                        <span class="material-symbols-sharp">edit</span>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>
                        </div>

                        <span>
                            Other Information
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="maidenName" :value="__('Maiden Name (If Married)')" />
                                <x-text-input id="maidenName" class="block w-full mt-1" type="text" name="maidenName" autofocus value="{{ $other->maidenName }}"/>
                                <x-input-error :messages="$errors->get('maidenName')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="birthDate" :value="__('Birth Date')" />
                                <x-text-input id="birthDate" class="block w-full mt-1" type="date" name="birthDate" required autofocus value="{{ $other->birthDate }}"/>
                                <x-input-error :messages="$errors->get('birthDate')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="birthPlace" :value="__('Birth Place')" />
                                <x-text-input id="birthPlace" class="block w-full mt-1" type="text" name="birthPlace" required autofocus value="{{ $other->birthPlace }}"/>
                                <x-input-error :messages="$errors->get('birthPlace')" class="mt-2" />
                            </div>

                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="address" :value="__('House No./St./Vill./Subd./Compound')" />
                                <x-text-input id="address" class="block w-full mt-1" type="text" name="address" required autofocus value="{{ $other->address }}"/>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="region" :value="__('Region')" />
                                <x-text-input id="region" class="block w-full mt-1 cursor-pointer" type="text" name="region" required autofocus value="{{ $region }}" readonly/>
                                <x-input-error :messages="$errors->get('region')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="province" :value="__('Province')"/>
                                <x-text-input id="province" class="block w-full mt-1 cursor-pointer" type="text" name="province" required autofocus value="{{ $province }}" readonly/>
                                <x-input-error :messages="$errors->get('province')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="city" :value="__('City/Municipality')" />
                                <x-text-input id="city" class="block w-full mt-1 cursor-pointer" type="text" name="city" required autofocus value="{{ $city }}"/>
                                <x-input-error :messages="$errors->get('city')" class="mt-2" readonly/>
                            </div>
                            
                            <div class="w-1/3">
                                <x-input-label for="barangay" :value="__('Barangay')" />
                                <x-text-input id="barangay" class="block w-full mt-1 cursor-pointer" type="text" name="barangay" required autofocus value="{{ $barangay }}" readonly/>
                                <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                            </div>
                            
                            <div class="flex items-end justify-center w-1/3">
                                <button class="w-full px-6 py-2 text-white bg-gray-700 rounded-lg h-4/6 ms-4" type="button" onclick="editRegion()">
                                    Update Region/Province/City/Barangay
                                </button>
                            </div>
                        </div>

                        <span>
                            Father's Information
                        </span>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="fatherLast" :value="__('Last Name')" />
                                <x-text-input id="fatherLast" class="block w-full mt-1" type="text" name="fatherLast" required value="{{ $father->fatherLast }}"/>
                                <x-input-error :messages="$errors->get('fatherLast')" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="fatherFirst" :value="__('First Name')" />
                                <x-text-input id="fatherFirst" class="block w-full mt-1" type="text" name="fatherFirst" required value="{{ $father->fatherFirst }}"/>
                                <x-input-error :messages="$errors->get('fatherFirst')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="fatherMiddle" :value="__('Middle Name')" />
                                <x-text-input id="fatherMiddle" class="block w-full mt-1" type="text" name="fatherMiddle" value="{{ $father->fatherFirst }}"/>
                                <x-input-error :messages="$errors->get('fatherMiddle')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="fatherSuffix" :value="__('Suffix')" />
                                <div class="relative mt-1">
                                    <x-text-input id="fatherSuffix" class="block w-full mt-1 cursor-pointer" type="text" name="fatherSuffix" autofocus value="{{ $father->fatherSuffix }}" readonly/>
                                    <button type="button" onclick="editFatherSuffix()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-700 hover:text-blue-500">
                                        <span class="material-symbols-sharp">edit</span>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('fatherSuffix')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="fatherAddress" :value="__('Address')" />
                                <x-text-input id="fatherAddress" class="block w-full mt-1" type="text" name="fatherAddress" required value="{{ $father->fatherAddress }}"/>
                                <x-input-error :messages="$errors->get('fatherAddress')" class="mt-2" />
                                <div class="flex flex-row items-center w-full h-4 gap-1 py-3 mt-2">
                                    <input type="checkbox" id="sameFather" checked>
                                    <label for="sameFather">Same as Applicant's Address</label>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="fatherContact" :value="__('Contact Number')" />
                                <x-text-input id="fatherContact" class="block w-full mt-1" type="number" name="fatherContact" required value="{{ $father->fatherContact }}"/>
                                <x-input-error :messages="$errors->get('fatherContact')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="fatherJob" :value="__('Occupation')" />
                                <x-text-input id="fatherJob" class="block w-full mt-1" type="text" name="fatherJob" required value="{{ $father->fatherJob }}"/>
                                <x-input-error :messages="$errors->get('fatherJob')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="fatherIncome" :value="__('Income (in Pesos)')" />
                                <x-text-input id="fatherIncome" class="block w-full mt-1" type="number" name="fatherIncome" required value="{{ $father->fatherIncome }}"/>
                                <x-input-error :messages="$errors->get('fatherIncome')" class="mt-2" />
                            </div>
                        </div>

                        <span>
                            Mother's Information (Maiden Name)
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="motherLast" :value="__('Last Name')" />
                                <x-text-input id="motherLast" class="block w-full mt-1" type="text" name="motherLast" required value="{{ $mother->motherLast }}"/>
                                <x-input-error :messages="$errors->get('motherLast')" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="motherFirst" :value="__('First Name')" />
                                <x-text-input id="motherFirst" class="block w-full mt-1" type="text" name="motherFirst" required value="{{ $mother->motherFirst }}"/>
                                <x-input-error :messages="$errors->get('motherFirst')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="motherMiddle" :value="__('Middle Name')" />
                                <x-text-input id="motherMiddle" class="block w-full mt-1" type="text" name="motherMiddle" value="{{ $mother->motherMiddle }}"/>
                                <x-input-error :messages="$errors->get('motherMiddle')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="motherSuffix" :value="__('Suffix')" />
                                <div class="relative mt-1">
                                    <x-text-input id="motherSuffix" class="block w-full mt-1" type="text" name="motherSuffix" autofocus value="{{ $mother->motherSuffix }}" readonly/>
                                    <button type="button" onclick="editMotherSuffix()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-700 hover:text-blue-500">
                                        <span class="material-symbols-sharp">edit</span>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('motherSuffix')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="motherAddress" :value="__('Address')" />
                                <x-text-input id="motherAddress" class="block w-full mt-1" type="text" name="motherAddress" required value="{{ $mother->motherAddress }}"/>
                                <x-input-error :messages="$errors->get('motherAddress')" class="mt-2" />
                                <div class="flex flex-row items-center w-full h-4 gap-1 py-3 mt-2">
                                    <input type="checkbox" id="sameMother" checked>
                                    <label for="sameMother">Same as Applicant's Address</label>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="motherContact" :value="__('Contact Number')" />
                                <x-text-input id="motherContact" class="block w-full mt-1" type="number" name="motherContact" required value="{{ $mother->motherContact }}"/>
                                <x-input-error :messages="$errors->get('motherContact')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="motherJob" :value="__('Occupation')" />
                                <x-text-input id="motherJob" class="block w-full mt-1" type="text" name="motherJob" required value="{{ $mother->motherJob }}"/>
                                <x-input-error :messages="$errors->get('motherJob')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="motherIncome" :value="__('Income')" />
                                <x-text-input id="motherIncome" class="block w-full mt-1" type="number" name="motherIncome" required value="{{ $mother->motherIncome }}"/>
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
                                <x-text-input id="guardianLast" class="block w-full mt-1" type="text" name="guardianLast" value="{{ $guardian != null ? $guardian->guardianLast : '' }}"/>
                                <x-input-error :messages="$errors->get('guardianLast')" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="guardianFirst" :value="__('First Name')" />
                                <x-text-input id="guardianFirst" class="block w-full mt-1" type="text" name="guardianFirst" value="{{ $guardian != null ? $guardian->guardianFirst : '' }}"/>
                                <x-input-error :messages="$errors->get('guardianFirst')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="guardianMiddle" :value="__('Middle Name')" />
                                <x-text-input id="guardianMiddle" class="block w-full mt-1" type="text" name="guardianMiddle" value="{{ $guardian != null ? $guardian->guardianMiddle : '' }}"/>
                                <x-input-error :messages="$errors->get('guardianMiddle')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="guardianSuffix" :value="__('Suffix')" />
                                <div class="relative mt-1">
                                    <x-text-input id="guardianSuffix" class="block w-full mt-1" type="text" name="guardianSuffix" autofocus value="{{ $guardian != null ? $guardian->guardianSuffix : '' }}" readonly/>
                                    <button type="button" onclick="editGuardianSuffix()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-700 hover:text-blue-500">
                                        <span class="material-symbols-sharp">edit</span>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('guardianSuffix')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="guardianAddress" :value="__('Address')" />
                                <x-text-input id="guardianAddress" class="block w-full mt-1" type="text" name="guardianAddress" value="{{ $guardian != null ? $guardian->guardianAddress : '' }}"/>
                                <x-input-error :messages="$errors->get('guardianAddress')" class="mt-2" />

                                <div class="flex flex-row items-center w-full h-4 gap-1 py-3 mt-2">
                                    <input type="checkbox" id="sameGuardian" {{ $guardian != null ? checked : '' }}>
                                    <label for="sameGuardian">Same as Applicant's Address</label>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="guardianContact" :value="__('Contact Number')" />
                                <x-text-input id="guardianContact" class="block w-full mt-1" type="text" name="guardianContact" value="{{ $guardian != null ? $guardian->guardianContact : '' }}"/>
                                <x-input-error :messages="$errors->get('guardianContact')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="guardianJob" :value="__('Occupation')" />
                                <x-text-input id="guardianJob" class="block w-full mt-1" type="text" name="guardianJob" value="{{ $guardian != null ? $guardian->guardianJob : '' }}"/>
                                <x-input-error :messages="$errors->get('guardianJob')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="guardianIncome" :value="__('Income')" />
                                <x-text-input id="guardianIncome" class="block w-full mt-1" type="text" name="guardianIncome" value="{{ $guardian != null ? $guardian->guardianIncome : '' }}"/>
                                <x-input-error :messages="$errors->get('guardianMiddle')" class="mt-2" />
                            </div>
                        </div>

                        <span>
                            School Information
                        </span>
                        
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="lrn" :value="__('Learner\'s Reference No. (LRN)')" />
                                <x-text-input id="lrn" class="block w-full mt-1" type="number" name="lrn" required value="{{ $school->lrn }}"/>
                                <x-input-error :messages="$errors->get('lrn')" class="mt-2" />
                            </div>
                            <div class="relative w-1/3 search-bar">
                                <x-input-label for="school" :value="__('School/Senior High School Attended')" />
                                <x-text-input id="school" class="block w-full mt-1" type="text" name="school" required autocomplete="off" value="{{ $school->school }}"/>
                                
                                <div class="absolute hidden w-full h-auto bg-white border border-gray-300 rounded-md max-h-80 datalist">

                                </div>

                                <x-input-error :messages="$errors->get('school')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="schoolEmail" :value="__('School Email Address')" />
                                <x-text-input id="schoolEmail" class="block w-full mt-1" type="email" name="schoolEmail" required value="{{ $school->schoolEmail }}"/>
                                <x-input-error :messages="$errors->get('schoolEmail')" class="mt-2" />
                            </div>

                            <div class="w-1/6">
                                <x-input-label for="schoolType" :value="__('School Type')" />
                                <div class="relative mt-1">
                                    <x-text-input id="schoolType" class="block w-full mt-1" type="text" name="schoolType" autofocus value="{{ ucfirst($school->schoolType) }}" readonly/>
                                    <button onclick="editSchoolType()" type="button" onclick="" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-700 hover:text-blue-500">
                                        <span class="material-symbols-sharp">edit</span>
                                    </button>
                                    <x-input-error :messages="$errors->get('schoolType')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="schoolAdd" :value="__('School Address')" />
                                <x-text-input id="schoolAdd" class="block w-full mt-1" type="text" name="schoolAdd" required autofocus value="{{ $school->schoolAddress }}"/>
                                <x-input-error :messages="$errors->get('schoolAdd')" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="schoolReg" :value="__('School Region')" />
                                <x-text-input id="schoolReg" class="block w-full mt-1" type="text" name="schoolReg" required autofocus value="{{ $schoolReg }}"/>
                                <x-input-error :messages="$errors->get('schoolReg')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="schoolProv" :value="__('School Province')" />
                                <x-text-input id="schoolProv" class="block w-full mt-1" type="text" name="schoolProv" required autofocus value="{{ $schoolProv }}"/>
                                <x-input-error :messages="$errors->get('schoolProv')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="schoolMun" :value="__('School City/Municipality')" />
                                <x-text-input id="schoolMun" class="block w-full mt-1" type="text" name="schoolMun" required autofocus value="{{ $schoolCity }}"/>
                                <x-input-error :messages="$errors->get('schoolMun')" class="mt-2" />
                            </div>
                            
                            <div class="flex items-end justify-center w-1/3">
                                <button class="w-full px-6 py-2 text-white bg-gray-700 rounded-lg h-4/6 ms-4" type="button" onclick="editSchoolReg()">
                                    Update Region/Province/City
                                </button>
                            </div>
                            
                            <div class="w-1/3">
                                
                            </div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                <x-input-label for="strand" :value="__('Academic Strand')" />
                                <div class="relative mt-1">
                                    <x-text-input id="strand" class="block w-full mt-1" type="text" name="strand" autofocus value="{{ $strand }}" readonly/>
                                    <button type="button" onclick="editStrand()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-700 hover:text-blue-500">
                                        <span class="material-symbols-sharp">edit</span>
                                    </button>

                                    <x-input-error :messages="$errors->get('strand')" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="gwa" :value="__('Grade Weighted Average (GWA)')" />
                                <x-text-input id="gwa" class="block w-full mt-1" type="number" name="gwa" required value="{{ $school->gwa }}"/>
                                <x-input-error :messages="$errors->get('gwa')" class="mt-2" />
                            </div>

                            <div class="w-1/3">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-end mt-4">
                                <button class="px-6 py-2 text-white bg-gray-700 rounded-lg ms-4" :disabled="!agreed">
                                    {{ __('Update Information') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="suffix1" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 bg-white shadow-lg w-70v h-96">
                <button onclick="editAppSuffix()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                <x-input-label for="suffixDrop" :value="__('Suffix')" />
                <div>
                    <select name="suffixDrop" id="suffixDrop" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                        <option value="None">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II" {{ old('suffix', '') == 'II' ? 'selected' : '' }}>II</option>
                        <option value="III" {{ old('suffix', '') == 'III' ? 'selected' : '' }}>III</option>
                        <option value="IV" {{ old('suffix', '') == 'IV' ? 'selected' : '' }}>IV</option>
                        <option value="V" {{ old('suffix', '') == 'V' ? 'selected' : '' }}>V</option>
                    </select>
                </div>

                <div class="flex justify-end w-full">
                    <button id="suffixBtn" class="px-6 py-2 mt-4 text-white bg-gray-700 rounded-lg ms-4" type="button">
                        Update Suffix
                    </button>
                </div>
            </div>
        </div>

        <div id="genderEdit" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 bg-white shadow-lg w-70v h-96">
                <button onclick="editGender()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                <x-input-label for="genderDrop" :value="__('Sex At Birth')" />
                <div>
                    <select name="genderDrop" id="genderDrop" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="flex justify-end w-full">
                    <button id="genderBtn" class="px-6 py-2 mt-4 text-white bg-gray-700 rounded-lg ms-4" type="button">
                        Update Gender
                    </button>
                </div>
            </div>
        </div>

        <div id="regionEdit" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 bg-white shadow-lg w-70v h-80v">
                <button onclick="editRegion()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                <x-input-label for="regionDrop" :value="__('Region')" />
                <div>
                    <select name="regionDrop" id="regionDrop" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->region_code }}">{{ $region->region_name }}</option>
                        @endforeach
                    </select>
                </div>

                <x-input-label for="provinceDrop" :value="__('Province')" class="mt-4"/>
                <div>
                    <select name="provinceDrop" id="provinceDrop" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                    </select>
                </div>

                <x-input-label for="cityDrop" :value="__('City/Municipality')" class="mt-4"/>
                <div>
                    <select name="cityDrop" id="cityDrop" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                    </select>
                </div>

                <x-input-label for="barangayDrop" :value="__('Barangay')" class="mt-4"/>
                <div>
                    <select name="barangayDrop" id="barangayDrop" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                    </select>
                </div>

                <div class="flex justify-end w-full">
                    <button id="regionBtn" class="px-6 py-2 mt-4 text-white bg-gray-700 rounded-lg ms-4" type="button">
                        Update Region/Province/City/Barangay
                    </button>
                </div>
            </div>
        </div>
        
        <div id="fatherSuffixEdit" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 bg-white shadow-lg w-70v h-96">
                <button onclick="editFatherSuffix()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                <x-input-label for="fatherSufEdit" :value="__('Suffix')" />
                <div>
                    <select name="fatherSufEdit" id="fatherSufEdit" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                        <option value="None">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                    </select>
                </div>
                
                <div class="flex justify-end w-full">
                    <button id="fatherSuffixBtn" class="px-6 py-2 mt-4 text-white bg-gray-700 rounded-lg ms-4" type="button">
                        Update Suffix
                    </button>
                </div>
            </div>
        </div>

        <div id="motherSuffixEdit" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 bg-white shadow-lg w-70v h-96">
                <button onclick="editMotherSuffix()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                <x-input-label for="motherSufEdit" :value="__('Suffix')" />
                <div>
                    <select name="motherSufEdit" id="motherSufEdit" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                        <option value="None">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                    </select>
                </div>
                
                <div class="flex justify-end w-full">
                    <button id="motherSuffixBtn" class="px-6 py-2 mt-4 text-white bg-gray-700 rounded-lg ms-4" type="button">
                        Update Suffix
                    </button>
                </div>
            </div>
        </div>

        <div id="guadianSuffixEdit" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 bg-white shadow-lg w-70v h-96">
                <button onclick="editGuardianSuffix()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                <x-input-label for="guardianSufEdit" :value="__('Suffix')" />
                <div>
                    <select name="guardianSufEdit" id="guardianSufEdit" class="block w-full mt-1">
                        <option value="" disabled selected>Please select</option>
                        <option value="None">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                    </select>
                </div>
                
                <div class="flex justify-end w-full">
                    <button id="guardianSuffixBtn" class="px-6 py-2 mt-4 text-white bg-gray-700 rounded-lg ms-4" type="button">
                        Update Suffix
                    </button>
                </div>
            </div>
        </div>

        <div id="schoolTypeEdit" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 bg-white shadow-lg w-70v h-96">
                <button onclick="editSchoolType()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                <x-input-label for="schoolTyEdit" :value="__('School Type')" />
                <div>
                    <select name="schoolTyEdit" id="schoolTyEdit" required class="block w-full mt-1" required>
                        <option value="" selected disabled>Select Type</option>
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                <div class="flex justify-end w-full">
                    <button id="schoolTypeBtn" class="px-6 py-2 mt-4 text-white bg-gray-700 rounded-lg ms-4" type="button">
                        Update School Type
                    </button>
                </div>
            </div>
        </div>

        <div id="schoolRegEdit" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 bg-white shadow-lg w-70v h-96">
                <button onclick="editSchoolReg()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                <x-input-label for="schoolRegDrop" :value="__('School Region')" />
                <div>
                    <select name="schoolRegDrop" id="schoolRegDrop" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->region_code }}" {{ old('region') == $region->region_code ? 'selected' : '' }}>{{ $region->region_name }}</option>
                        @endforeach
                    </select>
                </div>

                <x-input-label for="schoolProvDrop" :value="__('School Province')" class="mt-4" />
                <div>
                    <select name="schoolProvDrop" id="schoolProvDrop" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                    </select>
                </div>

                <x-input-label for="schoolMunDrop" :value="__('School City/Municipality')" class="mt-4" />
                <div>
                    <select name="schoolMunDrop" id="schoolMunDrop" class="block w-full mt-1" required>
                        <option value="" disabled selected>Please select</option>
                    </select>
                </div>

                <div class="flex justify-end w-full">
                    <button id="schoolRegBtn"  class="px-6 py-2 mt-4 text-white bg-gray-700 rounded-lg ms-4" type="button">
                        Update School Region/Province/City
                    </button>
                </div>
            </div>
        </div>

        <div id="strandEdit" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="p-8 bg-white shadow-lg w-70v h-96">
                <button onclick="editStrand()" class="flex items-center gap-4 mb-6">
                    <span class="material-symbols-sharp">
                        arrow_back
                    </span>
                    <h2>Back</h2>
                </button>

                 <x-input-label for="strndEdit" :value="__('Academic Strand')" />
                <div>
                    <select name="strndEdit" id="strndEdit" required class="block w-full mt-1" required>
                        <option value="" disabled selected>Select Strand</option>
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

                <div class="flex justify-end w-full">
                    <button id="strandBtn" class="px-6 py-2 mt-4 text-white bg-gray-700 rounded-lg ms-4" type="button">
                        Update School Type
                    </button>
                </div>
            </div>
        </div>

        <script>
            function editAppSuffix() {
                var form = document.getElementById('suffix1');
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

            function editGender() {
                var form = document.getElementById('genderEdit');
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

            function editRegion() {
                var form = document.getElementById('regionEdit');
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

            function editFatherSuffix() {
                var form = document.getElementById('fatherSuffixEdit');
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

            function editMotherSuffix() {
                var form = document.getElementById('motherSuffixEdit');
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

            function editGuardianSuffix() {
                var form = document.getElementById('guadianSuffixEdit');
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

            function editSchoolType() {
                var form = document.getElementById('schoolTypeEdit');
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

            function editSchoolReg() {
                var form = document.getElementById('schoolRegEdit');
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

            function editStrand() {
                var form = document.getElementById('strandEdit');
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
                $('#address').on('change', function() {
                    $('#sameFather').prop('checked', false).trigger('change');
                    $('#sameMother').prop('checked', false).trigger('change');
                });

                $('#suffixBtn').on('click', function() {
                    var suffix = $('#suffixDrop option:selected').text();
                    $('#suffix').val(suffix);
                    editAppSuffix();
                });

                $('#genderBtn').on('click', function() {
                    var gender = $('#genderDrop option:selected').text();
                    $('#gender').val(gender);
                    editGender();
                });

                $('#regionBtn').on('click', function() {
                    var region = $('#regionDrop option:selected').text();
                    var province = $('#provinceDrop option:selected').text();
                    var city = $('#cityDrop option:selected').text();
                    var barangay = $('#barangayDrop option:selected').text();
                    $('#region').val(region);
                    $('#province').val(province);
                    $('#city').val(city);
                    $('#barangay').val(barangay);
                    editRegion();
                });

                $('#fatherSuffixBtn').on('click', function() {
                    var suffix = $('#fatherSufEdit option:selected').text();
                    $('#fatherSuffix').val(suffix);
                    editFatherSuffix();
                });

                $('#motherSuffixBtn').on('click', function() {
                    var suffix = $('#motherSufEdit option:selected').text();
                    $('#motherSuffix').val(suffix);
                    editMotherSuffix();
                });

                $('#guardianSuffixBtn').on('click', function() {
                    var suffix = $('#guardianSufEdit option:selected').text();
                    $('#guardianSuffix').val(suffix);
                    editGuardianSuffix();
                });

                $('#schoolTypeBtn').on('click', function() {
                    var schoolType = $('#schoolTyEdit option:selected').text();
                    $('#schoolType').val(schoolType);
                    editSchoolType();
                });

                $('#schoolRegBtn').on('click', function() {
                    var region = $('#schoolRegDrop option:selected').text();
                    var province = $('#schoolProvDrop option:selected').text();
                    var city = $('#schoolMunDrop option:selected').text();
                    $('#schoolReg').val(region);
                    $('#schoolProv').val(province);
                    $('#schoolMun').val(city);
                    editSchoolReg();
                });

                $('#strandBtn').on('click', function() {
                    var strand = $('#strndEdit option:selected').text();
                    $('#strand').val(strand);
                    editStrand();
                });
                
                $('#regionDrop').on('change', function() {
                    var regionCode = $(this).val();

                    $.ajax({
                        url: '/get-provinces/' + regionCode,
                        type: 'GET',
                        success: function(data) {
                            $('#provinceDrop').html(data);
                            $('#cityDrop').html('<option value="" disabled selected="true">Please select</option>');
                            $('#barangayDrop').html('<option value="" disabled selected="true">Please select</option>');
                            var oldProvince = "{{ old('province') }}";
                            if (oldProvince) {
                                $('#provinceDrop').val(oldProvince).trigger('change');
                            }
                        }
                    });
                }).trigger('change');

                $('#provinceDrop').on('change', function() {
                    var provinceCode = $(this).val();

                    $.ajax({
                        url: '/get-cities/' + provinceCode,
                        type: 'GET',
                        success: function(data) {
                            $('#cityDrop').html(data);
                            $('#barangayDrop').html('<option value="" disabled selected="true">Please select</option>');
                            var oldCity = "{{ old('city') }}";
                            if (oldCity) {
                                $('#cityDrop').val(oldCity).trigger('change');
                            }
                        }
                    });
                });

                $('#cityDrop').on('change', function() {
                    var cityCode = $(this).val();

                    $.ajax({
                        url: '/get-barangays/' + cityCode,
                        type: 'GET',
                        success: function(data) {
                            $('#barangayDrop').html(data);
                            var oldBarangay = "{{ old('barangay') }}";
                            if (oldBarangay) {
                                $('#barangayDrop').val(oldBarangay);
                            }
                        }
                    });
                });

                $('#sameFather').on('change', function() {
                    if ($(this).is(':checked')) {
                        var address = $('#address').val();
                        var region = $('#region').val();
                        var province = $('#province').val();
                        var city = $('#city').val();
                        var barangay = $('#barangay').val();

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
                        var region = $('#region').val();
                        var province = $('#province').val();
                        var city = $('#city').val();
                        var barangay = $('#barangay').val();

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
                        var region = $('#region').val();
                        var province = $('#province').val();
                        var city = $('#city').val();
                        var barangay = $('#barangay').val();

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

                $('#schoolRegDrop').on('change', function() {
                    var regionCode = $(this).val();
                    $.ajax({
                        url: '/get-provinces/' + regionCode,
                        type: 'GET',
                        success: function(data) {
                            $('#schoolProvDrop').html(data);
                            $('#schoolMunDrop').html('<option value="" disabled selected="true">Please select</option>');
                            var oldProvince = "{{ old('schoolProv') }}";
                            if (oldProvince) {
                                $('#schoolProvDrop').val(oldProvince).trigger('change');
                            }
                            
                        }
                    });
                }).trigger('change');

                $('#schoolProvDrop').on('change', function() {
                    var provinceCode = $(this).val();

                    $.ajax({
                        url: '/get-cities/' + provinceCode,
                        type: 'GET',
                        success: function(data) {
                            $('#schoolMunDrop').html(data);

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