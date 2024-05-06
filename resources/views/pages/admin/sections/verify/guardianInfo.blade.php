<div class="my-2 border-b-2 border-yellow-600">
    <h2 class="text-xl font-bold">Guardian Information</h2>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Name:</h3>
    <h3>{{$guardianInformation->guardianLast}}, {{$guardianInformation->guardianFirst}} {{$guardianInformation->guardianMiddle}} @if ($guardianInformation->guardianSuffix != "None") {{$guardianInformation->guardianSuffix}} @endif</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Address:</h3>
    <h3>{{$guardianInformation->guardianAddress}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Contact Number:</h3>
    <h3>{{$guardianInformation->guardianContact}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Job:</h3>
    <h3>{{$guardianInformation->guardianJob}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Income:</h3>
    <h3>{{$guardianInformation->guardianIncome}}</h3>
</div>