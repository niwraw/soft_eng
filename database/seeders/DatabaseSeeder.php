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
        
        
        $schools = [
            ['school_id'=> 400860, 'school_name'=> 'Data Center College of the Philippines'],
            ['school_id'=> 406102, 'school_name'=> 'Abra Valley Colleges'],
            ['school_id'=> 406107, 'school_name'=> 'Holy Spirit Academy of Bangued'],
            ['school_id'=> 406109, 'school_name'=> 'St. Joseph Seminary'],
            ['school_id'=> 478501, 'school_name'=> 'Divine Word College of Bangued'],
            ['school_id'=> 600197, 'school_name'=> 'Abra State Institute of Science and Technology-Bangued Campus'],
            ['school_id'=> 406112, 'school_name'=> 'Abra Mountain Development Educational Center'],
            ['school_id'=> 406113, 'school_name'=> 'Heart of Mary High School'],
            ['school_id'=> 406115, 'school_name'=> 'Queen of Peace High School - Canan'],
            ['school_id'=> 406116, 'school_name'=> 'Queen of Peace High School - La Paz'],
            ['school_id'=> 406117, 'school_name'=> 'Our Lady of Guadalupe School'],
            ['school_id'=> 406118, 'school_name'=> 'Holy Cross School of Lagangilang, Inc.'],
            ['school_id'=> 600113, 'school_name'=> 'Abra State Institute of Sciences and Technology'],
            ['school_id'=> 406122, 'school_name'=> 'Our Lady of Lourdes High School'],
            ['school_id'=> 406124, 'school_name'=> 'Little Flower High School'],
            ['school_id'=> 406125, 'school_name'=> "St. Mary's High School"],
            ['school_id'=> 406126, 'school_name'=> 'Catholic High School of Pilar'],
            ['school_id'=> 406127, 'school_name'=> 'Fr. Arnoldus High School'],
            ['school_id'=> 406128, 'school_name'=> 'St. John High School'],
            ['school_id'=> 406129, 'school_name'=> 'Holy Ghost School'],
            ['school_id'=> 406132, 'school_name'=> 'St. Paul High School'],
            ['school_id'=> 600114, 'school_name'=> 'Apayao State College'],
            ['school_id'=> 406134, 'school_name'=> 'Saint Joseph High School of Flora, Inc.'],
            ['school_id'=> 406136, 'school_name'=> 'Our Lady of Lourdes High School of Kabugao'],
            ['school_id'=> 406137, 'school_name'=> 'Santo Rosario School of Pudtol, Inc.'],
            ['school_id'=> 406138, 'school_name'=> "Saint Paul's Academy of Sayangan, Inc."],
            ['school_id'=> 400861, 'school_name'=> 'AMA Computer College-Baguio City'],
            ['school_id'=> 400867, 'school_name'=> 'Baguio College of Technology'],
            ['school_id'=> 400869, 'school_name'=> 'BSBT College, Inc.'],
            ['school_id'=> 400873, 'school_name'=> 'Casiciaco Recoletos Seminary, Inc.'],
            ['school_id'=> 400883, 'school_name'=> 'Data Center College of the Philippines of Baguio City, Inc'],
            ['school_id'=> 400889, 'school_name'=> 'Informatics Baguio City Center, Inc.'],
            ['school_id'=> 400903, 'school_name'=> 'International School of Asia and the Pacific'],
            ['school_id'=> 400907, 'school_name'=> 'MMS Development Training Center Corporation'],
            ['school_id'=> 400908, 'school_name'=> 'Philippine BELL International School'],
            ['school_id'=> 400912, 'school_name'=> 'BVS College'],
            ['school_id'=> 400925, 'school_name'=> 'Philippine Nazarene College'],
            ['school_id'=> 406014, 'school_name'=> 'Concordia College of Benguet, Inc.'],
            ['school_id'=> 406149, 'school_name'=> 'Cordillera Career Development College'],
            ['school_id'=> 406153, 'school_name'=> 'HOPE Christian Academy'],
            ['school_id'=> 406156, 'school_name'=> 'San Jose School of La Trinschool_idad, Inc'],
            ['school_id'=> 406162, 'school_name'=> 'Star Colleges'],
            ['school_id'=> 479537, 'school_name'=> "King's College of the Philippines"],
            ['school_id'=> 479540, 'school_name'=> 'Northskills Polytechnic College, Inc.'],
            ['school_id'=> 600116, 'school_name'=> 'Benguet State University-Secondary Lab School'],
            ['school_id'=> 407590, 'school_name'=> 'Immaculate Conception School'],
            ['school_id'=> 406176, 'school_name'=> 'The Ifugao Academy, Inc.'],
            ['school_id'=> 406177, 'school_name'=> "St. Joseph's School"],
            ['school_id'=> 407645, 'school_name'=> 'Riverview Polytechnic and Academic School, Inc.'],
            ['school_id'=> 406178, 'school_name'=> 'Don Bosco High School'],
            ['school_id'=> 406180, 'school_name'=> 'San Francisco High School'],
            ['school_id'=> 406181, 'school_name'=> 'Assumption Academy'],
            ['school_id'=> 406182, 'school_name'=> "St. Paul's Memorial School of Kalinga, Inc."],
            ['school_id'=> 406183, 'school_name'=> 'St. Theresita High School of Salegseg, Inc.'],
            ['school_id'=> 400927, 'school_name'=> 'International School of Asia and the Pacific-Kalinga Campus'],
            ['school_id'=> 400939, 'school_name'=> 'Cordillera A+ Computer Technology College'],
            ['school_id'=> 406188, 'school_name'=> 'Saint Tonis College, Inc.'],
            ['school_id'=> 406192, 'school_name'=> 'St. Theresita High School - Tabuk'],
            ['school_id'=> 406195, 'school_name'=> 'Tabuk Institute'],
            ['school_id'=> 407461, 'school_name'=> "Saint William's Academy"],
            ['school_id'=> 480511, 'school_name'=> 'Kalinga Colleges of Science and Technology'],
            ['school_id'=> 600198, 'school_name'=> 'Kalinga-Apayao State College'],
            ['school_id'=> 406185, 'school_name'=> "St. Theresita's School of Lubuagan, Inc."],
            ['school_id'=> 406186, 'school_name'=> 'St. Theresita High School - Pinukpuk'],
            ['school_id'=> 406187, 'school_name'=> "Saint Michael's Academy, Rizal, Inc."],
            ['school_id'=> 406198, 'school_name'=> "St. Theresita's High School - Tinglayan"],
            ['school_id'=> 406199, 'school_name'=> 'Bauko Catholic School'],
        ];

        DB::table('app_form_school')->insert($schools);
        DB::table('app_form_colleges')->insert($collegedepartment);
        DB::table('app_form_course')->insert($programs);
    }
}