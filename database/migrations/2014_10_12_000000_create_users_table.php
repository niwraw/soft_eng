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
            $table->enum('suffix', ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
            $table->string('email')->unique();
            $table->string('contactNum')->unique();
            $table->enum('applicationType', ['SHS', 'ALS', 'OLD', 'TRANSFER']);
            $table->enum('gender', ['male', 'female']);

            // //Documents
            // $table->binary('birthCert');
            // $table->binary('form137');

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
            $table->string('city');
            $table->string('barangay');
            $table->string('zip');

            $table->timestamps();
        });

        Schema::create('apllicant_father_information', function (Blueprint $table) {
            $table->string('applicant_id')->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_personal_information')->onUpdate('cascade')->onDelete('cascade');

            // Father Information
            $table->string('fatherLast');
            $table->string('fatherFirst');
            $table->string('fatherMiddle');
            $table->enum('fatherSuffix', ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
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
            $table->enum('motherSuffix', ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
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
            $table->enum('guardianSuffix', ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'])->nullable();
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
