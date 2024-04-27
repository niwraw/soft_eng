<div class="flex flex-col w-full h-auto gap-4 px-8 py-6">
    <div class="text-xl font-semibold">
        Frequently Asked Questions
    </div>

    <div class="flex flex-col">
        <div class="flex flex-col py-2 text-lg font-medium border-t-2 border-b-2 border-yellow-400">
            <span class="py-2 pl-4 bg-red-200 border-l-8 border-red-500">Q: How to Apply?</span>
            <span class="py-2 pl-4 border-l-8 border-blue-500">A: Admission process is the process of applying to a university or college and being admitted to the university or college.</span>
        </div>

        <div class="flex flex-col py-2 text-lg font-medium border-b-2 border-yellow-400">
            <span class="py-2 pl-4 bg-red-200 border-l-8 border-red-500">Q: What are the requirements for admission?</span>
            <span class="py-2 pl-4 border-l-8 border-blue-500">A: Requirements for admission are the documents needed to be submitted to the university or college for the admission process.</span>
        </div>

        <div class="flex flex-col py-2 text-lg font-medium border-b-2 border-yellow-400">
            <span class="py-2 pl-4 bg-red-200 border-l-8 border-red-500">Q: How to apply for admission?</span>
            <span class="py-2 pl-4 border-l-8 border-blue-500">A: To apply for admission, you need to visit the university or college's website and fill out the application form.</span>
        </div>

        <div class="flex flex-col py-2 mb-8 text-lg font-medium border-b-2 border-yellow-400">
            <span class="py-2 pl-4 bg-red-200 border-l-8 border-red-500">Q: What are the important dates for admission?</span>
            <span class="py-2 pl-4 border-l-8 border-blue-500">A: Important dates for admission are the dates when the application process starts and ends.</span>
        </div>
    </div>

    <div class="flex flex-row gap-4">
        <form action="" method="POST" class="w-1/2" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-4">
                <h1 class="text-xl font-semibold">For Other Inquiry</h1>
                
                <div class="">
                    <x-input-label for="fullName" :value="__('Full Name')" />
                    <x-text-input id="fullName" class="w-full" type="text" name="fullName" value="{{ old('fullName') }}" required autofocus/>
                    <x-input-error :messages="$errors->get('fullName')" class="mt-2" />
                </div>

                <div class="">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="w-full" type="email" name="email" value="{{ old('email') }}" required autofocus/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="">
                    <x-input-label for="inquiry" :value="__('Your Inquiry')" />
                    <textarea id="inquiry" class="w-full" name="inquiry" rows="10" cols="50">
                    </textarea>
                    <x-input-error :messages="$errors->get('inquiry')" class="mt-2" />
                </div>

                <x-primary-button class="flex items-center justify-center">
                    {{ __('Submit Inquiry') }}
                </x-primary-button>
            </div>
        </form>

        <div class="w-1/2 h-auto bg-red-200">
        </div>
    </div>
</div>