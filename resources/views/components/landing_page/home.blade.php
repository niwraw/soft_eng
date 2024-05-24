<div class="flex flex-col items-center w-3/4 h-auto gap-4 px-12 py-8 border-r-2 border-yellow-400">
    <span class="text-4xl font-bold text-yellow-500">Welcome to PLM Online Admission</span>

    <img src="{{ asset('assets/image/plm.png') }}" class="w-3/4 h-auto">

    <div x-data="{ open: false }" class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
        <button @click="open = !open" class="flex flex-row justify-between text-2xl focus:outline-none">
            About PLM Admission
            <div>
                <span x-show="!open">+</span>
                <span x-show="open">&ndash;</span>
            </div>
        </button>
        
        <div x-show="open" x-collapse>
            <span>
                The Pamantsan ng Lungsod ng Maynila (PLM) will be accepting applicants (online) for freshmen students (undergraduate programs) for Academic Year (AY) 2025-2026 starting December 01, 2024. 
                <br><br>For AY 2024-2025, there will be an on-site PLM Admission Test (PLMAT). Minimum health protocols wil be observed to ensure the safety of student-applicants. PLMAT is a 4 hour examination consisting of sub test in English, Science, Mathematics, Filipino, and Abstract Reasoning. Passing the PLMAT is one of the requirements for admission to PLM.
                <br><br>Applicants must prepare the scanned copy (PDF) of the following:

                <br><br>1.) PSA Birth Certificate
                <br>2.) For Senior High School (SHS): Grade 11 certificate of General Weighted Average (GWA)
                <br>3.) For Alternative Learning System (ALS) completers and Accreditation & Equivalency (A&E) Passers: Certificate of Completion
            </span>
        </div>
    </div>

    <div x-data="{ open: false }" class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
        <button @click="open = !open" class="flex flex-row justify-between text-2xl focus:outline-none">
            Who May Apply
            <div>
                <span x-show="!open">+</span>
                <span x-show="open">&ndash;</span>
            </div>
        </button>
        
        <div x-show="open" x-collapse>
            <span>
                The student-applicant may apply provided that they comply with any of the following basic qualifications:
                
                <br><br>Senior High School (SHS) student who is currently enrolled in Grade 12 Department of Education (DepEd) accredited senior high school with a grade 11 general weighted average (GWA) of 80 or above.

                <br><br>Senior High School graduate from DepEd accredited senior high school with a grade 11 general weighted average (GWA) of 80 or above and has not taken any college or university units or programs during the application period.

                <br><br>The applicant completed Alternative Learning System (ALS) and passed the Accreditation & Equivalency (A&E) as recommended for tertiary education and has not taken any college or university units/programs during the application period.
            </span>
        </div>
    </div>

    <div x-data="{ open: false }" class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
        <button @click="open = !open" class="flex flex-row justify-between text-2xl focus:outline-none">
            How To Apply
            <div>
                <span x-show="!open">+</span>
                <span x-show="open">&ndash;</span>
            </div>
        </button>
        
        <div x-show="open" x-collapse>
            <span>
                <h3>Application Process</h3>
                <br>1. Apply on-line through the PLM Admission Portal.
                <br>2. Fill out the Application Form (online).
                <br>3. Upload required application requirements (online).
                <pre>                a. PSA Birth Certificate.
                b. Certificate of Grade 11 GWA (SHS)/Certificate of Completion (ALS)</pre>
                4. Check email for the account credentials after submitting the application successfully. Log in to PLM admission account on a regular basis to check the status of the application.
                <br>5. Upon evaluation of the information and requirements, print the Application Form.
                <br>6. Upload scanned-signed Application Form with ID picture (2 x 2 colored with white background).
                <br>7. Monitor the status of the Application Form at the PLM Admission Account.
                <br>8. Check email for the PLMAT examination schedule after the Application Form has been successfully evaluated.
                <br>9. Print two (2) copies of the exam permit.
                <br>10. On the specified examination date, bring two (2) signed exam permits with an ID picture (2x2 colored with white background) and the signed Application Form with ID picture (2x2 colored with white background).
            </span>
        </div>
    </div>

    <div x-data="{ open: false }" class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
        <button @click="open = !open" class="flex flex-row justify-between text-2xl focus:outline-none">
            Available Programs
            <div>
                <span x-show="!open">+</span>
                <span x-show="open">&ndash;</span>
            </div>
        </button>
        
        <div x-show="open" x-collapse>
            <span>
                <b>College of Architecture and Urban Planning (CAUP)</b>
                <br>Bachelor of Science in Architecture (BS Arch)

                <br><br><b>PLM Business School (PLMBS)</b>
                <br>Bachelor of Science in Accountancy (BSA)
                <br>Bachelor of Science in Business Administration major in Financial Management (BS BA-FM) Bachelor of Science in Business Administration major in Marketing Management (BS BA-MM) Bachelor of Science in Business Administration major in Business Economics (BS BA-BE)
                <br>Bachelor of Science in Entrepreneurship (BS Entrep)
                <br>Bachelor of Science in Hospitality Management (BS HM) Bachelor of Science in Real Estate Management (BS REM) Bachelor of Science in Tourism Management (BS TM)

                <br><br><b>College of Engineering (CEng)</b>
                <br>Bachelor of Science in Chemical Engineering (BS CHE) Bachelor of Science in Civil Engineering (BS CE) Bachelor of Science in Computer Engineering (BS CPE) Bachelor of Science in Electrical Engineering (BS EE) Bachelor of Science in Electronics Engineering (BS ECE)
                <br>Bachelor of Science in Mechanical Engineering (BS ME)
                <br>Bachelor of Science in Manufacturing Engineering (BS MfgE)
                <br>Bachelor of Science in Computer Science (BS CS)
                <br>Bachelor of Science in Information Technology (BS IT)

                <br><br><b>College of Humanities, Arts and Social Sciences (CHASS)</b>
                <br>Bachelor of Arts in Communication (BAC)
                <br>Bachelor of Arts in Communication Major in Public Relations (BAC-PR)

                <br><br><b>College of Music (CMU)</b>
                <br>Bachelor of Music in Music Performance (BMMP)

                <br><br><b>School of Social Work (SSW)</b>
                <br>Bachelor of Science in Social Work (BS SW)

                <br><br><b>College of Nursing (CN)</b>
                <br>Bachelor of Science in Nursing (BSN)
                <br>College of Physical Therapy (CPT)
                <br>Bachelor of Science in Physical Therapy (BSPT)

                <br><br><b>College of Science (CS)</b>
                <br>Bachelor of Science in Biology (BS Bio)
                <br>Bachelor of Science in Mathematics (BS Math)
                <br>Bachelor of Science in Chemistry (BS Chem)
                <br>Bachelor of Science in Psychology (BS Psy)

                <br><br><b>College of Education (CED)</b>
                <br>Bachelor of Physical Education (BPEd)
                <br>Bachelor of Secondary Education with Specialization in English (BSEd-Eng) Bachelor of Secondary Education with Specialization in Filipino (BSEd-Fil)
                <br>Bachelor of Secondary Education with Specialization in Mathematics (BSEd-Math)
                <br>Bachelor of Secondary Education with Specialization in Science (BSEd-Sci) Bachelor of Secondary Education major in Social Studies (BSEd-SS)

                <br><br><b>School of Government (SOG)</b>
                <br>Bachelor of Public Administration (BPA)
            
            </span>
        </div>
    </div>
