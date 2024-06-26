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

<a href="{{ route('admin.page', ['currentRoute' => 'announcements']) }}" class="flex items-center gap-5  transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'announcements' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">breaking_news</span>
    <h3>Announcements</h3>
</a>

<a href="{{ route('admin.page', ['currentRoute' => 'application-form']) }}" class="flex items-center gap-5  transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'application-form' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">description</span>
    <h3>Application Form</h3>
</a>

<a href="{{ route('admin.page', ['currentRoute' => 'exam']) }}" class="flex items-center gap-5  transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'exam' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">calendar_today</span>
    <h3>Exam Schedule</h3>
</a>

<a href="{{ route('admin.page', ['currentRoute' => 'result']) }}" class="flex items-center gap-5  transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'result' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">group_add</span>
    <h3>Results</h3>
</a>