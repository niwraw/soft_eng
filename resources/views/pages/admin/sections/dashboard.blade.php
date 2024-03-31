<div class="w-auto pt-8 pl-6 pr-20">
    <div class="text-xl font-semibold text-indigo-700">
        <h1>INITIAL APPLICANT STATISTICS</h1>
    </div>

    <div class="flex items-center justify-start w-auto h-auto gap-5 my-6">
        <h2>TOTAL NUMBER OF APPLICANTS:</h2>
        <p>{{ array_sum($count) }}</p>
    </div>

    <div class="grid gap-4 mb-4" style="grid-template-columns: 1fr 1fr 1.3fr;">
        <div class="w-full h-80">
            <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                <h1>Application Progress</h1>
            </div>

            <div class="flex items-center justify-center p-1 h-72 w-ful">
                <canvas id="progressChart" style="width: 100%; height: inherit;"></canvas>
            </div>
        </div>

        <div class="w-full h-80">
            <div class="flex items-center w-full h-10 pl-4 text-lg font-medium">
                <h1>Gender Percentage</h1>
            </div>

            <div class="flex items-center justify-center p-1 h-72 w-ful">
                <canvas id="genderChart" style="width: 100%; height: inherit;"></canvas>
            </div>
        </div>
    </div>
</div>