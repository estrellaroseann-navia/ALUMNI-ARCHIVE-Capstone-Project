<x-filament-widgets::widget>
    <x-filament::section>
       <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <x-filament::card>
        <h2 class="text-xl font-semibold">Number of Students</h2>
        <p class="text-2xl">{{ $studentsCount }}</p>
    </x-filament::card>

    <x-filament::card>
        <h2 class="text-xl font-semibold">Number of Subjects</h2>
        <p class="text-2xl">{{ $subjectsCount }}</p>
    </x-filament::card>

    <x-filament::card>
        <h2 class="text-xl font-semibold">Top 10 Students</h2>
        <ul class="space-y-2">
            @foreach($topStudents as $student)
                <li>{{ $student['name'] }} - Average Grade: {{ $student['average'] }}</li>
            @endforeach
        </ul>
    </x-filament::card>
</div>

    </x-filament::section>
</x-filament-widgets::widget>
