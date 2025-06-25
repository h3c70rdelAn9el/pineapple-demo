<x-app-layout>
    <x-main-container>
        <h2 class="mt-2 text-lg font-normal text-center">Email Therapists</h2>
        <div class="w-1/2 mx-auto mb-6 bg-gray-400 border-b border-gray-400"></div>

        @if (session('success'))
            <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="max-w-2xl mx-auto">
            <form action="{{ route('admin.email-therapists.send') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Subject -->
                <div>
                    <label for="subject" class="block mb-2 text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" 
                           id="subject" 
                           name="subject" 
                           value="{{ old('subject') }}"
                           class="w-full px-3 py-2 bg-gray-100 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                           required>
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="messagebody" class="block mb-2 text-sm font-medium text-gray-700">Message</label>
                    <textarea id="messagebody" 
                              name="messagebody" 
                              rows="8"
                              class="w-full px-3 py-2 bg-gray-100 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                              required>{{ old('messagebody') }}</textarea>
                    @error('messagebody')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Therapist Selection -->
                <div>
                    <label for="therapist_type" class="block mb-2 text-sm font-medium text-gray-700">Send To</label>
                    <select id="therapist_type" 
                            name="therapist_type"
                            class="w-full px-3 py-2 bg-gray-100 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                            required>
                        <option value="all" {{ old('therapist_type') == 'all' ? 'selected' : '' }}>All Therapists</option>
                        <option value="active" {{ old('therapist_type') == 'active' ? 'selected' : '' }}>Active Therapists Only</option>
                        <option value="inactive" {{ old('therapist_type') == 'inactive' ? 'selected' : '' }}>Inactive Therapists Only</option>
                    </select>
                    @error('therapist_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Test Email Section -->
                <div class="p-4 border border-yellow-200 rounded-md bg-yellow-50">
                    <h4 class="mb-2 text-sm font-medium text-yellow-800">Test Email Option</h4>
                    <p class="mb-3 text-sm text-blue-700">Send a test email to yourself first to preview how the email will look.</p>
                    <button type="submit" 
                            name="test_email" 
                            value="1"
                            style="background-color: #d97706 !important; color: white !important; border: none !important;"
                            class="px-6 py-2 text-white bg-yellow-600 rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 font-medium">
                        📧 Send Test Email to Me
                    </button>
                </div>

                <!-- Send to Therapists -->
                <div class="p-4 border border-blue-200 rounded-md bg-blue-50">
                    <h4 class="mb-2 text-sm font-medium text-blue-800">Send to Therapists</h4>
                    <p class="mb-3 text-sm text-blue-700">This will send the email to all selected therapists. Make sure to test first!</p>
                    <button type="submit" 
                            style="background-color: #2563eb !important; color: white !important; border: none !important;"
                            class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium"
                            onclick="return confirm('Are you sure you want to send this email to all selected therapists?')">
                        🚀 Send to Therapists
                    </button>
                </div>
            </form>
        </div>
    </x-main-container>
</x-app-layout>
