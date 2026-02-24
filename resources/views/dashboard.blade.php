<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Queue Monitor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100">
    <div id="app">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-4xl font-bold mb-8 text-gray-800">Queue Monitor</h1>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600 mb-1">Total</div>
                    <div class="text-3xl font-bold text-gray-800">@{{ stats.total }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600 mb-1">Processed</div>
                    <div class="text-3xl font-bold text-green-600">@{{ stats.processed }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600 mb-1">Failed</div>
                    <div class="text-3xl font-bold text-red-600">@{{ stats.failed }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600 mb-1">Processing</div>
                    <div class="text-3xl font-bold text-blue-600">@{{ stats.processing }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600 mb-1">Avg Runtime</div>
                    <div class="text-3xl font-bold text-purple-600">@{{ stats.avg_runtime_ms }}ms</div>
                </div>
            </div>

            <!-- Controls -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-2xl font-bold mb-4">Queue Controls</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Connection</label>
                        <input v-model="controlForm.connection" type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="database">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Queue</label>
                        <input v-model="controlForm.queue" type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="default">
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button @click="pauseQueue" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                        Pause
                    </button>
                    <button @click="resumeQueue" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Resume
                    </button>
                    <button @click="retryQueue" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Retry Failed
                    </button>
                    <div class="flex gap-2">
                        <input v-model="controlForm.throttleRate" type="number" class="border border-gray-300 rounded px-3 py-2 w-24" placeholder="60">
                        <button @click="throttleQueue" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded">
                            Throttle (jobs/min)
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Jobs Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold">Recent Jobs</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Queue</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Runtime</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Started</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="job in jobs" :key="job.id">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">@{{ job.id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">@{{ job.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">@{{ job.queue }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="statusClass(job.status)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        @{{ job.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">@{{ job.runtime_ms ? job.runtime_ms + 'ms' : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">@{{ formatDate(job.started_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    stats: {
                        total: 0,
                        processed: 0,
                        failed: 0,
                        processing: 0,
                        avg_runtime_ms: 0
                    },
                    jobs: [],
                    controlForm: {
                        connection: 'database',
                        queue: 'default',
                        throttleRate: 60
                    }
                }
            },
            mounted() {
                this.fetchStats();
                this.fetchJobs();

                // Auto-refresh
                setInterval(() => {
                    this.fetchStats();
                    this.fetchJobs();
                }, {{ config('queue-monitor.ui.refresh_seconds', 10) * 1000 }});
            },
            methods: {
                async fetchStats() {
                    try {
                        const response = await axios.get('{{ route('queue-monitor.stats') }}');
                        this.stats = response.data;
                    } catch (error) {
                        console.error('Failed to fetch stats:', error);
                    }
                },
                async fetchJobs() {
                    try {
                        const response = await axios.get('{{ route('queue-monitor.jobs') }}');
                        this.jobs = response.data.jobs;
                    } catch (error) {
                        console.error('Failed to fetch jobs:', error);
                    }
                },
                async pauseQueue() {
                    try {
                        await axios.post('{{ route('queue-monitor.control.pause') }}', this.controlForm);
                        alert('Queue paused successfully');
                    } catch (error) {
                        alert('Failed to pause queue');
                    }
                },
                async resumeQueue() {
                    try {
                        await axios.post('{{ route('queue-monitor.control.resume') }}', this.controlForm);
                        alert('Queue resumed successfully');
                    } catch (error) {
                        alert('Failed to resume queue');
                    }
                },
                async throttleQueue() {
                    try {
                        await axios.post('{{ route('queue-monitor.control.throttle') }}', {
                            ...this.controlForm,
                            rate: this.controlForm.throttleRate
                        });
                        alert('Queue throttled successfully');
                    } catch (error) {
                        alert('Failed to throttle queue');
                    }
                },
                async retryQueue() {
                    try {
                        await axios.post('{{ route('queue-monitor.control.retry') }}', this.controlForm);
                        alert('Retrying failed jobs');
                    } catch (error) {
                        alert('Failed to retry jobs');
                    }
                },
                statusClass(status) {
                    const classes = {
                        'processed': 'bg-green-100 text-green-800',
                        'failed': 'bg-red-100 text-red-800',
                        'processing': 'bg-blue-100 text-blue-800'
                    };
                    return classes[status] || 'bg-gray-100 text-gray-800';
                },
                formatDate(date) {
                    return date ? new Date(date).toLocaleString() : '-';
                }
            }
        }).mount('#app');
    </script>
</body>
</html>

