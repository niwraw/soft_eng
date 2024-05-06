<div class="my-2 border-b-2 border-yellow-600">
    <h2 class="text-xl font-bold">Other Information</h2>
</div>

@if($otherInformation->maidenName != null)
<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Maiden Name:</h3>
    <h3>{{$otherInformation->maidenName}}</h3>
</div>
@endif

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Birth Date:</h3>
    <h3>{{$otherInformation->birthDate}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Birth Place:</h3>
    <h3>{{$otherInformation->birthPlace}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Address:</h3>
    <h3>{{$otherInformation->address}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Region:</h3>
    <h3>{{$otherInformation->region}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Province:</h3>
    <h3>{{$otherInformation->province}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">City:</h3>
    <h3>{{$otherInformation->city}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Barangay:</h3>
    <h3>{{$otherInformation->barangay}}</h3>
</div>