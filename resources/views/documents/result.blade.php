<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th scope="col">
                        Applicant No.
                    </th>

                    <th scope="col">
                        Name
                    </th>

                    <th scope="col">
                        Rank
                    </th>

                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                        Score
                    </th>

                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                        Course
                    </th>

                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                        Remarks
                    </th>
                    
                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 ">
                        Confirmed Slot
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($applicants as $applicant)
                <tr>
                    <td>
                        {{ $applicant->applicant_id }}
                    </td>
                    
                    <td>
                        {{ $applicant->lastName }}, {{ $applicant->firstName }} {{ $applicant->middleName }} @if ($applicant->suffix != 'None') {{ $applicant->suffix }} @endif
                    </td>

                    <td>
                        {{ $applicant->rank }}
                    </td>

                    <td>
                        {{ $applicant->score }}
                    </td>

                    <td>
                        @if($applicant->remark == 'with')
                            {{ $applicant->courseOffer }}
                        @endif
                    </td>

                    <td>
                        @if($applicant->remark == 'with')
                            Passed with Course
                        @elseif($applicant->remark == 'without')
                            Waitlisted
                        @else
                            Failed
                        @endif
                    </td>
                    
                    <td>
                        @if($applicant->remark != 'failed')
                            {{ ucfirst($applicant->confirmed) }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
