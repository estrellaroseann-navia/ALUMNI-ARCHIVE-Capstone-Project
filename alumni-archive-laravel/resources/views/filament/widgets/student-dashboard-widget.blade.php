<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Filter Form -->
            <div class="p-4 bg-white rounded-lg shadow">
                <h2 class="text-xl font-semibold">Filter Alumni</h2>
                <form>
                    <div class="mb-4">
                        <label for="program" class="block text-sm font-medium text-gray-700">Program</label>
                        <select id="program" name="program" class="block w-full mt-1">
                            <option value="">Select Program</option>
                            @foreach($programs as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="campus" class="block text-sm font-medium text-gray-700">Campus</label>
                        <select id="campus" name="campus" class="block w-full mt-1">
                            <option value="">Select Campus</option>
                            @foreach($campuses as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="graduateYear" class="block text-sm font-medium text-gray-700">Graduate Year</label>
                        <select id="graduateYear" name="graduateYear" class="block w-full mt-1">
                            <option value="">Select Graduate Year</option>
                            @foreach($graduateYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <!-- Alumni Count -->
            <div class="p-4 bg-white rounded-lg shadow">
                <h2 class="text-xl font-semibold">Number of Alumni</h2>
                <p class="text-2xl">{{ $alumniCount }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Line Graph for Graduates by Year -->
            <div class="p-4 bg-white rounded-lg shadow">
                <h2 class="text-xl font-semibold">Graduates by Year</h2>
                <canvas id="lineGraph"></canvas>
            </div>

            <!-- Pie Chart for Alumni by Program -->
            <div class="p-4 bg-white rounded-lg shadow">
                <h2 class="text-xl font-semibold">Alumni by Program</h2>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </x-filament::section>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        console.log(@json($graduateYearsData));
console.log(@json($programsData));
        // Line Graph for Graduate Year
        const lineGraphCtx = document.getElementById('lineGraph').getContext('2d');
        const lineGraph = new Chart(lineGraphCtx, {
            type: 'line',
            data: {
                labels: @json($graduateYearsData->pluck('graduate_year')),
                datasets: [{
                    label: 'Graduates by Year',
                    data: @json($graduateYearsData->pluck('total')),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Graduate Year'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Graduates'
                        }
                    }
                }
            }
        });

        // Pie Chart for Programs
        const pieChartCtx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pieChartCtx, {
            type: 'pie',
            data: {
                labels: @json($programsData->pluck('program.name')), // Using program name
                datasets: [{
                    label: 'Alumni by Program',
                    data: @json($programsData->pluck('total')),
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6', '#33FFF4'], // Add more colors if needed
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            }
        });
    </script>
</x-filament-widgets::widget>
