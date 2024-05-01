<?php

namespace Database\Seeders;

use App\Models\ApplicantPersonalInformation;
use App\Models\ApplicantOtherInformation;
use App\Models\ApplicantFatherInformation;
use App\Models\ApplicantMotherInformation;
use App\Models\ApplicantGuardianInformation;
use App\Models\ApplicantSchoolInformation;
use App\Models\ApplicantProgramInformation;
use App\Models\User;
use App\Models\Regions;
use App\Models\Provinces;
use App\Models\Cities;
use App\Models\Barangays;
use App\Helper\Helper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RegionSeed::class);
        $this->call(SchoolSeed::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(QuestionSeeder::class);

        $collegedepartment = [
            ['college_code' => 'CN', 'college' => 'College of Nursing'],
            ['college_code' => 'CPT', 'college' => 'College of Physical Therapy'],
            ['college_code' => 'CASBE', 'college' => 'College of Architecture and Sustainable Built Environments'],
            ['college_code' => 'CED', 'college' => 'College of Education'],
            ['college_code' => 'CE', 'college' => 'College of Engineering'],
            ['college_code' => 'CS', 'college' => 'College of Science'],
            ['college_code' => 'CISTM', 'college' => 'College of Information System and Technological Management'],
            ['college_code' => 'CHASS','college' => 'College of Humanities, Arts and Social Sciences']
        ];
        
        $programs = [
            ['course_code' => 'BSCS', 'course' => 'Bachelor of Science in Computer Science', 'college_code' => 'CISTM'],
            ['course_code' => 'BSIT', 'course' => 'Bachelor of Science in Information Technology', 'college_code' => 'CISTM'],
            ['course_code' => 'BSC', 'course' => 'Bachelor of Science in Communications', 'college_code' => 'CHASS'],
            ['course_code' => 'BSCSPR', 'course' => 'Bachelor of Science in Communications with Specialization in Public Relations', 'college_code' => 'CHASS'],
            ['course_code' => 'BSSW', 'course' => 'Bachelor of Science in Social Work', 'college_code' => 'CHASS'],
            ['course_code' => 'BSN', 'course' => 'Bachelor of Science in Nursing', 'college_code' => 'CN'],
            ['course_code' => 'BSPT', 'course' => 'Bachelor of Science in Physical Therapy', 'college_code' => 'CPT'],
            ['course_code' => 'BSArchi', 'course' => 'Bachelor of Science in Architecture', 'college_code' => 'CASBE'],
            ['course_code' => 'BSME', 'course' => 'Bachelor of Science in Mechanical Engineering', 'college_code' => 'CE'],
            ['course_code' => 'BSEE', 'course' => 'Bachelor of Science in Electrical Engineering', 'college_code' => 'CE'],
            ['course_code' => 'BSCE', 'course' => 'Bachelor of Science in Chemical Engineering', 'college_code' => 'CE'],
            ['course_code' => 'BSCpE', 'course' => 'Bachelor of Science in Computer Engineering', 'college_code' => 'CE'],
            ['course_code' => 'BSEcE', 'course' => 'Bachelor of Science in Electronics Engineering', 'college_code' => 'CE'],
        ];

        DB::table('app_form_colleges')->insert($collegedepartment);
        DB::table('app_form_course')->insert($programs);

        $users = [
            ['email' => 'admin@plm.edu.ph', 'password' => bcrypt('password'), 'role' => 'admin'],
            ['email' => 'ogts@plm.edu.ph', 'password' => bcrypt('password'), 'role' => 'ogts'],
        ];

        DB::table('admin_account')->insert($users);

        $applicant = [
            [
                'applicant_id' => '2022-00001',
                'lastName' => 'Dela Cruz',
                'firstName' => 'Juan',
                'middleName' => 'Dela',
                'suffix' => 'None',
                'email' => 'applicant@gmail.com',
                'contactNum' => '09123456789',
                'applicationType' => 'SHS',
                'gender' => 'male'
            ],
        ];

        DB::table('applicant_personal_information')->insert($applicant);

        $applicant = [
            [
                'applicant_id' => '2022-00001',
                'email' => 'applicant@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];

        DB::table('applicant_accounts')->insert($applicant);

        $year = date('Y');

        for ($i = 0; $i < 150; $i++) {
            $applicantId = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);

            $region = Regions::inRandomOrder()->first();
            $province = Provinces::where('region_code', $region->region_code)->inRandomOrder()->first();
            $city = Cities::where('province_code', $province->province_code)->inRandomOrder()->first();
            $barangay = Barangays::where('city_code', $city->city_code)->inRandomOrder()->first();

            $personalInfo = ApplicantPersonalInformation::create([
                'applicant_id' => $applicantId,
                'lastName' => $this->faker->lastName,
                'firstName' => $this->faker->firstName,
                'middleName' => $this->faker->lastName,
                'suffix' => $this->faker->randomElement(['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V']),
                'email' => $this->faker->unique()->safeEmail,
                'contactNum' => $this->faker->unique()->numerify('09#########'),
                'applicationType' => $this->faker->randomElement(['SHS', 'ALS', 'OLD', 'TRANSFER']),
                'gender' => $this->faker->randomElement(['male', 'female']),
                'status' => $this->faker->randomElement(['pending', 'approved', 'resubmission']),
            ]);

            ApplicantOtherInformation::create([
                'applicant_id' => $applicantId,
                'maidenName' => $this->faker->lastName,
                'birthDate' => $this->faker->date,
                'birthPlace' => $this->faker->city,
                'address' => $this->faker->address,
                'region' => $region->region_name,
                'province' => $province->province_name,
                'city' => $city->city_name,
                'barangay' => $barangay->brgy_name,
            ]);

            ApplicantFatherInformation::create([
                'applicant_id' => $applicantId,
                'fatherLast' => $this->faker->lastName,
                'fatherFirst' => $this->faker->firstName,
                'fatherMiddle' => $this->faker->lastName,
                'fatherSuffix' => $this->faker->randomElement(['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V']),
                'fatherAddress' => $this->faker->address,
                'fatherContact' => $this->faker->phoneNumber,
                'fatherJob' => $this->faker->jobTitle,
                'fatherIncome' => $this->faker->randomNumber(5),
            ]);

            ApplicantMotherInformation::create([
                'applicant_id' => $applicantId,
                'motherLast' => $this->faker->lastName,
                'motherFirst' => $this->faker->firstName,
                'motherMiddle' => $this->faker->lastName,
                'motherSuffix' => $this->faker->randomElement(['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V']),
                'motherAddress' => $this->faker->address,
                'motherContact' => $this->faker->phoneNumber,
                'motherJob' => $this->faker->jobTitle,
                'motherIncome' => $this->faker->randomNumber(5),
            ]);

            ApplicantGuardianInformation::create([
                'applicant_id' => $applicantId,
                'guardianLast' => $this->faker->lastName,
                'guardianFirst' => $this->faker->firstName,
                'guardianMiddle' => $this->faker->lastName,
                'guardianSuffix' => $this->faker->randomElement(['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V']),
                'guardianAddress' => $this->faker->address,
                'guardianContact' => $this->faker->phoneNumber,
                'guardianJob' => $this->faker->jobTitle,
                'guardianIncome' => $this->faker->randomNumber(5),
            ]);

            ApplicantSchoolInformation::create([
                'applicant_id' => $applicantId,
                'lrn' => $this->faker->unique()->numerify('############'),
                'school' => $this->faker->company,
                'schoolEmail' => $this->faker->companyEmail,
                'schoolType' => $this->faker->randomElement(['public', 'private']),
                'strand' => $this->faker->randomElement(['ABM', 'HUMSS', 'STEM', 'GAS', 'TVL', 'SPORTS', 'ADT', 'PBM']),
                'gwa' => $this->faker->randomFloat(2, 75, 100),
                'schoolRegion' => $region->region_name,
                'schoolProvince' => $province->province_name,
                'schoolCity' => $city->city_name,
                'schoolAddress' => $this->faker->address,
            ]);

            ApplicantProgramInformation::create([
                'applicant_id' => $applicantId,
                'choice1' => $this->faker->randomElement(['Program A', 'Program B', 'Program C']),
                'choice2' => $this->faker->randomElement(['Program A', 'Program B', 'Program C']),
                'choice3' => $this->faker->randomElement(['Program A', 'Program B', 'Program C']),
            ]);

            User::create([
                'applicant_id' => $applicantId,
                'email' => $personalInfo->email,
                'password' => bcrypt('secret'),
            ]);
        }
    }
}