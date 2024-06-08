<div class="text-xl font-medium text-white">
    <h2>Applicant Portal</h2>
</div>

<a href="{{ route('applicant.page', ['currentRoute' => 'dashboard', 'applicantId'=> $applicantId]) }}" class="flex items-center gap-5 transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'dashboard' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">dashboard</span>
    <h3>Dashboard</h3>
</a>

<a href="{{ route('applicant.page', ['currentRoute' => 'change', 'applicantId'=> $applicantId]) }}" class="flex items-center gap-5 transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'change' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">manage_accounts</span>
    <h3>Change Password</h3>
</a>

@if($examDetails->hasResult == "yes")
<a href="{{ route('applicant.page', ['currentRoute' => 'result', 'applicantId'=> $applicantId]) }}" class="flex items-center gap-5 transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'result' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">group_add</span>
    <h3>Result</h3>
</a>
@endif