</div>

<div class="flex flex-col items-center w-1/4 h-auto gap-10 px-2 py-8">
    <div class="w-11/12 h-auto overflow-hidden bg-gray-100 border-2 border-yellow-400 rounded-xl">
        <div class="h-auto px-5 py-3 bg-blue-800 border-b-2 border-yellow-400">
            <span class="text-2xl font-bold text-white ">PLM Online Admission</span>
        </div>

        <div class="px-5 py-3">
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col gap-2">
                        <label class="block text-gray-700 text-m">Email Address</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-800 focus:ring-1 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="block text-gray-700 text-m">Password</label>
                        <div class="relative mt-1">
                            <input id="password" name="password" type="password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-800 focus:ring-1 focus:ring-blue-500">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-700 hover:text-blue-500">
                                <span class="material-symbols-sharp">visibility</span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Sign In</button>
                </div>
            </form>
        </div>
    </div>

    <div class="w-11/12 h-auto overflow-hidden bg-gray-100 border-2 border-yellow-400 rounded-xl">
        <div class="h-auto px-5 py-3 bg-blue-800 border-b-2 border-yellow-400">
            <span class="text-2xl font-bold text-white ">Important Dates</span>
        </div>
        
        <div class="flex flex-col gap-3 px-5 py-3">
            <div class="flex flex-row gap-3">
                <span class="font-bold">{{ $start->date }}:</span>
                <span>Start of Application</span>
            </div>
            
            <div class="flex flex-row gap-3">
                <span class="font-bold">{{ $end->date }}:</span>
                <span>End of Application</span>
            </div>
        </div>
    </div>

    <div class="w-11/12 overflow-hidden bg-gray-100 border-2 border-yellow-400 h-96 rounded-xl">
        <div class="h-auto px-5 py-3 bg-blue-800 border-b-2 border-yellow-400">
            <span class="text-2xl font-bold text-white ">Advisory</span>
        </div>
        
        <div class="flex flex-col gap-3 px-5 py-3 overflow-x-hidden overflow-y-scroll h-5/6">
            @foreach($announcements as $announcement)
                <div class="flex flex-col gap-2 pb-3 border-b-2 border-yellow-400">
                        <h3 class="font-bold">{{ $announcement->date }}</h3>
                        
                        <p>{{ $announcement->announcement }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var passwordFieldType = passwordField.type;
        passwordField.type = passwordFieldType === "password" ? "text" : "password";
    }
</script>