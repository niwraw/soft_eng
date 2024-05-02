<div class="sticky top-0 flex items-center justify-center w-15v h-90v">
    <div class="flex flex-col items-center pt-6 bg-blue-800 h-85v w-14v rounded-xl gap-9">
        @if($routeSegment === 'admin')
            @include('components.dashboard.sections.admission')
        @else
            @include('components.dashboard.sections.applicant')
        @endif

        <a href="{{ route('logout') }}" class="flex items-center w-11/12 gap-5 pl-5 text-white transition-all duration-300 ease-in h-14">
            <span class="material-symbols-sharp">logout</span>
            <h3>Logout</h3>
        </a>
    </div>
</div>