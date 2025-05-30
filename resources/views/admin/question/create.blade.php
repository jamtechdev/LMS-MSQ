<x-app-layout>
    <div class="max-w-full p-10 mx-auto bg-white border border-gray-200 shadow-[0_8px_30px_rgba(55,55, 55, / 10%)] rounded-3xl"
        x-data="questionForm()" x-cloak style="font-family: 'Inter', sans-serif;">
        <h1 class="mb-10 text-3xl font-bold text-left text-black-500 drop-shadow-[0_8px_30px_rgba(55,55, 55, / 10%]">
            Create New Question
        </h1>
        <!-- Progress Bar -->
        <div class="w-full h-4 mb-12 overflow-hidden bg-gray-200 rounded-full">
            <div class="h-full transition-all duration-500 ease-in-out rounded-full bg-gradient-to-r from-blue-600 to-blue-800"
                :style="`width: ${(step / 5) * 100}%`"></div>
        </div>

        <!-- Step 1: Education Type -->
        <template x-if="step === 1">
            <div class="space-y-6 text-center">
                <h2 class="text-3xl font-semibold text-blue-700">Select Education Type</h2>
                <div class="flex justify-center gap-6">
                    <template x-for="type in ['primary', 'secondary']">
                        <button type="button"
                            class="w-40 px-8 py-4 font-medium transition-all duration-300 shadow-lg text-md rounded-2xl hover:scale-105 hover:shadow-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-300"
                            :class="educationType === type ?
                                'bg-gray-200 text-gray-400 border-1 border-gray-200 shadow-gray-500' :
                                'bg-blue-50 text-gray-700 border border-gray-200'"
                            @click="selectEducationType(type)" x-text="type.charAt(0).toUpperCase() + type.slice(1)">
                        </button>
                    </template>
                </div>
            </div>
        </template>

        <!-- Step 2: Levels -->
        <template x-if="step === 2">
            <div class="space-y-6 text-center">
                <h2 class="text-3xl font-semibold text-blue-700">Select Level</h2>
                <div class="flex flex-wrap justify-center gap-6">
                    <template x-for="level in levels" :key="level.id">
                        <button
                            class="px-6 py-3 text-lg font-medium transition duration-300 transform shadow-md w-44 rounded-xl hover:scale-105 hover:bg-blue-50 hover:shadow-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-300"
                            :class="selectedLevel === level.name ?
                                'bg-gray-200 text-gray-400 border-1 border-gray-200 shadow-gray-500' :
                                'bg-blue-50 text-gray-700 border border-gray-200'"
                            @click="selectLevel(level.name)" x-text="level.name">
                        </button>
                    </template>
                </div>
                <button type="button" class="p-3 mt-8 text-white bg-blue-600 rounded-md hover:text-white"
                    @click="step = 1">
                    ← Back
                </button>
            </div>
        </template>

        <!-- Step 3: Subjects -->
        <template x-if="step === 3">
            <div class="space-y-6 text-center">
                <h2 class="text-3xl font-semibold text-blue-700">Select Subject</h2>
                <div class="flex flex-wrap justify-center gap-6">
                    <template x-for="subject in subjects" :key="subject.id">
                        <button
                            class="px-6 py-3 text-lg font-medium transition duration-300 transform shadow-md w-44 rounded-xl hover:scale-105 hover:bg-blue-50 hover:shadow-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-300"
                            :class="selectedSubject?.id === subject.id ?
                                'bg-gray-200 text-gray-400 border-1 border-gray-200 shadow-gray-500' :
                                'bg-blue-50 text-gray-700 border border-gray-200'"
                            @click="selectSubject(subject)" x-text="subject.name">
                        </button>
                    </template>
                </div>
                <button type="button" class="p-3 mt-8 text-white bg-blue-600 rounded-md hover:text-white"
                    @click="step = 2">
                    ← Back
                </button>
            </div>
        </template>

        <!-- Step 4: Question Type -->
        <template x-if="step === 4">
            <div class="space-y-6 text-center">
                <h2 class="text-3xl font-semibold text-blue-700">Select Question Type</h2>
                <div class="flex flex-wrap justify-center gap-4 mx-auto">
                    <template x-for="type in questionTypes" :key="type">
                        <button
                            class="px-5 py-3 text-lg font-medium capitalize transition duration-300 transform shadow-md w-44 rounded-xl hover:scale-105 hover:bg-blue-50 hover:shadow-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-50"
                            :class="questionType === type ?
                                'bg-gray-200 text-gray-400 border-1 border-gray-200 shadow-gray-500' :
                                'bg-blue-50 text-gray-700 border border-gray-200'"
                            @click="selectQuestionType(type)" x-text="type.replace('_', ' ')">
                        </button>
                    </template>
                </div>
                <button type="button" class="p-3 mt-8 text-white bg-blue-600 rounded-md hover:text-white"
                    @click="step = 3">
                    ← Back
                </button>
            </div>
        </template>

        <!-- Step 5: Question Form -->
        <form method="POST" action="{{ route('admin.questions.store') }}" x-show="step === 5" x-transition
            @submit.prevent="submitForm" class="mt-12 space-y-8" enctype="multipart/form-data">
            @csrf

            <!-- Hidden Inputs -->
            <input type="hidden" name="question_data[education_type]" :value="educationType">
            <input type="hidden" name="question_data[level_id]" :value="selectedLevelId">
            <input type="hidden" name="question_data[subject_id]" :value="selectedSubject?.id">
            <input type="hidden" name="question_data[type]" :value="questionType">

            <!-- Question Content -->
            {{-- <div>
                <label class="block mb-3 text-lg font-semibold text-blue-700">Question Content</label>
                <textarea x-model="questionContent" name="question_data[content]" rows="4"
                    class="w-full p-4 border-2 border-blue-300 shadow-sm rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-200"
                    x-ref="questionContent" required></textarea>
            </div> --}}
            <div>
                <div x-ref="questionContentEditor"
                    class="border-2 border-blue-300 shadow-sm quill-editor focus:ring-4 focus:ring-blue-200"
                    style="min-height: 150px;">
                </div>
                <!-- Moved input outside the Quill container -->
                <input type="hidden" name="question_data[content]" :value="questionContent" x-model="questionContent">
            </div>


            <!-- Type Specific Sections -->
            <template x-if="questionType === 'mcq'">
                <div>
                    <label class="block mb-3 text-lg font-semibold text-blue-700">MCQ Options</label>
                    <template x-for="(option, index) in options" :key="index">
                        <div
                            class="flex items-center gap-4 p-3 mb-4 transition border-2 border-blue-200 rounded-xl hover:border-blue-400">
                            <input type="radio" :name="'question_data[correct_option]'" :value="index"
                                class="w-6 h-6 accent-blue-500" @change="setCorrect(index)"
                                :checked="option.is_correct" required>
                            <input type="text" :name="'question_data[options][' + index + ']'"
                                x-model="option.value" placeholder="Option text"
                                class="flex-1 p-3 text-lg border rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-200"
                                required>
                            <button type="button" class="text-sm font-semibold text-red-600 hover:text-red-800"
                                @click="removeOption(index)" x-show="options.length > 2"
                                title="Remove Option">✕</button>
                        </div>
                    </template>
                    <button type="button"
                        class="px-5 py-2 font-semibold text-blue-800 transition bg-blue-200 rounded-xl hover:bg-blue-300"
                        @click="addOption">+ Add Option</button>

                        {{-- x-show="options.length < 6" --}}
                </div>
            </template>

            <!-- FILL IN THE BLANK TEMPLATE -->
            <template x-if="questionType === 'fill_blank'">
                <div>
                    <template x-for="(blank, index) in blanks" :key="index">
                        <div
                            class="p-6 mb-6 transition border-2 border-blue-200 shadow-inner rounded-xl bg-blue-50 hover:shadow-blue-200">
                            <input type="hidden" :name="'question_data[blanks][' + index + '][blank_number]'"
                                :value="blank.blank_number">

                            <p class="mb-3 text-lg font-semibold text-blue-700">Blank <span
                                    x-text="blank.blank_number"></span> Options:</p>
                            <button type="button" class="mb-4 text-sm font-bold text-blue-600 hover:text-blue-800"
                                @click="addBlankOption(index)">
                                + Add Option
                            </button>
                            {{-- <template x-for="(option, optIndex) in blank.options" :key="optIndex">
                                <input type="text"
                                    class="w-full p-3 mb-3 text-lg border rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-200"
                                    :name="'question_data[blanks][' + index + '][options][' + optIndex + ']'"
                                    x-model="blank.options[optIndex]" required />
                            </template> --}}
                            <template x-for="(option, optIndex) in blank.options" :key="optIndex">
                                <div class="relative mb-3">
                                    <input type="text"
                                        class="w-full p-3 text-lg border rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-200"
                                        :name="'question_data[blanks][' + index + '][options][' + optIndex + ']'"
                                        x-model="blank.options[optIndex]" required />

                                    <button type="button"
                                        class="absolute text-red-500 transform -translate-y-1/2 top-1/2 right-3 hover:text-red-700"
                                        @click="removeBlankOption(index, optIndex)"
                                        x-show="blank.options.length > 1">✕</button>
                                </div>
                            </template>


                            <label class="block mt-4 mb-2 text-lg font-semibold text-blue-700">Correct Answer:</label>
                            <select
                                class="w-full p-3 text-lg border rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-200"
                                :name="'question_data[blanks][' + index + '][answer]'" x-model="blank.answer"
                                required>
                                <option value="" disabled>Select correct answer</option>
                                <template x-for="opt in blank.options">
                                    <option x-text="opt" :value="opt"></option>
                                </template>
                            </select>

                            <button type="button" class="mt-4 font-semibold text-red-600 hover:text-red-800"
                                @click="removeBlank(index)">Remove Blank</button>
                        </div>
                    </template>

                    <button type="button"
                        class="px-6 py-2 font-semibold text-blue-800 transition bg-blue-200 rounded-xl hover:bg-blue-300"
                        @click="addBlank">+ Add Blank</button>
                </div>
            </template>

            {{-- true false  --}}
            <template x-if="questionType === 'true_false'">
                <div>
                    <label class="block mb-3 text-lg font-semibold text-blue-700">Answer</label>
                    <select name="question_data[true_false_answer]"
                        class="w-full p-3 text-lg border rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-200"
                        x-model="trueFalseAnswer" required>
                        <option value="True">True</option>
                        <option value="False">False</option>
                    </select>
                </div>
            </template>

            {{-- Linking --}}
            <template x-if="questionType === 'linking'">
                <div class="space-y-4">
                    <x-input-label value="Matching Pairs" class="mb-4 text-lg font-semibold text-blue-700" />

                    <template x-for="(option, index) in linkingOptions" :key="index">
                        <div
                            class="relative flex flex-col gap-4 p-3 transition-shadow duration-200 border-2 border-blue-200 rounded-xl bg-blue-50 hover:shadow-blue-200">
                            <button type="button" class="absolute text-red-600 top-2 right-2 hover:text-red-800"
                                @click="linkingOptions.splice(index, 1)">✕</button>

                            <div class="flex flex-col md:flex-row md:space-x-6">
                                <!-- Left Label -->
                                <div class="flex-1">
                                    <div class="mb-1">
                                        <span class="font-medium text-blue-700">Left (Label):</span>
                                        <label class="ml-2 text-sm">
                                            <input type="radio"
                                                :name="'question_data[options][' + index + '][label_type]'"
                                                value="text" x-model="option.label_type"> Text
                                        </label>
                                        <label class="ml-2 text-sm">
                                            <input type="radio"
                                                :name="'question_data[options][' + index + '][label_type]'"
                                                value="image" x-model="option.label_type"> Image
                                        </label>
                                    </div>

                                    <template x-if="option.label_type === 'text'">
                                        <input type="text"
                                            class="w-full p-3 border-2 border-blue-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-200"
                                            x-model="option.label_text"
                                            :name="'question_data[options][' + index + '][label_text]'"
                                            placeholder="Label Text">
                                    </template>

                                    <template x-if="option.label_type === 'image'">
                                        <div class="space-y-1">
                                            <input type="file" accept="image/*"
                                                :name="'question_data[options][' + index + '][label_image]'"
                                                @change="previewFile($event, option, 'label')" />
                                            <img x-show="option.label_preview" :src="option.label_preview"
                                                class="object-cover w-16 h-16 rounded">
                                        </div>
                                    </template>
                                </div>

                                <!-- Right Value -->
                                <div class="flex-1">
                                    <div class="mb-1">
                                        <span class="font-medium text-blue-700">Right (Value):</span>
                                        <label class="ml-2 text-sm">
                                            <input type="radio"
                                                :name="'question_data[options][' + index + '][value_type]'"
                                                value="text" x-model="option.value_type"> Text
                                        </label>
                                        <label class="ml-2 text-sm">
                                            <input type="radio"
                                                :name="'question_data[options][' + index + '][value_type]'"
                                                value="image" x-model="option.value_type"> Image
                                        </label>
                                    </div>

                                    <template x-if="option.value_type === 'text'">
                                        <input type="text"
                                            class="w-full p-3 border-2 border-blue-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-200"
                                            x-model="option.value_text"
                                            :name="'question_data[options][' + index + '][value_text]'"
                                            placeholder="Value Text">
                                    </template>

                                    <template x-if="option.value_type === 'image'">
                                        <div class="space-y-1">
                                            <input type="file" accept="image/*"
                                                :name="'question_data[options][' + index + '][value_image]'"
                                                @change="previewFile($event, option, 'value')" />
                                            <img x-show="option.value_preview" :src="option.value_preview"
                                                class="object-cover w-16 h-16 rounded">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                    <button type="button"
                        class="px-6 py-2 font-semibold text-blue-800 transition bg-blue-200 rounded-xl hover:bg-blue-300"
                        @click="addLinkingOption()">
                        + Add Match
                    </button>
                </div>
            </template>

            <!-- Rearranging question template -->
            <template x-if="questionType === 'rearranging'">
                <div class="space-y-4">
                    <label class="block text-lg font-semibold text-blue-700">
                        Question Instruction
                    </label>
                    <input type="text" name="question_data[question_text]"
                        class="w-full p-3 border rounded-lg focus:ring-4 focus:ring-blue-200"
                        placeholder="e.g., Rearrange to form a sentence." required>

                    <label class="block mt-4 text-lg font-semibold text-blue-700">
                        Correct Word/Phrase Order
                    </label>

                    <!-- Dynamic input fields for correct answer order -->
                    <template x-for="(item, index) in rearrangingItems" :key="index">
                        <div class="relative mb-3">
                            <input type="text" :name="'question_data[rearranging][answer][' + index + ']'"
                                x-model="rearrangingItems[index]"
                                class="w-full p-3 border rounded-lg focus:ring-4 focus:ring-blue-200"
                                placeholder="Word or phrase" required>
                            <button type="button"
                                class="absolute text-red-500 -translate-y-1/2 right-3 top-1/2 hover:text-red-700"
                                @click="removeRearrangingItem(index)" x-show="rearrangingItems.length > 1"
                                aria-label="Remove item">
                                ✕
                            </button>
                        </div>
                    </template>

                    <!-- Add item button -->
                    <button type="button" class="px-4 py-2 bg-blue-200 rounded-lg hover:bg-blue-300"
                        @click="addRearrangingItem()">
                        + Add Item
                    </button>

                    <!-- Preview correct answer (optional) -->
                    <div class="mt-4">
                        <label class="text-sm text-gray-600">Preview:</label>
                        <div class="p-3 mt-1 bg-gray-100 rounded-lg">
                            <span x-text="rearrangingItems.join(' ')"></span>
                        </div>
                    </div>
                </div>
            </template>

            {{-- comprehension --}}

            <template x-if="questionType === 'comprehension'">
                <div>
                    <template x-for="(cq, qIndex) in comprehensionQuestions" :key="qIndex">
                        <div class="p-4 mb-6 border rounded-lg bg-gray-50">
                            <label class="block text-lg font-semibold">Question <span
                                    x-text="qIndex + 1"></span>:</label>
                            <textarea x-ref="compTextarea" :name="'question_data[comprehension][' + qIndex + '][question_name]'"
                                x-model="cq.question"
                                class="w-full p-3 mb-4 text-lg border rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-200"
                                placeholder="Enter question..."></textarea>


                            <!-- Blanks Section -->
                            <template x-for="(blank, bIndex) in cq.blanks" :key="bIndex">
                                <div class="p-4 mb-4 border-2 border-blue-200 shadow-inner rounded-xl bg-blue-50">
                                    <input type="hidden"
                                        :name="'question_data[comprehension][' + qIndex + '][blanks][' + bIndex +
                                            '][blank_number]'"
                                        :value="blank.blank_number" />

                                    <p class="mb-2 font-semibold text-blue-700">Blank <span
                                            x-text="blank.blank_number"></span> Options:</p>
                                    <button type="button"
                                        class="mb-2 text-sm font-bold text-blue-600 hover:text-blue-800"
                                        @click="addComprehensionBlankOption(qIndex, bIndex)">
                                        + Add Option
                                    </button>

                                    <template x-for="(opt, optIndex) in blank.options" :key="optIndex">
                                        <div class="relative mb-2">
                                            <input type="text"
                                                class="w-full p-2 text-lg border rounded focus:outline-none focus:ring-4 focus:ring-blue-200"
                                                :name="'question_data[comprehension][' + qIndex + '][blanks][' + bIndex +
                                                    '][options][' + optIndex + ']'"
                                                x-model="blank.options[optIndex]" required />

                                            <button type="button"
                                                class="absolute text-red-500 transform -translate-y-1/2 right-2 top-1/2 hover:text-red-700"
                                                @click="removeComprehensionBlankOption(qIndex, bIndex, optIndex)"
                                                x-show="blank.options.length > 1">✕</button>
                                        </div>
                                    </template>

                                    <label class="block mt-3 mb-1 font-semibold text-blue-700">Correct Answer:</label>
                                    <select
                                        class="w-full p-2 text-lg border rounded focus:outline-none focus:ring-4 focus:ring-blue-200"
                                        :name="'question_data[comprehension][' + qIndex + '][blanks][' + bIndex + '][answer]'"
                                        x-model="blank.answer" required>
                                        <option value="" disabled>Select correct answer</option>
                                        <template x-for="opt in blank.options">
                                            <option :value="opt" x-text="opt"></option>
                                        </template>
                                    </select>

                                    <button type="button" class="mt-3 font-semibold text-red-600 hover:text-red-800"
                                        @click="removeComprehensionBlank(qIndex, bIndex)">
                                        Remove Blank
                                    </button>
                                </div>
                            </template>

                            <!-- Allow only one blank before showing add question -->
                            <template x-if="cq.blanks.length === 0">
                                <button type="button" @click="addComprehensionBlank(qIndex)"
                                    class="px-4 py-2 font-semibold text-blue-800 bg-blue-200 rounded-xl hover:bg-blue-300">
                                    + Add Blank
                                </button>
                            </template>

                        </div>
                    </template>

                    <!-- Show "Add Question" button only if the last question has at least 1 blank -->
                    <template
                        x-if="comprehensionQuestions.length === 0 || comprehensionQuestions[comprehensionQuestions.length - 1].blanks.length > 0">
                        <button type="button"
                            class="px-4 py-2 font-semibold text-green-700 bg-green-200 rounded-xl hover:bg-green-300"
                            @click="addComprehensionQuestion">
                            + Add Question
                        </button>
                    </template>
                </div>
            </template>

            {{-- Grouped --}}
            <template x-if="questionType === 'grouped'">

            </template>


            <div class="flex justify-between mt-12">
                <button type="button" @click="step = 4"
                    class="px-8 py-3 text-lg font-semibold text-blue-600 transition border-2 border-blue-400 rounded-xl hover:bg-blue-100">
                    ← Back
                </button>
                <button type="submit"
                    class="px-10 py-3 text-lg font-extrabold text-white transition bg-blue-600 shadow-lg rounded-3xl hover:bg-blue-700">
                    Save Question
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

