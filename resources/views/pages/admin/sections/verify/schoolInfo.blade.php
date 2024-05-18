<div class="my-2 border-b-2 border-yellow-600">
    <h2 class="text-xl font-bold">School Information</h2>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Learners Reference Number:</h3>
    <h3>{{ $schoolInformation->lrn }}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">School Name:</h3>
    <h3>{{ $schoolInformation->school }}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">School Address:</h3>
    <h3>{{ $schoolInformation->schoolAddress }}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">School Region:</h3>
    <h3>{{ $schoolInformation->schoolRegion }}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">School Province:</h3>
    <h3>{{ $schoolInformation->schoolProvince }}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">School City:</h3>
    <h3>{{ $schoolInformation->schoolCity }}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">School Email:</h3>
    <h3>{{ $schoolInformation->schoolEmail }}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">School Type:</h3>
    <h3>{{ $schoolInformation->schoolType }}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Strand:</h3>
    <h3>{{ $schoolInformation->strand }}</h3>
</div>

<div class="grid" style="grid-template-columns: 1fr 2fr;">
    <h3 class="font-bold">Grade Weighted Average:</h3>
    <h3>{{ $schoolInformation->gwa }}</h3>
</div>