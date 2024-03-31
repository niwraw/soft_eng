<div class="text-xl font-medium text-white">
    <h2>Admission Office</h2>
</div>

<a href="{{ route('admin.page', ['currentRoute' => 'dashboard']) }}" class="flex items-center gap-5 transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'dashboard' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">dashboard</span>
    <h3>Dashboard</h3>
</a>

<a href="{{ route('admin.page', ['currentRoute' => 'applicants']) }}" class="flex items-center gap-5  transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'applicants' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">person</span>
    <h3>Applicant</h3>
</a>

<a href="" class="flex items-center gap-5 text-white transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'exam' ? 'bg-white text-black' : ''}}">
    <span class="material-symbols-sharp">view_timeline</span>
    <h3>Exam Details</h3>
</a>

<a href="" class="flex items-center gap-5 text-white transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'attendance' ? 'bg-white text-black' : ''}}">
    <span class="material-symbols-sharp">manage_search</span>
    <h3>Attendance</h3>
</a>

<a href="" class="flex items-center gap-5 text-white transition-all duration-300 ease-in h-14 w-11/12 pl-5  {{$currentRoute == 'result' ? 'bg-white text-black' : ''}}">
    <span class="material-symbols-sharp">manage_search</span>
    <h3>Result</h3>
</a>