<div class="my-2 border-b-2 border-yellow-600">
    <h2 class="text-xl font-bold">Mother Information</h2>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Name:</h3>
    <h3>{{$motherInformation->motherLast}}, {{$motherInformation->motherFirst}} {{$motherInformation->motherMiddle}} @if ($motherInformation->motherSuffix != "None") {{$motherInformation->motherSuffix}} @endif</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Address:</h3>
    <h3>{{$motherInformation->motherAddress}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Contact Number:</h3>
    <h3>{{$motherInformation->motherContact}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Job:</h3>
    <h3>{{$motherInformation->motherJob}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Income:</h3>
    <h3>{{$motherInformation->motherIncome}}</h3>
</div>