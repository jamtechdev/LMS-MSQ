<x-app-layout>
    <div class="py-6" x-data="{ tab: 'all' }">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-900 sm:rounded-lg">

                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manage All Questions</h2>
                    <a href="{{ route('admin.questions.create') }}"
                        class="inline-block px-4 py-2 text-sm font-medium text-white add-btn">
                        + Add Question
                    </a>
                </div>

                <!-- Tabs -->
                <div class="mb-4 space-x-2">
                    <button @click="tab = 'all'" :class="{ 'bg-blue-700 text-white': tab === 'all' }"
                        class="px-4 py-2 text-sm font-semibold text-gray-800 bg-white border rounded hover:bg-blue-100">
                        All
                    </button>
                    <button @click="tab = 'mcq'" :class="{ 'bg-blue-700 text-white': tab === 'mcq' }"
                        class="px-4 py-2 text-sm font-semibold text-gray-800 bg-white border rounded hover:bg-blue-100">
                        MCQ
                    </button>
                    <button @click="tab = 'fill_blank'" :class="{ 'bg-blue-700 text-white': tab === 'fill_blank' }"
                        class="px-4 py-2 text-sm font-semibold text-gray-800 bg-white border rounded hover:bg-blue-100">
                        Fill in the Blank
                    </button>
                    <button @click="tab = 'true_false'" :class="{ 'bg-blue-700 text-white': tab === 'true_false' }"
                        class="px-4 py-2 text-sm font-semibold text-gray-800 bg-white border rounded hover:bg-blue-100">
                        True / False
                    </button>
                    <button @click="tab = 'linking'" :class="{ 'bg-blue-700 text-white': tab === 'linking' }"
                        class="px-4 py-2 text-sm font-semibold text-gray-800 bg-white border rounded hover:bg-blue-100">
                        Linking
                    </button>
                </div>

                <!-- Table -->
                <div class="w-full overflow-x-scroll">
                    <table class="w-full text-sm text-left divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-800">
                            <tr>
                                <th class="w-1/12 px-4 py-3 font-medium text-white">#</th>
                                <th class="w-3/12 px-4 py-3 font-medium text-white">Question</th>
                                <th class="w-1/12 px-4 py-3 font-medium text-white">Type</th>
                                <th class="w-2/12 px-4 py-3 font-medium text-white">Level</th>
                                <th class="w-2/12 px-4 py-3 font-medium text-white">Subject</th>
                                <th class="w-3/12 px-4 py-3 font-medium text-white">Options</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 dark:divide-gray-800 dark:bg-gray-900">
                            @forelse ($questions as $index => $question)
                                <tr x-show="tab === 'all' || tab === '{{ $question->type }}'">
                                    <td class="px-4 py-3 text-gray-900 whitespace-normal dark:text-gray-100">
                                        <div class="overflow-y-auto max-h-48">
                                            {{ $index + 1 }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-900 whitespace-normal dark:text-gray-100">
                                        <div class="overflow-y-auto max-h-48">
                                             {!! $question->content !!}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-900 capitalize dark:text-gray-100">
                                        {{ str_replace('_', ' ', $question->type) }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-900 whitespace-normal dark:text-gray-100">
                                        <div class="overflow-y-auto max-h-48">
                                            {{ $question->level->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-900 whitespace-normal dark:text-gray-100">
                                        <div class="overflow-y-auto max-h-48">
                                            {{ $question->subject->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-900 whitespace-normal dark:text-gray-100">
                                        <div class="overflow-y-auto max-h-48">
                                            <!-- MCQ -->
                                            @if ($question->type === 'mcq')
                                                <label class="block mb-2 font-semibold text-yellow-700">Options</label>
                                                <ul class="list-disc list-inside h-[100px] overflow-y-scroll">
                                                    @foreach ($question->options as $option)
                                                        <li>
                                                            {{ $option->value }}. {{ $option->text }}
                                                            @if ($option->is_correct)
                                                                <span
                                                                    class="font-semibold text-green-500">(Correct)</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            <!-- True/False -->
                                            @elseif ($question->type === 'true_false')
                                                @php $correct = $question->metadata['answer']['choice'] ?? null; @endphp
                                                <label class="block mb-2 font-semibold text-yellow-700">True / False</label>
                                                <ul class="list-disc list-inside h-[100px] overflow-y-scroll">
                                                    <li
                                                        class="{{ $correct === 'True' ? 'text-green-600 font-bold' : '' }}">
                                                        True @if ($correct === 'True')
                                                            (Correct)
                                                        @endif
                                                    </li>
                                                    <li
                                                        class="{{ $correct === 'False' ? 'text-green-600 font-bold' : '' }}">
                                                        False @if ($correct === 'False')
                                                            (Correct)
                                                        @endif
                                                    </li>
                                                </ul>

                                            <!-- Fill in the Blank -->
                                            @elseif ($question->type === 'fill_blank')
                                                <label class="block mb-2 font-semibold text-yellow-700">Fill in the Blanks</label>
                                                @foreach ($question->metadata['blanks'] ?? [] as $blank)
                                                    <div class="mb-2">
                                                        <span class="text-sm font-medium">
                                                            Blank {{ $blank['blank_number'] ?? 'N/A' }}:
                                                        </span>
                                                        <ul class="ml-4 list-disc list-inside h-[100px] overflow-y-scroll">
                                                            @foreach ($blank['options'] as $option)
                                                                <li>
                                                                    {{ $option }}
                                                                    @if ($option === $blank['answer'])
                                                                        <span class="font-semibold text-green-600">(Correct)</span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endforeach

                                            <!-- Linking -->
                                            @elseif ($question->type === 'linking')
                                                <label class="block mb-2 font-semibold text-yellow-700">Match the Following</label>
                                                @if (!empty($question->metadata['answer']))
                                                    <div class="space-y-4 h-[180px] overflow-y-scroll">
                                                        @foreach ($question->metadata['answer'] as $pair)
                                                            <div
                                                                class="flex items-center justify-between p-3 bg-white border shadow rounded-xl">
                                                                <div class="flex items-center w-5/12 space-x-3">
                                                                    @if ($pair['left']['match_type'] === 'image' && $pair['left']['image_uri'])
                                                                        <img src="{{ $pair['left']['image_uri'] }}"
                                                                            class="object-cover border rounded-md w-14 h-14" />
                                                                    @endif
                                                                    @if (!empty($pair['left']['word']))
                                                                        <span class="text-sm font-medium text-gray-800">{{ $pair['left']['word'] }}</span>
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    class="hidden w-2/12 text-xl font-bold text-center text-yellow-600 sm:block">
                                                                    →
                                                                </div>
                                                                <div
                                                                    class="flex items-center justify-end w-5/12 space-x-3 sm:justify-start">
                                                                    @if ($pair['right']['match_type'] === 'image' && $pair['right']['image_uri'])
                                                                        <img src="{{ $pair['right']['image_uri'] }}"
                                                                            class="object-cover border rounded-md w-14 h-14" />
                                                                    @endif
                                                                    @if (!empty($pair['right']['word']))
                                                                        <span class="text-sm font-medium text-gray-800">{{ $pair['right']['word'] }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="italic text-gray-400">No matching pairs available</p>
                                                @endif

                                            <!-- Comprehension -->
                                            @elseif ($question->type === 'comprehension')
                                                <label class="block mb-2 font-semibold text-yellow-700">Comprehension Questions</label>
                                                @foreach ($question->metadata['comprehension'] ?? [] as $comp)
                                                    <div class="p-3 mb-4 border rounded bg-gray-50 dark:bg-gray-800">
                                                        <p class="mb-2 font-medium text-gray-700 dark:text-gray-300">
                                                            {{ $comp['question_name'] }}</p>
                                                        @foreach ($comp['blanks'] ?? [] as $blank)
                                                            <div class="mb-2">
                                                                <span class="text-sm font-semibold">Blank {{ $blank['blank_number'] }} Options:</span>
                                                                <ul class="ml-4 list-disc list-inside max-h-[100px] overflow-y-auto">
                                                                    @foreach ($blank['options'] as $option)
                                                                        <li>
                                                                            {{ $option }}
                                                                            @if ($option === $blank['answer'])
                                                                                <span class="font-semibold text-green-600">(Correct)</span>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                        No questions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
