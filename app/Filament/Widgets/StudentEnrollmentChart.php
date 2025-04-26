<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentEnrollmentChart extends ChartWidget
{
    protected static ?string $heading = 'Student Enrollment Trend';
    protected static ?string $pollingInterval = '30s';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        try {
            $enrollments = DB::table('students')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            if ($enrollments->isEmpty()) {
                return $this->getEmptyData();
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Student Enrollments',
                        'data' => $enrollments->pluck('count')->toArray(),
                        'backgroundColor' => '#4CAF50',
                        'borderColor' => '#388E3C',
                        'tension' => 0.4,
                        'fill' => true,
                    ],
                ],
                'labels' => $enrollments->map(function ($item) {
                    return date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year));
                })->toArray(),
            ];
        } catch (\Exception $e) {
            Log::error('Student enrollment chart error: ' . $e->getMessage());
            return $this->getEmptyData();
        }
    }

    protected function getEmptyData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Student Enrollments',
                    'data' => [],
                    'backgroundColor' => '#4CAF50',
                    'borderColor' => '#388E3C',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => [],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
} 