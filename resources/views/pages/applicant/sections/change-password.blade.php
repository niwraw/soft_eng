<div class="flex items-center justify-center w-full h-full pb-28">
    <div class="w-1/2 px-8 py-4 bg-gray-300 rounded-lg h-fit">
        <h1 class="mb-8 text-lg font-medium">Change Password</h1>

        <form action="{{ route('applicant.change', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]) }}" method="POST">
            @csrf
            <div class="mb-4">
                <x-input-label for="curPass" :value="__('Current Password')" />
                <x-text-input id="curPass" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="password" name="curPass" required/>
                <x-input-error :messages="$errors->get('curPass')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="newPass" :value="__('New Password')" />
                <x-text-input id="newPass" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="password" name="newPass" required/>
                <x-input-error :messages="$errors->get('newPass')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="newPass_confirmation" :value="__('Confirm New Password')" />
                <x-text-input id="newPass_confirmation" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="password" name="newPass_confirmation" required/>
                <x-input-error :messages="$errors->get('newPass_confirmation')" class="mt-2" />
            </div>

            <button type="submit" onclick="return confirmChangePass()" class="p-2 text-white bg-blue-500 rounded-lg">Change Password</button>
        </form>
    </div>
</div>

<script>
    function confirmChangePass() {
        return confirm('Are you sure you want to change your password?');
    }
</script>

@if(session('changed'))
    <script>
        alert('{{ session('changed') }}');
    </script>
@endif