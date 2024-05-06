<div class="mb-2 border-b-2 border-yellow-600">
    <h2 class="text-xl font-bold">Personal Information</h2>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Name:</h3>
    <h3>{{$personalInformation->lastName}}, {{$personalInformation->firstName}} {{$personalInformation->middleName}} @if($personalInformation->suffix != "None") {{$personalInformation->suffix}} @endif</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Applicantion Type:</h3>
    <h3>{{$applicationType}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Email:</h3>
    <h3>{{$personalInformation->email}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Contact Number:</h3>
    <h3>{{$personalInformation->contactNum}}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Gender:</h3>
    <h3>{{ucfirst($personalInformation->gender)}}</h3>
</div>
