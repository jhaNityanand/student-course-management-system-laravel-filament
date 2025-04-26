<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Log;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        try {
            $studentCount = Student::count();
            $courseCount = Course::count();
            $userCount = User::count();

            return [
                Stat::make('Total Students', $studentCount)
                    ->description('Active students')
                    ->descriptionIcon('heroicon-m-academic-cap')
                    ->color('success')
                    ->extraAttributes([
                        'wire:loading.class' => 'opacity-50',
                    ]),
                Stat::make('Total Courses', $courseCount)
                    ->description('Available courses')
                    ->descriptionIcon('heroicon-m-book-open')
                    ->color('warning')
                    ->extraAttributes([
                        'wire:loading.class' => 'opacity-50',
                    ]),
                Stat::make('Total Users', $userCount)
                    ->description('System users')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('primary')
                    ->extraAttributes([
                        'wire:loading.class' => 'opacity-50',
                    ]),
            ];
        } catch (\Exception $e) {
            Log::error('Stats overview error: ' . $e->getMessage());
            return [
                Stat::make('Error', 'N/A')
                    ->description('Unable to load statistics')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('danger'),
            ];
        }
    }
} 