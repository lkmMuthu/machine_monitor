<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> Machine Monitor</title>
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .fade-anim { transition: all 0.5s ease; }
        </style>
    </head>
    <body class="bg-background text-primary flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
      
        <h2 class="text-primary px-6 py-4 mb-8" style="text-align: center; display: flex; align-items: center; justify-content: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="30px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" style="margin-right: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.652a3.75 3.75 0 0 1 0-5.304m5.304 0a3.75 3.75 0 0 1 0 5.304m-7.425 2.121a6.75 6.75 0 0 1 0-9.546m9.546 0a6.75 6.75 0 0 1 0 9.546M5.106 18.894c-3.808-3.807-3.808-9.98 0-13.788m13.788 0c3.808 3.807 3.808 9.98 0 13.788M12 12h.008v.008H12V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            Factory Floor Monitor (Live)
        </h2>
  
       
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-4 px-6 font-semibold uppercase text-sm">Machine Name</th>
                        <th class="py-4 px-6 font-semibold uppercase text-sm">State</th>
                    </tr>
                </thead>
                <tbody id="machine-list">
                    @foreach(['Machine A', 'Machine B', 'Machine C'] as $machine)
                    <tr id="row-{{ Str::slug($machine) }}" class="border-b border-gray-100">
                        <td class="py-4 px-6 font-medium text-gray-700">{{ $machine }}</td>
                        <td class="py-4 px-6">
                            <span class="state-badge px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200 fade-anim">
                                IDLE
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-8 text-gray-400 text-sm">
            <div class="mb-2">
                Status: <span id="connection-status" class="text-orange-500 font-bold">Connecting...</span>
            </div>
            <div>
                Run: <code class="bg-gray-100 px-2 py-1 rounded text-xs">php artisan app:start-production</code>
            </div>
        </div>
       
        <script>
        console.log("Listening for machine updates...");
        const stateColors = @json($stateColors);
        const checkEcho = setInterval(() => {
            if (window.Echo) {
                clearInterval(checkEcho);
                console.log("Echo loaded, setting up connection monitoring");
                setupConnectionMonitoring();
                startListening();
            }
        }, 100);

        function setupConnectionMonitoring() {
            const pusher = window.Echo.connector.pusher.connection;
            pusher.bind('connected', () => {
                updateConnectionStatus('Connected via Reverb', 'text-green-600 font-bold');
            });
            pusher.bind('connecting', () => {
                updateConnectionStatus('Connecting...', 'text-orange-500 font-bold');
            });
            pusher.bind('disconnected', () => {
                updateConnectionStatus('Disconnected', 'text-red-600 font-bold');
            });
            pusher.bind('unavailable', () => {
                updateConnectionStatus('Unavailable', 'text-red-600 font-bold');
            });
            pusher.bind('failed', () => {
                updateConnectionStatus('Connection Failed', 'text-red-600 font-bold');
            });
            // Initial status
            const initialState = pusher.state;
            switch(initialState) {
                case 'connected':
                    updateConnectionStatus('Connected via Reverb', 'text-green-600 font-bold');
                    break;
                case 'connecting':
                    updateConnectionStatus('Connecting...', 'text-orange-500 font-bold');
                    break;
                case 'disconnected':
                    updateConnectionStatus('Disconnected', 'text-red-600 font-bold');
                    break;
                default:
                    updateConnectionStatus('Initializing...', 'text-gray-500 font-bold');
            }
        }

        function updateConnectionStatus(text, className) {
            document.getElementById('connection-status').innerText = text;
            document.getElementById('connection-status').className = className;
        }

        function startListening() {
            window.Echo.channel('machine-state-updated')
                .listen('MachineStateUpdated', (e) => {
                    console.log('Update:', e);
                    updateDashboard(e.machineName, e.newState);
                });
        }

        // update for create machine rows dynamically
        function updateDashboard(name, state) {
            const slug = name.toLowerCase().replace(/ /g, '-');
            let row = document.getElementById(`row-${slug}`);
        
            if (!row) {
                const tbody = document.getElementById('machine-list');
                const newRowHtml = `
                    <tr id="row-${slug}" class="border-b border-gray-100 fade-in">
                        <td class="py-4 px-6 font-medium text-gray-700">${name}</td>
                        <td class="py-4 px-6">
                            <span class="state-badge px-3 py-1 rounded-full text-xs font-bold border fade-anim">
                                ${state}
                            </span>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', newRowHtml);
                row = document.getElementById(`row-${slug}`);
            }

            // Update the badge style and text
            const badge = row.querySelector('.state-badge');
            badge.textContent = state;
            badge.className = 'state-badge px-3 py-1 rounded-full text-xs font-bold border fade-anim';
            badge.style.backgroundColor = stateColors[state];
            badge.style.color = '#fff';
            badge.style.borderColor = stateColors[state];
        }
    </script>
    </body>
</html>
