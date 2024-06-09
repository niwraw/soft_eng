<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        @if($select == 'first')
        <table>
            <thead>
                <tr>
                    <th colspan="2">Application Progress</th>
                </tr>  
            </thead>
            <tbody>
                <tr>
                    <td>Approved Applicants</td>
                    <td>{{ $approved }}</td>
                </tr>
                <tr>
                    <td>Pending Applicants</td>
                    <td>{{ $pending }}</td>
                </tr>
                <tr>
                    <td>Resubmission Applicants</td>
                    <td>{{ $resubmission }}</td>
                </tr>
            </tbody>
        </table>

        <div>
        </div>
        <div>
        </div>

        <table>
            <thead>
                <tr>
                    <th colspan="2">Sex at Birth</th>
                </tr>  
            </thead>
            <tbody>
                <tr>
                    <td>Male</td>
                    <td>{{ $male }}</td>
                </tr>

                <tr>
                    <td>Female</td>
                    <td>{{ $female }}</td>
                </tr>
            </tbody>
        </table>

        <div>
        </div>
        <div>
        </div>

        <table>
            <thead>
                <tr>
                    <th colspan="2">Applicant Type</th>
                </tr>  
            </thead>
            <tbody>
                <tr>
                    <td>SHS</td>
                    <td>{{ $shsApplicants }}</td>
                </tr>

                <tr>
                    <td>ALS</td>
                    <td>{{ $alsApplicants }}</td>
                </tr>

                <tr>
                    <td>OLD</td>
                    <td>{{ $oldApplicants }}</td>
                </tr>

                <tr>
                    <td>TRANSFEREE</td>
                    <td>{{ $transferApplicants }}</td>
                </tr>
            </tbody>
        </table>

        @elseif($select == 'second')
        <table>
            <thead>
                <tr>
                    <th colspan="2">Applicant per Region</th>
                </tr>  
            </thead>
            <tbody>
                <tr>
                    <td>Region I</td>
                    <td>{{ $regions['I'] }}</td>
                </tr>

                <tr>
                    <td>Region II</td>
                    <td>{{ $regions['II'] }}</td>
                </tr>

                <tr>
                    <td>Region III</td>
                    <td>{{ $regions['III'] }}</td>
                </tr>

                <tr>
                    <td>Region IV</td>
                    <td>{{ $regions['IV-A'] }}</td>
                </tr>

                <tr>
                    <td>MIMAROPA</td>
                    <td>{{ $regions['MIMAROPA'] }}</td>
                </tr>

                <tr>
                    <td>Region V</td>
                    <td>{{ $regions['V'] }}</td>
                </tr>

                <tr>
                    <td>Region VI</td>
                    <td>{{ $regions['VI'] }}</td>
                </tr>

                <tr>
                    <td>Region VII</td>
                    <td>{{ $regions['VII'] }}</td>
                </tr>

                <tr>
                    <td>Region VIII</td>
                    <td>{{ $regions['VIII'] }}</td>
                </tr>

                <tr>
                    <td>Region IX</td>
                    <td>{{ $regions['IX'] }}</td>
                </tr>

                <tr>
                    <td>Region X</td>
                    <td>{{ $regions['X'] }}</td>
                </tr>

                <tr>
                    <td>Region XI</td>
                    <td>{{ $regions['XI'] }}</td>
                </tr>

                <tr>
                    <td>Region XII</td>
                    <td>{{ $regions['XII'] }}</td>
                </tr>

                <tr>
                    <td>Region XIII</td>
                    <td>{{ $regions['XIII'] }}</td>
                </tr>

                <tr>
                    <td>ARMM</td>
                    <td>{{ $regions['ARMM'] }}</td>
                </tr>

                <tr>
                    <td>CAR</td>
                    <td>{{ $regions['CAR'] }}</td>
                </tr>

                <tr>
                    <td>NCR</td>
                    <td>{{ $regions['NCR'] }}</td>
                </tr>
            </tbody>
        </table>

        <div>
        </div>
        <div>
        </div>

        <table>
            <thead>
                <tr>
                    <th colspan="2">Manila to Non-Manila Count</th>
                </tr>  
            </thead>
            <tbody>
                <tr>
                    <td>Manila Applicants</td>
                    <td>{{ $manilaRatio['manila'] }}</td>
                </tr>

                <tr>
                    <td>Non-Manila Applicant</td>
                    <td>{{ $manilaRatio['nonManila'] }}</td>
                </tr>
            </tbody>
        </table>
        @elseif($select == 'third')
        <table>
            <thead>
                <tr>
                    <th colspan="2">Strand Count</th>
                </tr>  
            </thead>
            <tbody>
                <tr>
                    <td>STEM</td>
                    <td>{{ $strands['STEM'] }}</td>
                </tr>

                <tr>
                    <td>ABM</td>
                    <td>{{ $strands['ABM'] }}</td>
                </tr>

                <tr>
                    <td>HUMSS</td>
                    <td>{{ $strands['HUMSS'] }}</td>
                </tr>

                <tr>
                    <td>GAS</td>
                    <td>{{ $strands['GAS'] }}</td>
                </tr>

                <tr>
                    <td>TVL</td>
                    <td>{{ $strands['TVL'] }}</td>
                </tr>

                <tr>
                    <td>SPORTS</td>
                    <td>{{ $strands['SPORTS'] }}</td>
                </tr>

                <tr>
                    <td>ADT</td>
                    <td>{{ $strands['ADT'] }}</td>
                </tr>

                <tr>
                    <td>PBM</td>
                    <td>{{ $strands['PBM'] }}</td>
                </tr>
            </tbody>
        </table>

        <div>
        </div>
        <div>
        </div>

        <table>
            <thead>
                <tr>
                    <th colspan="2">Public and Private Count</th>
                </tr>  
            </thead>
            <tbody>
                <tr>
                    <td>Public</td>
                    <td>{{ $publicCount }}</td>
                </tr>

                <tr>
                    <td>Private</td>
                    <td>{{ $privateCount }}</td>
                </tr>
            </tbody>
        </table>
        @endif
    </body>
</html>
