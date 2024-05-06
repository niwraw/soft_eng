<div class="pt-8 pl-6 pr-20">
    <section class="container px-4 mx-auto">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-x-3">
                    <h2 class="text-lg font-medium text-gray-800">Applicants</h2>

                    <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full">Total: {{ array_sum($count) }}</span>
                </div>
                
                <p class="mt-1 text-sm text-gray-500">These are the total applicants that has applied for this academic year.</p>
            </div>
        </div>

        <div class="gap-16 mt-6 md:flex md:items-center">
            <div class="w-1/3">
                Application Type Filter
            </div>

            <div class="w-1/3 pl-6">
                Status Filter
            </div>
        </div>

        <div class="mt-6 md:flex md:items-center md:justify-between">
            <div class="inline-flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse ">
                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm {{$type == 'all' ? 'bg-gray-100' : 'hover:bg-gray-100'}}" onclick="window.location.href='{{ url()->current() }}?type=all&statusType={{ $statusType }}'">
                    View all
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm {{$type == 'SHS' ? 'bg-gray-100' : 'hover:bg-gray-100'}}" onclick="window.location.href='{{ url()->current() }}?type=SHS&statusType={{ $statusType }}'">
                    SHS
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm {{$type == 'ALS' ? 'bg-gray-100' : 'hover:bg-gray-100'}}" onclick="window.location.href='{{ url()->current() }}?type=ALS&statusType={{ $statusType }}'">
                    ALS
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm {{$type == 'OLD' ? 'bg-gray-100' : 'hover:bg-gray-100'}}" onclick="window.location.href='{{ url()->current() }}?type=OLD&statusType={{ $statusType }}'">
                    OLD
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm {{$type == 'TRANSFER' ? 'bg-gray-100' : 'hover:bg-gray-100'}}" onclick="window.location.href='{{ url()->current() }}?type=TRANSFER&statusType={{ $statusType }}'">
                    TRANSFEREE
                </button>
            </div>

            <div class="inline-flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse">
                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm {{$statusType == 'all' ? 'bg-gray-100' : 'hover:bg-gray-100'}}" onclick="window.location.href='{{ url()->current() }}?type={{ $type }}&statusType=all'">
                    View all
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm {{$statusType == 'approved' ? 'bg-gray-100' : 'hover:bg-gray-100'}}" onclick="window.location.href='{{ url()->current() }}?type={{ $type }}&statusType=approved'">
                    Approved
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm {{$statusType == 'pending' ? 'bg-gray-100' : 'hover:bg-gray-100'}}" onclick="window.location.href='{{ url()->current() }}?type={{ $type }}&statusType=pending'">
                    Pending
                </button>

                <button class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm {{$statusType == 'resubmission' ? 'bg-gray-100' : 'hover:bg-gray-100'}}" onclick="window.location.href='{{ url()->current() }}?type={{ $type }}&statusType=resubmission'">
                    Resubmission
                </button>
            </div>

            <form action="{{ url()->current() }}" method="GET" class="relative flex items-center mt-4 md:mt-0">
                <span class="absolute">
                    <button type="submit" class="mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 ">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </span>

                <input type="text" placeholder="Search" name="searchApplicant" class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 focus:border-blue-400  focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="statusType" value="{{ $statusType }}">
                
            </form>
        </div>

        <div class="flex flex-col mt-6">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 ">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                        Applicant No.
                                    </th>

                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                        Name
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                        Email
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                        Contact No.
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                        Application Type
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                        Status
                                    </th>
                                    
                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 ">
                                @foreach ($applicants as $applicant)
                                <tr>
                                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                        {{ $applicant->applicant_id }}
                                    </td>
                                    
                                    <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                        {{ $applicant->lastName }}, {{ $applicant->firstName }} {{ $applicant->middleName }} @if ($applicant->suffix != 'None') {{ $applicant->suffix }} @endif
                                    </td>
                                    
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        {{ $applicant->email }}
                                    </td>

                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        {{ $applicant->contactNum }}
                                    </td>

                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        {{ $applicant->applicationType }}
                                    </td>

                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        @if ($applicant->status == 'pending')
                                            <div class="inline px-3 py-1 text-sm font-normal text-yellow-700 rounded-full gap-x-2 bg-yellow-200/60">
                                        @elseif ($applicant->status == 'approved')
                                            <div class="inline px-3 py-1 text-sm font-normal text-green-700 rounded-full gap-x-2 bg-green-200/60">
                                        @elseif ($applicant->status == 'resubmission')
                                            <div class="inline px-3 py-1 text-sm font-normal text-red-700 rounded-full gap-x-2 bg-red-200/60">
                                        @endif
                                            {{ ucfirst($applicant->status) }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <a href="{{ route('admin.verify', ['currentRoute' => 'applicant', 'applicantId' => $applicant->applicant_id, 'applicationType' => $applicant->applicationType]) }}" class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-100 hover:rounded-full">
                                            <div class="inline px-3 py-1 text-sm font-normal text-gray-700 rounded-full gap-x-2 bg-gray-200/60">
                                                View
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

        <div class="mt-6">
            {{ $applicants->appends(['type' => $type, 'statusType' => $statusType, 'searchApplicant' => $searchApplicant])->links() }}
        </div>
    </section>
</div>