<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard\Concerns\HasFilamentWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\StudentEnrollmentChart;
use App\Filament\Widgets\CourseDistributionChart;
use Filament\Pages\Page;
use App\Models\Student;
use App\Models\Course;
use App\Models\Mark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.dashboard';
    protected static bool $shouldRegisterNavigation = true;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            StudentEnrollmentChart::class,
            CourseDistributionChart::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // StatsOverview::class,
            // StudentEnrollmentChart::class,
            // CourseDistributionChart::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }

    protected function getViewData(): array
    {
        return [
            'recentActivities' => $this->getRecentActivities(),
        ];
    }

    protected function getRecentActivities(): array
    {
        $activities = [];

        try {
            // Recent students
            $recentStudents = Student::latest()->take(3)->get();
            foreach ($recentStudents as $student) {
                $activities[] = [
                    'icon' => 'user-plus',
                    'description' => "New student registered: {$student->first_name} {$student->last_name}",
                    'time' => $student->created_at->diffForHumans(),
                ];
            }

            // Recent courses
            $recentCourses = Course::latest()->take(3)->get();
            foreach ($recentCourses as $course) {
                $activities[] = [
                    'icon' => 'book-open',
                    'description' => "New course added: {$course->title}",
                    'time' => $course->created_at->diffForHumans(),
                ];
            }

            // Recent marks
            $recentMarks = DB::table('marks')
                ->join('students', 'marks.student_id', '=', 'students.id')
                ->join('courses', 'marks.course_id', '=', 'courses.id')
                ->select('marks.*', 'students.first_name', 'students.last_name', 'courses.title as course_name')
                ->latest('marks.created_at')
                ->take(3)
                ->get();

            foreach ($recentMarks as $mark) {
                $activities[] = [
                    'icon' => 'clipboard-document-list',
                    'description' => "Marks added for {$mark->first_name} {$mark->last_name} in {$mark->course_name}",
                    'time' => Carbon::parse($mark->created_at)->diffForHumans(),
                ];
            }

            // Sort activities by time
            usort($activities, function ($a, $b) {
                return strtotime($b['time']) - strtotime($a['time']);
            });

            return array_slice($activities, 0, 5);
        } catch (\Exception $e) {
            Log::error('Dashboard activities error: ' . $e->getMessage());
            return [];
        }
    }
} 