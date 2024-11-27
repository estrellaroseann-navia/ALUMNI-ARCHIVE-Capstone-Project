@if (isset($record) && $record->userSubjects()->exists())
    @php
        $averageGrade = $record->userSubjects->avg('grade');
    @endphp
    <div class="p-4 bg-gray-100 rounded-lg">
        <strong>Average Grade:</strong> {{ round($averageGrade, 2) }}
    </div>
@else
    <div class="p-4 bg-gray-100 rounded-lg">
        <strong>Average Grade:</strong> No grades available.
    </div>
@endif
