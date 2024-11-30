<x-filament-widgets::widget>
    <x-filament::section>
            @php
            $data=$this->getData();
            @endphp

            <div class="p-4 bg-white dark:bg-gray-900 shadow rounded-lg">
            <table class="table table-sm w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300"">User</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300"">Total Code</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300"">Kepuasan</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300"">Kepentingan</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300"">Korupsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['data'] as $row)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $row['user_name'] }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $row['total_codes'] }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ number_format($row['avg_kepuasan'], 2) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ number_format($row['avg_kepentingan'], 2) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ number_format($row['avg_korupsi'], 2) }}</td>
                    </tr>
                    @endforeach

                    <!-- Total Row -->
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300"><strong>Total</strong></td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300"></td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ number_format($data['total_kepuasan'], 2) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ number_format($data['total_kepentingan'], 2) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ number_format($data['total_korupsi'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
            </div>

    </x-filament::section>
</x-filament-widgets::widget>
