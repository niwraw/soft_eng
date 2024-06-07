<div class="pt-8 pl-6 pr-20">
    <section class="container px-4 mx-auto">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-x-3">
                    <h2 class="text-lg font-medium text-gray-800">Assign Exam Schedule</h2>
                </div>
                
                <div class="flex gap-6">
                    <p class="text-sm text-gray-500">Applicant with Schedule: <span class="px-3 py-1 text-xs bg-green-100 rounded-full">{{ $withExam }}</span></p>
                    <p class="text-sm text-gray-500">Applicant without Schedule: <span class="px-3 py-1 text-xs bg-red-100 rounded-full">{{ $withoutExam }}</span></p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.set.exam', ['currentRoute' => $currentRoute]) }}" method="POST" class="flex flex-col mt-6 gap-7" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-row gap-3">
                <div class="w-1/3">
                    <x-input-label for="buildingExam" :value="__('Building')" />
                    <div>
                        <select name="buildingExam" id="buildingExam" class="block w-full mt-1" required>
                            <option value="" disabled selected>Please select</option>
                            <option value="GV">Gusaling Villegas</option>
                            <option value="GL">Gusaling Lacson</option>
                            <option value="GC">Gusaling Corazon</option>
                            <option value="GA">Gusaling Atienza</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('buildingExam')" class="mt-2" />
                </div>

                <div class="w-1/3">
                    <x-input-label for="roomExam" :value="__('Room Number')" />
                    <div>
                        <select name="roomExam" id="roomExam" class="block w-full mt-1" required>
                            <option value="" disabled selected>Please select</option>
                            <option value="101">101</option>
                            <option value="102">102</option>
                            <option value="103">103</option>
                            <option value="104">104</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('roomExam')" class="mt-2" />
                </div>

                <div class="w-1/3">
                    <x-input-label for="dateExam" :value="__('Date')" />
                    <x-text-input id="dateExam" class="block w-full mt-1" type="date" name="dateExam" autofocus/>
                </div>
            </div>

            <div class="flex flex-row gap-3">
                <div class="w-1/3">
                    <x-input-label for="timeExam" :value="__('Time')" />
                    <div>
                        <select name="timeExam" id="timeExam" class="block w-full mt-1" required>
                            <option value="" disabled selected>Please select</option>
                            <option value="8:00 AM - 11:00 AM">8:00 AM - 11:00 AM</option>
                            <option value="1:00 PM - 5:00 PM">1:00 PM - 5:00 PM</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('timeExam')" class="mt-2" />
                </div>

                <div class="w-1/3">
                    <x-input-label for="capacity" :value="__('Capacity')" />
                    <x-text-input id="capacity" class="block w-full mt-1" type="text" name="capacity" required autofocus value="{{ old('firstName') }}"/>
                    <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                </div>

                <div class="w-1/3">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Assign Unallocated Applicants</button>
            </div>
        </form>
    </section>
</div>

@if(session('addExam'))
    <script>
        alert('{{ session('addExam') }}');
    </script>
@endif