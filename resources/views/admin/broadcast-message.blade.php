<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-app-layout>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Broadcast Message to All Users') }}
                </h2>
                <a href="{{ route('admin.broadcast-history') }}" 
                   class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    View Message History
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <!-- Success/Error Messages -->
                        @if (session('success'))
                            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Broadcast Message Form -->
                        <form action="{{ route('admin.broadcast-message.send') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Recipient Selection -->
                            <div>
                                <label for="recipient_type" class="block mb-2 text-sm font-medium text-gray-700">
                                    Send Message To:
                                </label>
                                <select name="recipient_type" id="recipient_type" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="all">All Users (Admins and Therapists)</option>
                                    <option value="therapists">All Therapists Only</option>
                                    <option value="admins">All Admins Only</option>
                                </select>
                            </div>

                            <!-- Message Content -->
                            <div>
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-700">
                                    Message Content:
                                </label>
                                <textarea name="message" id="message" rows="6" required
                                          placeholder="Enter your broadcast message here..."
                                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('message') }}</textarea>
                            </div>

                            <!-- Preview Recipients -->
                            <div class="p-4 rounded-md bg-gray-50">
                                <h4 class="mb-2 text-sm font-medium text-gray-700">Message Preview:</h4>
                                <p class="text-sm text-gray-600" id="recipient-preview">
                                    This message will be sent to all users via the messaging system.
                                </p>
                                <p class="mt-2 text-xs text-gray-500">
                                    Recipients will receive this message in their Chatify messenger and will be able to reply to you directly.
                                </p>
                            </div>

                            <!-- Test Message Option -->
                            <div class="flex items-center">
                                <input type="checkbox" name="test_message" id="test_message" value="1"
                                       class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="test_message" class="block ml-2 text-sm text-gray-700">
                                    Send test message to myself only
                                </label>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('dashboard') }}" 
                                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Send Broadcast Message
                                </button>
                            </div>
                        </form>

                        <!-- Instructions -->
                        <div class="p-4 mt-8 rounded-md bg-blue-50">
                            <h4 class="mb-2 text-sm font-medium text-blue-800">How Broadcast Messaging Works:</h4>
                            <ul class="space-y-1 text-sm text-blue-700 list-disc list-inside">
                                <li>Messages are sent directly to users' Chatify messenger</li>
                                <li>Recipients can reply to you individually in their messenger</li>
                                <li>All messages appear in the regular chat interface with an "Admin" badge</li>
                                <li>Use "Test message" option to preview before sending to all users</li>
                                <li>Messages are delivered in real-time if users are online</li>
                                <li>Recipients will see an unread message notification</li>
                            </ul>
                        </div>

                        <!-- Quick Access -->
                        <div class="p-4 mt-4 rounded-md bg-gray-50">
                            <h4 class="mb-2 text-sm font-medium text-gray-800">Quick Access:</h4>
                            <div class="flex space-x-4">
                                <a href="/chatify" 
                                   class="text-sm text-indigo-600 underline hover:text-indigo-800">
                                    Open Messenger
                                </a>
                                <a href="{{ route('admin.broadcast-history') }}" 
                                   class="text-sm text-indigo-600 underline hover:text-indigo-800">
                                    View Message History
                                </a>
                                <a href="{{ route('admin.email-therapists') }}" 
                                   class="text-sm text-indigo-600 underline hover:text-indigo-800">
                                    Send Email Instead
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script>
        // Update recipient preview based on selection
        document.getElementById('recipient_type').addEventListener('change', function() {
            const preview = document.getElementById('recipient-preview');
            const value = this.value;
            
            switch(value) {
                case 'all':
                    preview.textContent = 'This message will be sent to all users (admins and therapists) via the messaging system.';
                    break;
                case 'therapists':
                    preview.textContent = 'This message will be sent to all therapists only via the messaging system.';
                    break;
                case 'admins':
                    preview.textContent = 'This message will be sent to all admin users only via the messaging system.';
                    break;
            }
        });
    </script>
</body>
</html>
