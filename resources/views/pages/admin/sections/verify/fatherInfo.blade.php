<div class="my-2 border-b-2 border-yellow-600">
    <h2 class="text-xl font-bold">Father Information</h2>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Name:</h3>
    <h3>{{$fatherInformation->fatherLast}}, {{$fatherInformation->fatherFirst}} {{$fatherInformation->fatherMiddle}} @if ($fatherInformation->fatherSuffix != "None") {{$fatherInformation->fatherSuffix}} @endif</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Address:</h3>
    <h3>{{$fatherInformation->fatherAddress}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Contact Number:</h3>
    <h3>{{$fatherInformation->fatherContact}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Job:</h3>
    <h3>{{$fatherInformation->fatherJob}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Income:</h3>
    <h3>{{$fatherInformation->fatherIncome}}</h3>
</div>