<div class="flex flex-col w-full h-auto gap-4 px-8 py-6">
    <div>
        Frequently Asked Questions
    </div>

    <div>
        <div>
            <span>How to Apply?</span>
            <span>Admission process is the process of applying to a university or college and being admitted to the university or college.</span>
        </div>

        <div>
            <span>What are the requirements for admission?</span>
            <span>Requirements for admission are the documents needed to be submitted to the university or college for the admission process.</span>
        </div>

        <div>
            <span>How to apply for admission?</span>
            <span>To apply for admission, you need to visit the university or college's website and fill out the application form.</span>
        </div>

        <div>
            <span>What are the important dates for admission?</span>
            <span>Important dates for admission are the dates when the application process starts and ends.</span>
        </div>
    </div>

    <form action="" method="POST" class="w-1/2" enctype="multipart/form-data">
        @csrf
        <h1>For Other Inquiry</h1>
        
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

        <x-primary-button class="ms-4">
            {{ __('Submit Inquiry') }}
        </x-primary-button>
    </form>
</div>