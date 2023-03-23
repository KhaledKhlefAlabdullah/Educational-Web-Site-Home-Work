<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->timestamps();
        });
        $departments = [
        'Mathematics',
        'Science',
        'History',
        'English',
        'Art',
        'Physical Education',
        'Computer Science',
        'Business Studies',
        'Social Studies',
        'Geography',
        'Music',
        'Foreign Languages',
        'Health Education',
        'Religious Studies',
        'Psychology',
        'Philosophy',
        'Economics',
        'Political Science',
        'Environmental Science',
        'Law',
        'Engineering',
        'Architecture',
        'Journalism',
        'Media Studies',
        'Hospitality Management',
        'Fashion Design',
        'Culinary Arts',
        'Film Studies',
        'Animation',
        'Graphic Design',
        'Industrial Design',
        'Interior Design',
        'Performing Arts',
        'Dance',
        'Theater',
        'Fine Arts',
        'Visual Arts',
        'Photography',
        'Communication Studies',
        'Education',
        'Library Science',
        'Public Administration',
        'Web Development',
        'Mobile Development',
        'Game Development',
        'Database Administration',
        'Cybersecurity',
        'Software Engineering',
        'Artificial Intelligence',
        'Machine Learning',
        'Data Science',
        'Cloud Computing',
        'DevOps',
        'Networking',
        'Operating Systems',
        'Embedded Systems',
        'Computer Graphics',
        'Computer Vision',
        'Natural Language Processing',
        'Robotics',
        'Blockchain',
        'Internet of Things',
        'Quantum Computing',
        'Programming Languages',
        'Algorithms and Data Structures',
        'Computer Architecture',
        'Computer Organization',
        'Compiler Design',
        'Software Testing',
        'Software Quality Assurance',
        'Agile Development',
        'Project Management',
        'Technical Writing',
        'User Experience Design',
        'User Interface Design'
        ];
        DB::table('departments')->insert(
            array_map(function ($dept) {
                return ['department' => $dept];
            }, $departments)
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
