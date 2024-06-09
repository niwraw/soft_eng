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
                        Email
                    </th>

                    <th scope="col">
                        Contact No.
                    </th>

                    <th scope="col">
                        Application Type
                    </th>

                    <th scope="col">
                        Status
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
                        {{ $applicant->email }}
                    </td>

                    <td>
                        {{ $applicant->contactNum }}
                    </td>

                    <td>
                        {{ $applicant->applicationType }}
                    </td>

                    <td>
                        {{ ucfirst($applicant->status) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
