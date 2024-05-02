<div class="text-xl font-medium text-white">
    <h2>Applicant Portal</h2>
</div>

<a href="{{ route('admin.page', ['currentRoute' => 'dashboard']) }}" class="flex items-center gap-5 transition-all duration-300 ease-in h-14 w-11/12 pl-5 {{$currentRoute == 'dashboard' ? 'bg-white text-black' : 'text-white'}}">
    <span class="material-symbols-sharp">dashboard</span>
    <h3>Dashboard</h3>
</a>