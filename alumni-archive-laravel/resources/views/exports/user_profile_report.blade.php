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
        <tr>
            <td rowspan="{{ count($data['graduate_years']) + 1 }}">Graduate Years</td>
        </tr>
        @foreach ($data['graduate_years'] as $year)
            <tr>
                <td>{{ $year->graduate_year ?? 'Unknown' }}</td>
                <td>{{ $year->total }}</td>
            </tr>
        @endforeach

        <!-- Campus Counts -->
        <tr>
            <td rowspan="{{ count($data['campuses']) + 1 }}">Campuses</td>
        </tr>
        @foreach ($data['campuses'] as $campus)
            <tr>
                <td>{{ $campus->campus->name ?? 'Unknown' }}</td>
                <td>{{ $campus->total }}</td>
            </tr>
        @endforeach

        <!-- Program Counts -->
        <tr>
            <td rowspan="{{ count($data['programs']) + 1 }}">Programs</td>
        </tr>
        @foreach ($data['programs'] as $program)
            <tr>
                <td>{{ $program->program->name ?? 'Unknown' }}</td>
                <td>{{ $program->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
