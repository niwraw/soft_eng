<div class="w-auto pt-8 pl-6 pr-20">
    <div class="mb-4 text-xl font-semibold text-indigo-700">
        <h1>ANNOUNCEMENTS</h1>
    </div>

    <div class="grid h-70v" style="grid-template-columns: 1fr 2fr;">
        <div class="pr-2 border-r-2 border-gray-600">
            <h2 class="mb-4 text-lg font-medium text-indigo-700">Edit Important Dates</h2>

            <form method="POST" action="">
                @csrf

                <div class="flex items-center gap-4 mb-6">
                    <h3>Start of Application:</h3>
                    <span>January 13, 2003</span>
                </div>

                <div class="mb-10">
                    <x-input-label for="startDate" :value="__('Edit Start Date')" />
                    <x-text-input id="startDate" class="block w-full mt-1" type="date" name="startDate" required autofocus value=""/>
                    <x-input-error :messages="$errors->get('startDate')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <h3>End of Application:</h3>
                    <span>January 13, 2003</span>
                </div>

                <div class="mb-10">
                    <x-input-label for="endDate" :value="__('Edit End Date')" />
                    <x-text-input id="endDate" class="block w-full mt-1" type="date" name="endDate" required autofocus value=""/>
                    <x-input-error :messages="$errors->get('endDate')" class="mt-2" />
                </div>

                <div class="flex justify-end w-full ">
                    <button type="submit" class="px-4 py-1 text-white bg-gray-700 rounded-lg">
                        Update Dates
                    </button>
                </div>
            </form>
        </div>

        <div class="pl-2">
            <h2 class="mb-4 text-lg font-medium text-indigo-700">Add/Edit Advisories</h2>
        </div>
    </div>
</div>