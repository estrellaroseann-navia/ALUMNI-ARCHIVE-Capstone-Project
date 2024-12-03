<table>
    <thead>
        <tr>
            <th>Category</th>
            <th>Item</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        <!-- Graduate Year Counts -->
        @foreach ($data['graduate_years'] as $year)
            <tr>
                <td>Graduate Year</td>
                <td>{{ $year->graduate_year ?? 'Unknown' }}</td>
                <td>{{ $year->total }}</td>
            </tr>
        @endforeach

        <!-- Campus Counts -->
        @foreach ($data['campuses'] as $campus)
            <tr>
                <td>Campus</td>
                <td>{{ $campus->campus->name ?? 'Unknown' }}</td>
                <td>{{ $campus->total }}</td>
            </tr>
        @endforeach

        <!-- Program Counts -->
        @foreach ($data['programs'] as $program)
            <tr>
                <td>Program</td>
                <td>{{ $program->program->name ?? 'Unknown' }}</td>
                <td>{{ $program->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
