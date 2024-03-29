<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RegionSeed::class);
        $this->call(SchoolSeed::class);

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
    }
}