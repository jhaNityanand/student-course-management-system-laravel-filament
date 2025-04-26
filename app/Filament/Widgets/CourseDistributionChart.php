<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Log;

class CourseDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Course Distribution';
    protected static ?string $pollingInterval = '30s';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        try {
            $courses = Course::withCount('students')
                ->orderBy('students_count', 'desc')
                ->limit(5)
                ->get();

            if ($courses->isEmpty()) {
                return $this->getEmptyData();
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Students Enrolled',
                        'data' => $courses->pluck('students_count')->toArray(),
                        'backgroundColor' => [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF',
                        ],
                        'borderColor' => '#ffffff',
                        'borderWidth' => 2,
                    ],
                ],
                'labels' => $courses->pluck('title')->toArray(),
            ];
        } catch (\Exception $e) {
            Log::error('Course distribution chart error: ' . $e->getMessage());
            return $this->getEmptyData();
        }
    }

    protected function getEmptyData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Students Enrolled',
                    'data' => [],
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                    ],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 12,
                        'padding' => 20,
                    ],
                ],
            ],
            'cutout' => '70%',
        ];
    }
} 