<script>
    function questionForm() {
        return {

            // Existing properties
            quill: null,
            questionContent: '',

            //...

            init() {
                const editor = this.$refs.questionContentEditor;
                this.quill = new Quill(editor, {
                    theme: 'snow',
                    placeholder: 'Type your question...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            ['clean']
                        ]
                    }
                });

                this.quill.on('text-change', () => {
                    this.questionContent = this.quill.root.innerHTML;
                });
            },

            step: 1,
            selectedLevel: '',
            educationType: '',
            selectedLevelId: '',
            levelsByType: @json($levels),
            levels: [],
            subjects: [],
            selectedSubject: null,
            questionTypes: ['mcq', 'fill_blank', 'true_false', 'linking', 'rearranging', 'comprehension'],
            questionType: '',

            blanks: [],

            // Other question type data
            trueFalseAnswer: 'True',
            linkingPairs: [{
                label: '',
                value: ''
            }, {
                label: '',
                value: ''
            }],
            spellingAnswer: '',
            mathAnswer: '',

            selectEducationType(type) {
                this.educationType = type;
                this.levels = this.levelsByType[type] || [];
                this.step = 2;
                this.selectedLevel = '';
                this.selectedSubject = null;
                this.subjects = [];
            },

            selectLevel(levelName) {
                const foundLevel = this.levels.find(l => l.name === levelName);
                if (foundLevel) {
                    this.selectedLevel = foundLevel.name;
                    this.selectedLevelId = foundLevel.id;
                    this.subjects = foundLevel.subjects || [];
                    this.step = 3;
                }
            },

            selectSubject(subject) {
                this.selectedSubject = subject;
                this.step = 4;
            },

            selectQuestionType(type) {
                this.questionType = type;
                if (type === 'mcq') {
                    this.options = [{
                        value: '',
                        is_correct: false
                    }, {
                        value: '',
                        is_correct: false
                    }];
                } else if (type === 'fill_blank') {
                    this.questionContent = '';
                    this.blanks = [];
                } else if (type === 'true_false') {
                    this.trueFalseAnswer = 'True';
                } else if (type === 'linking') {
                    this.linkingOptions = [];
                    this.addLinkingOption();
                    this.addLinkingOption(); // add default 2;
                } else if (type === 'spelling') {
                    this.spellingAnswer = '';
                } else if (type === 'rearranging') {
                    this.questionContent = '';
                } else if (type === 'comprehension') {
                    this.questionContent = '';
                }
                this.step = 5;
            },

            addOption() {
                // if (this.options.length < 10) {
                    this.options.push({
                        value: '',
                        is_correct: false
                    });
                // }
            },

            removeOption(index) {
                if (this.options.length > 1) {
                    this.options.splice(index, 1);
                }
            },

            setCorrect(index) {
                this.options.forEach((opt, i) => {
                    opt.is_correct = (i === index);
                });
            },


            // addBlank() {
            //     const textarea = this.$refs.questionContent;
            //     if (!textarea) return;

            //     const blankNumber = this.blanks.length + 1;
            //     const insertText = `${blankNumber}. _____`;

            //     const start = textarea.selectionStart;
            //     const end = textarea.selectionEnd;

            //     this.questionContent =
            //         this.questionContent.substring(0, start) +
            //         insertText +
            //         this.questionContent.substring(end);

            //     this.$nextTick(() => {
            //         textarea.focus();
            //         textarea.selectionStart = textarea.selectionEnd = start + insertText.length;
            //     });

            //     this.blanks.push({
            //         blank_number: blankNumber,
            //         options: ['', '', '', ''],
            //         answer: ''
            //     });
            // },

            // removeBlank(index) {
            //     const removed = this.blanks[index];
            //     const regex = new RegExp(`\\b${removed.blank_number}\\. _____\\b`);
            //     this.questionContent = this.questionContent.replace(regex, '').replace(/\s+/, ' ');

            //     this.blanks.splice(index, 1);

            //     // Re-number blanks and update passage
            //     this.blanks.forEach((b, i) => {
            //         const oldNumber = b.blank_number;
            //         const newNumber = i + 1;
            //         if (oldNumber !== newNumber) {
            //             const re = new RegExp(`\\b${oldNumber}\\. _____\\b`);
            //             this.questionContent = this.questionContent.replace(re, `${newNumber}. _____`);
            //             b.blank_number = newNumber;
            //         }
            //     });
            // },

            addBlank() {
                const blankNumber = this.blanks.length + 1;
                const insertText = `${blankNumber}. _____`;

                const range = this.quill.getSelection(true);
                if (range) {
                    this.quill.insertText(range.index, insertText, 'user');
                    this.quill.setSelection(range.index + insertText.length, 0);
                }

                this.blanks.push({
                    blank_number: blankNumber,
                    options: ['', '', '', ''],
                    answer: ''
                });

                this.questionContent = this.quill.root.innerHTML;
            },

            removeBlank(index) {
                const removed = this.blanks[index];
                const placeholder = `${removed.blank_number}. _____`;

                const content = this.quill.getText();
                const indexToRemove = content.indexOf(placeholder);

                if (indexToRemove !== -1) {
                    this.quill.deleteText(indexToRemove, placeholder.length, 'user');
                }

                this.blanks.splice(index, 1);

                // Re-number blanks and update content
                this.blanks.forEach((b, i) => {
                    const oldNumber = b.blank_number;
                    const newNumber = i + 1;
                    if (oldNumber !== newNumber) {
                        const oldText = `${oldNumber}. _____`;
                        const newText = `${newNumber}. _____`;

                        const delta = this.quill.getContents();
                        const ops = delta.ops.map(op => {
                            if (typeof op.insert === 'string') {
                                op.insert = op.insert.replace(oldText, newText);
                            }
                            return op;
                        });
                        this.quill.setContents({
                            ops
                        });
                        b.blank_number = newNumber;
                    }
                });

                this.questionContent = this.quill.root.innerHTML;
            },




            addBlankOption(blankIndex) {
                this.blanks[blankIndex].options.push('');
            },

            removeBlankOption(blankIndex, optionIndex) {
                if (this.blanks[blankIndex].options.length > 1) {
                    this.blanks[blankIndex].options.splice(optionIndex, 1);
                }
            },

            linkingOptions: [],

            addLinkingOption() {
                this.linkingOptions.push({
                    label_type: 'text',
                    label_text: '',
                    label_image: '',
                    label_preview: '',
                    value_type: 'text',
                    value_text: '',
                    value_image: '',
                    value_preview: '',
                });
            },

            previewFile(event, option, type) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = () => {
                    if (type === 'label') {
                        option.label_preview = reader.result;
                        option.label_image = file;
                    } else {
                        option.value_preview = reader.result;
                        option.value_image = file;
                    }
                };
                reader.readAsDataURL(file);
            },

            // Rearranging
            rearrangingItems: [''],

            // Comprehension
            comprehensionPassage: '',
            comprehensionQuestions: [{
                question: '',
                blanks: [], // ✅ Add this line
            }],



            // Rearranging logic
            addRearrangingItem() {
                this.rearrangingItems.push('');
            },
            removeRearrangingItem(i) {
                this.rearrangingItems.splice(i, 1);
            },


            addComprehensionQuestion() {
                this.comprehensionQuestions.push({
                    question: '',
                    blanks: [],
                });
            },
            addComprehensionBlank(qIndex) {
                const comp = this.comprehensionQuestions[qIndex];

                if (!comp || !Array.isArray(comp.blanks)) {
                    console.warn('Invalid question or blanks missing at index:', qIndex);
                    return;
                }

                const blankNumber = comp.blanks.length + 1;
                const insertText = `${blankNumber}. _____`;

                const textareaRef = this.$refs.compTextarea;
                const ta = Array.isArray(textareaRef) ? textareaRef[qIndex] : textareaRef;

                if (!ta) {
                    console.warn('Textarea ref not found for index:', qIndex);
                    return;
                }

                const start = ta.selectionStart;
                const end = ta.selectionEnd;

                comp.question =
                    comp.question.substring(0, start) +
                    insertText +
                    comp.question.substring(end);

                this.$nextTick(() => {
                    ta.focus();
                    ta.selectionStart = ta.selectionEnd = start + insertText.length;
                });

                comp.blanks.push({
                    blank_number: blankNumber,
                    options: ['', '', '', ''],
                    answer: ''
                });
            },


            removeComprehensionBlank(qIndex, bIndex) {
                const comp = this.comprehensionQuestions[qIndex];
                const removedBlank = comp.blanks[bIndex];

                // Remove the placeholder text (e.g., "2. _____") from the question string
                const placeholder = `${removedBlank.blank_number}. _____`;
                comp.question = comp.question.replace(placeholder, '');

                // Remove the blank from the array
                comp.blanks.splice(bIndex, 1);

                // Re-number remaining blanks
                comp.blanks.forEach((b, i) => {
                    const oldPlaceholder = `${b.blank_number}. _____`;
                    const newPlaceholder = `${i + 1}. _____`;

                    // Update question text if placeholder exists
                    if (comp.question.includes(oldPlaceholder)) {
                        comp.question = comp.question.replace(oldPlaceholder, newPlaceholder);
                    }

                    // Update blank number
                    b.blank_number = i + 1;
                });
            },

            addComprehensionBlankOption(qIndex, bIndex) {
                this.comprehensionQuestions[qIndex].blanks[bIndex].options.push('');
            },

            removeComprehensionBlankOption(qIndex, bIndex, optIndex) {
                const options = this.comprehensionQuestions[qIndex].blanks[bIndex].options;
                if (options.length > 1) {
                    options.splice(optIndex, 1);
                }
            },

            submitForm() {
                // Optional: console.log to debug
                console.log(JSON.stringify(this.blanks, null, 2));
                this.$root.querySelector('form').submit();
            }
        }
    }
</script>
