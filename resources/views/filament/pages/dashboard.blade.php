<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Welcome Section --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="text-gray-500 mt-1">Here's what's happening in your system today.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Last updated: {{ now()->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="p-6 bg-white rounded-lg shadow">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('filament.admin.resources.students.create') }}" 
                    class="p-4 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors duration-200 group">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-primary-100 rounded-lg group-hover:bg-primary-200 transition-colors duration-200">
                            <x-heroicon-s-user-plus class="w-6 h-6 text-primary-600" />
                        </div>
                        <span class="text-sm font-medium text-gray-900">Add Student</span>
                    </div>
                </a>
                <a href="{{ route('filament.admin.resources.courses.create') }}" 
                    class="p-4 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors duration-200 group">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-primary-100 rounded-lg group-hover:bg-primary-200 transition-colors duration-200">
                            <x-heroicon-s-book-open class="w-6 h-6 text-primary-600" />
                        </div>
                        <span class="text-sm font-medium text-gray-900">Add Course</span>
                    </div>
                </a>
                <a href="{{ route('filament.admin.resources.instructors.create') }}" 
                    class="p-4 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors duration-200 group">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-primary-100 rounded-lg group-hover:bg-primary-200 transition-colors duration-200">
                            <x-heroicon-s-user-group class="w-6 h-6 text-primary-600" />
                        </div>
                        <span class="text-sm font-medium text-gray-900">Add Instructor</span>
                    </div>
                </a>
                <a href="{{ route('filament.admin.resources.marks.create') }}" 
                    class="p-4 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors duration-200 group">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-primary-100 rounded-lg group-hover:bg-primary-200 transition-colors duration-200">
                            <x-heroicon-s-clipboard-document-list class="w-6 h-6 text-primary-600" />
                        </div>
                        <span class="text-sm font-medium text-gray-900">Add Marks</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Recent Activities and Quick Actions --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Activities --}}
            <div class="p-6 bg-white rounded-lg shadow">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Activities</h2>
                <div class="space-y-4">
                    @forelse ($recentActivities as $activity)
                        <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center">
                                    <x-heroicon-o-{{ $activity['icon'] }} class="w-5 h-5 text-primary-600" />
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $activity['description'] }}</p>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-sm text-gray-500">No recent activities to show.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page> 