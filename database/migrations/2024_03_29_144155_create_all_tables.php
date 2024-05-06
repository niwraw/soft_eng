<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicant_personal_information', function (Blueprint $table) {
            $table->id();
            $table->string('applicant_id')->unique();

            // Personal Info
            $table->string('lastName');
            $table->string('firstName');
            $table->string('middleName');
            $table->enum('suffix', ['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V'])->nullable();
            $table->string('email')->unique();
            $table->string('contactNum')->unique();
            $table->enum('applicationType', ['SHS', 'ALS', 'OLD', 'TRANSFER']);
            $table->enum('gender', ['male', 'female']);
            $table->enum('status', ['pending', 'approved', 'resubmission'])->default('pending');
            $table->enum('activity', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });

        Schema::create('applicant_other_information', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');

            // Other Information
            $table->string('maidenName')->nullable();
            $table->date('birthDate');
            $table->string('birthPlace');
            $table->string('address');
            $table->string('region');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            // $table->string('zip');

            $table->timestamps();
        });

        Schema::create('applicant_father_information', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');

            // Father Information
            $table->string('fatherLast');
            $table->string('fatherFirst');
            $table->string('fatherMiddle');
            $table->enum('fatherSuffix', ['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
            $table->string('fatherAddress');
            $table->string('fatherContact');
            $table->string('fatherJob');
            $table->string('fatherIncome');

            $table->timestamps();
        });

        Schema::create('applicant_mother_infomation', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');

            // Mother Information
            $table->string('motherLast');
            $table->string('motherFirst');
            $table->string('motherMiddle');
            $table->enum('motherSuffix', ['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
            $table->string('motherAddress');
            $table->string('motherContact');
            $table->string('motherJob');
            $table->string('motherIncome');

            $table->timestamps();
        });

        Schema::create('applicant_guardian_information', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');

            // Guardian Information
            $table->string('guardianLast')->nullable();
            $table->string('guardianFirst')->nullable();
            $table->string('guardianMiddle')->nullable();
            $table->enum('guardianSuffix', ['None', 'Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
            $table->string('guardianAddress')->nullable();
            $table->string('guardianContact')->nullable();
            $table->string('guardianJob')->nullable();
            $table->string('guardianIncome')->nullable();

            $table->timestamps();
        });

        Schema::create('applicant_school_information', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');

            // School Information
            $table->string('lrn');
            $table->string('school');
            $table->string('schoolAddress');
            $table->string('schoolRegion');
            $table->string('schoolProvince');
            $table->string('schoolCity');
            $table->string('schoolEmail');
            $table->enum('schoolType', ['public', 'private']);
            $table->enum('strand', ['ABM', 'HUMSS', 'STEM', 'GAS' , 'TVL', 'SPORTS' , 'ADT', 'PBM']);
            $table->string('gwa');

            $table->timestamps();
        });

        Schema::create('applicant_program_information', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');

            // Program Choices
            $table->string('choice1');
            $table->string('choice2');
            $table->string('choice3');

            $table->timestamps();
        });

        Schema::create('applicant_document_SHS', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');
            $table->string('birthCert');
            $table->enum('birthCertStatus', ['pending', 'approved', 'reupload'])->default('pending');
            $table->string('birthCertComment')->nullable()->default('Waiting for approval');
            $table->string('others');
            $table->enum('othersStatus', ['pending', 'approved', 'reupload'])->default('pending');
            $table->string('othersComment')->nullable()->default('Waiting for approval');

            $table->timestamps();
        });

        Schema::create('applicant_document_ALS', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');
            $table->string('birthCert');
            $table->enum('birthCertStatus', ['pending', 'approved', 'reupload'])->default('pending');
            $table->string('birthCertComment')->nullable()->default('Waiting for approval');
            $table->string('others');
            $table->enum('othersStatus', ['pending', 'approved', 'reupload'])->default('pending');
            $table->string('othersComment')->nullable()->default('Waiting for approval');

            $table->timestamps();
        });

        Schema::create('applicant_document_OLD', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');
            $table->string('birthCert');
            $table->enum('birthCertStatus', ['pending', 'approved', 'reupload'])->default('pending');
            $table->string('birthCertComment')->nullable()->default('Waiting for approval');
            $table->string('approvalLetter');
            $table->enum('approvalLetterStatus', ['pending', 'approved', 'reupload'])->default('pending');
            $table->string('approvalLetterComment')->nullable()->default('Waiting for approval');
            $table->string('highSchoolCard');
            $table->enum('highSchoolCardStatus', ['pending', 'approved', 'reupload'])->default('pending');
            $table->string('highSchoolCardComment')->nullable()->default('Waiting for approval');

            $table->timestamps();
        });

        Schema::create('applicant_document_TRANSFER', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');
            $table->string('birthCert');
            $table->enum('birthCertStatus', ['pending', 'approved', 'reupload'])->default('pending');
            $table->string('birthCertComment')->nullable()->default('Waiting for approval');
            $table->string('others');
            $table->enum('othersStatus', ['pending', 'approved', 'reupload'])->default('pending');
            $table->string('othersComment')->nullable()->default('Waiting for approval');

            $table->timestamps();
        });

        Schema::create('applicant_accounts', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');
            $table->string('email');
            $table->foreign('email')->references('email')->on('applicant_personal_information')->onUpdate('cascade');
            $table->string('password');

            $table->timestamps();
        });


        Schema::create('app_form_region', function (Blueprint $table) {
            $table->string('region_code')->primary();
            $table->string('region_name');
            $table->timestamps();
        });

        Schema::create('app_form_province', function (Blueprint $table) {
            $table->string('province_code')->primary();
            $table->string('province_name');
            $table->string('region_code');
            $table->foreign('region_code')->references('region_code')->on('app_form_region')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('app_form_city', function (Blueprint $table) {
            $table->string('city_code')->primary();
            $table->string('city_name');
            $table->string('province_code');
            $table->foreign('province_code')->references('province_code')->on('app_form_province')->onUpdate('cascade')->onDelete('cascade');
            
            
            $table->timestamps();
        });

        Schema::create('app_form_barangay', function (Blueprint $table) {
            $table->string('brgy_code')->primary();
            $table->string('brgy_name');
            $table->string('city_code');
            $table->foreign('city_code')->references('city_code')->on('app_form_city')->onUpdate('cascade')->onDelete('cascade');
            
            
            $table->timestamps();
        });

        // Schema::create('app_form_zip', function (Blueprint $table) {
        //     $table->string('zip')->primary();
        //     $table->string('municipality');
        //     $table->foreign('municipality')->references('municipality')->on('app_form_municipality')->onUpdate('cascade')->onDelete('cascade');
            
            
        //     $table->timestamps();
        // });

        Schema::create('app_form_colleges', function (Blueprint $table) {
            $table->string('college_code')->primary();
            $table->string('college');
            
            $table->timestamps();
        });

        Schema::create('app_form_course', function (Blueprint $table) {
            $table->string('course_code')->primary();
            $table->string('course');
            $table->string('college_code');
            $table->foreign('college_code')->references('college_code')->on('app_form_colleges')->onUpdate('cascade')->onDelete('cascade');
            
            $table->timestamps();
        });

        Schema::create('app_form_school', function (Blueprint $table) {
            $table->integer('school_id')->primary();
            $table->string('school_name');
            
            $table->timestamps();
        });
    }
};