<div class="w-auto pt-8 pl-6 pr-20">
    <div class="text-xl font-semibold text-indigo-700">
        <h1>INITIAL APPLICANT STATISTICS</h1>
    </div>

    <div class="flex items-center justify-start w-auto h-auto gap-5 my-6">
        <h2>TOTAL NUMBER OF APPLICANTS:</h2>
        <p>{{ array_sum($count) }}</p>
    </div>

    <div class="h-auto chart-field" id="first" style="display: block;">
        <div class="grid gap-4 mb-4" style="grid-template-columns: 1fr 1fr 1.3fr;">
            <div class="w-full h-80">
                <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                    <h1>Application Progress</h1>
                </div>

                <div class="flex items-center justify-center w-full p-1 h-72">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>

            <div class="w-full h-80">
                <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                    <h1>Gender Percentage</h1>
                </div>

                <div class="flex items-center justify-center w-full p-1 h-72">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <div class="w-full h-80">
                <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                    <h1>Applicant Types</h1>
                </div>

                <div class="flex items-center justify-center w-full p-1 h-72">
                    <canvas id="applicantChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="h-auto chart-field" id="second" style="display: none;">
        <div class="grid gap-4 mb-4" style="grid-template-columns: 1fr 1fr;">
            <div class="w-full h-80">
                <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                    <h1>Applicants per Region</h1>
                </div>

                <div class="flex items-center justify-center w-full p-1 h-72">
                    <canvas id="regionChart"></canvas>
                </div>
            </div>

            <div class="w-full h-80">
                <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                    <h1>Manila/Non-Manila Ratio</h1>
                </div>

                <div class="flex items-center justify-center w-full p-1 h-72">
                    <canvas id="manilaRatioChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="h-auto chart-field" id="third" style="display: none;">
        <div class="grid gap-4 mb-4" style="grid-template-columns: 1.9fr 1fr 1fr;">
            <div class="w-full h-80">
                <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                    <h1>Applicants per Strand</h1>
                </div>

                <div class="flex items-center justify-center w-full p-1 h-72">
                    <canvas id="strandChart"></canvas>
                </div>
            </div>

            <div class="w-full h-80">
                <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                    <h1>Manila Public/Private Ratio</h1>
                </div>

                <div class="flex items-center justify-center w-full p-1 h-72">
                    <canvas id="manilaSchoolChart"></canvas>
                </div>
            </div>

            <div class="w-full h-80">
                <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                    <h1>Other Public/Private Ratio</h1>
                </div>

                <div class="flex items-center justify-center w-full p-1 h-72">
                    <canvas id="otherSchoolChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mt-16">
        <select id="chartSelector">
            <option value="first">Progress, Gender, & Applicant Type Statistics</option>
            <option value="second">Regions & Manila/Non-Manila Statistics</option>
            <option value="third">Strand & Public/Private Statistics</option>
        </select>

        <div>
            <h1>Actions for Inactive Applicant:</h1>
            <div class="flex h-10 gap-8 mt-2">
                <a href="" class="flex items-center justify-center w-32 bg-yellow-400 rounded-lg" onclick="return confirmArchive()">
                    Archive
                </a>

                <a href="" class="flex items-center justify-center w-32 bg-red-500 rounded-lg" onclick="return confirmDelete()">
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>