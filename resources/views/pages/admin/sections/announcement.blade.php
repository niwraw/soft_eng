<div class="w-auto pt-8 pl-6 pr-20">
    <div class="mb-4 text-xl font-semibold text-indigo-700">
        <h1>ANNOUNCEMENTS</h1>
    </div>

    <div class="grid h-70v" style="grid-template-columns: 1fr 2fr;">
        <div class="pr-4 border-r-2 border-gray-600">
            <h2 class="mb-4 text-lg font-medium text-indigo-700">Edit Important Dates</h2>

            <form method="POST" action="{{ route('admin.change', ['currentRoute'=>$currentRoute]) }}">
                @csrf

                <div class="flex items-center gap-4 mb-6">
                    <h3>Start of Application:</h3>
                    <span>{{ $startDate->date }}</span>
                </div>

                <div class="mb-10">
                    <x-input-label for="startDate" :value="__('Edit Start Date')" />
                    <x-text-input id="startDate" class="block w-full mt-1" type="date" name="startDate" required autofocus value=""/>
                    <x-input-error :messages="$errors->get('startDate')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <h3>End of Application:</h3>
                    <span>{{ $endDate->date }}</span>
                </div>

                <div class="mb-10">
                    <x-input-label for="endDate" :value="__('Edit End Date')" />
                    <x-text-input id="endDate" class="block w-full mt-1" type="date" name="endDate" required autofocus value=""/>
                    <x-input-error :messages="$errors->get('endDate')" class="mt-2" />
                </div>

                <div class="flex justify-end w-full ">
                    <button type="submit" class="px-4 py-1 text-white bg-gray-700 rounded-lg" onclick="return confirmChange()">
                        Update Dates
                    </button>
                </div>
            </form>
        </div>

        <div class="pl-4">
            <h2 class="mb-4 text-lg font-medium text-indigo-700">Add/Edit Advisories</h2>

            <div class="flex flex-col mt-6">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 ">
                                    <tr>
                                        <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                            ID.
                                        </th>

                                        <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                            Date
                                        </th>

                                        <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                            Announcement
                                        </th>
                                        
                                        <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200 ">
                                    @foreach($announcements as $announcement)
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                            {{ $announcement->id }}
                                        </td>
                                        
                                        <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                            {{ $announcement->date }}
                                        </td>
                                        
                                        <td class="px-4 py-4 text-sm break-words whitespace-normal">
                                            {{ $announcement->announcement }}
                                        </td>

                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <a href="{{ route('admin.edit.announcement', ['currentRoute' => $currentRoute, 'announcementId' => $announcement->id]) }}" class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-100 hover:rounded-full">
                                                <div class="inline px-3 py-1 text-sm font-normal text-gray-700 rounded-full gap-x-2 bg-gray-200/60">
                                                    Edit
                                                </div>
                                            </a>

                                            <a href="{{ route('admin.delete.announcement', ['currentRoute' => $currentRoute, 'announcementId' => $announcement->id]) }}" class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-100 hover:rounded-full" onclick="return announceDelete()">
                                                <div class="inline px-3 py-1 text-sm font-normal text-gray-700 bg-red-400 rounded-full gap-x-2">
                                                    Delete
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 mb-4">
                {{ $announcements->links() }}
            </div>

            <div class="w-full h-8 mb-4">
                <form method="POST" action="{{ route('admin.add.announcement', ['currentRoute'=> $currentRoute]) }}">
                    @csrf
                    <h1 class="mb-4 text-lg font-medium text-indigo-700">Add New Advisory</h1>

                    <div class="mb-10">
                        <x-input-label for="advisory" :value="__('Add New Advisory (Note: The date will be current when posting new advisory)')" />
                        <x-text-input id="advisory" class="w-full" type="text" name="advisory" value="" required autofocus/>
                        <x-input-error :messages="$errors->get('advisory')" class="mt-2" />
                    </div>

                    <div class="flex justify-end w-full">
                        <button type="submit" onclick="confirmAdd()" class="px-4 py-1 text-white bg-gray-700 rounded-lg">
                            Add Advisory
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    function confirmChange() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        return confirm('Are you sure you want to change the dates?\n\nStart Date: ' + formatDate(startDate) + '\nEnd Date: ' + formatDate(endDate));
    }

    function confirmAdd() {
        return confirm('Are you sure you want to add this advisory?');
    }

    function announceDelete() {
        return confirm('Are you sure you want to delete this announcement?');
    }
</script>

@if(session('changed'))
    <script>
        alert('{{ session('changed') }}');
    </script>
@endif