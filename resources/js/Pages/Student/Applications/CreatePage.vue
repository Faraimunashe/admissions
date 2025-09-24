<template>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="/student/applications" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors duration-200 mr-4">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Applications
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Application</h1>
            <p class="text-gray-600 mt-2">Submit your application for {{ activePeriod?.description }}</p>
        </div>

        <!-- Progress Indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div v-for="(step, index) in steps" :key="index" class="flex items-center">
                    <div :class="[
                        'w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold',
                        currentStep > index ? 'bg-green-600 text-white' :
                        currentStep === index ? 'bg-green-100 text-green-600' :
                        'bg-gray-200 text-gray-500'
                    ]">
                        <span v-if="currentStep > index">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span v-else>{{ index + 1 }}</span>
                    </div>
                    <span :class="[
                        'ml-2 text-sm font-medium',
                        currentStep >= index ? 'text-gray-900' : 'text-gray-500'
                    ]">
                        {{ step }}
                    </span>
                    <div v-if="index < steps.length - 1" :class="[
                        'w-16 h-0.5 mx-4',
                        currentStep > index ? 'bg-green-600' : 'bg-gray-200'
                    ]"></div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <!-- Step 1: Programme Selection -->
                <div v-if="currentStep === 1" class="p-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Select Your Programme Choices</h2>
                        <p class="text-gray-600">Choose exactly 3 programmes in order of preference (1st choice, 2nd choice, 3rd choice)</p>
                    </div>

                    <div class="space-y-6">
                        <div v-for="choice in 3" :key="choice" class="border border-gray-200 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <span class="w-8 h-8 bg-green-100 text-green-600 text-sm font-semibold rounded-full flex items-center justify-center mr-3">
                                    {{ choice }}
                                </span>
                                <h3 class="text-lg font-medium text-gray-900">{{ getChoiceLabel(choice) }} Choice</h3>
                            </div>

                            <div class="relative">
                                <select
                                    v-model="form.programmes[choice - 1].programme_id"
                                    :class="[
                                        'block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200',
                                        form.errors[`programmes.${choice - 1}.programme_id`] ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : ''
                                    ]"
                                    required
                                >
                                    <option value="">Select a programme</option>
                                    <option v-for="programme in availableProgrammes(choice - 1)" :key="programme.id" :value="programme.id">
                                        {{ programme.name }}
                                    </option>
                                </select>
                            </div>
                            <p v-if="form.errors[`programmes.${choice - 1}.programme_id`]" class="text-sm text-red-600 mt-2">
                                {{ form.errors[`programmes.${choice - 1}.programme_id`] }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Document Upload -->
                <div v-if="currentStep === 2" class="p-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Upload Required Documents</h2>
                        <p class="text-gray-600">Upload your academic documents. All files must be in PDF, JPG, or PNG format (max 5MB each)</p>
                    </div>

                    <div class="space-y-6">
                        <div v-for="(document, index) in form.documents" :key="index" class="border border-gray-200 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Document {{ index + 1 }}</h3>
                                <button
                                    v-if="form.documents.length > 1"
                                    type="button"
                                    @click="removeDocument(index)"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium"
                                >
                                    Remove
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Document Description</label>
                                    <input
                                        v-model="document.description"
                                        type="text"
                                        :class="[
                                            'block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200',
                                            form.errors[`documents.${index}.description`] ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : ''
                                        ]"
                                        placeholder="e.g., High School Certificate, Transcript, etc."
                                        required
                                    />
                                    <p v-if="form.errors[`documents.${index}.description`]" class="text-sm text-red-600 mt-2">
                                        {{ form.errors[`documents.${index}.description`] }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-green-400 transition-colors duration-200">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                    <span>Upload a file</span>
                                                    <input
                                                        @change="handleFileChange($event, index)"
                                                        type="file"
                                                        class="sr-only"
                                                        accept=".pdf,.jpg,.jpeg,.png"
                                                        required
                                                    />
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB</p>
                                        </div>
                                    </div>
                                    <p v-if="document.file" class="text-sm text-green-600 mt-2">
                                        ✓ {{ document.file.name }}
                                    </p>
                                    <p v-if="form.errors[`documents.${index}.file`]" class="text-sm text-red-600 mt-2">
                                        {{ form.errors[`documents.${index}.file`] }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button
                            type="button"
                            @click="addDocument"
                            class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors duration-200"
                        >
                            <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-600">Add Another Document</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Review and Submit -->
                <div v-if="currentStep === 3" class="p-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Review Your Application</h2>
                        <p class="text-gray-600">Please review your application details before submitting</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Period Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Application Period</h3>
                            <p class="text-gray-700">{{ activePeriod?.description }}</p>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ formatDate(activePeriod?.start_date) }} - {{ formatDate(activePeriod?.end_date) }}
                            </p>
                        </div>

                        <!-- Programme Choices -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Programme Choices</h3>
                            <div class="space-y-3">
                                <div v-for="(programme, index) in form.programmes" :key="index" class="flex items-center">
                                    <span class="w-8 h-8 bg-green-100 text-green-600 text-sm font-semibold rounded-full flex items-center justify-center mr-3">
                                        {{ index + 1 }}
                                    </span>
                                    <span class="text-gray-700">{{ getProgrammeName(programme.programme_id) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Documents to Upload</h3>
                            <div class="space-y-2">
                                <div v-for="(document, index) in form.documents" :key="index" class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700">{{ document.description }}</span>
                                    <span v-if="document.file" class="ml-2 text-sm text-green-600">({{ document.file.name }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <button
                            v-if="currentStep > 1"
                            type="button"
                            @click="previousStep"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </button>
                        <div v-else></div>

                        <button
                            v-if="currentStep < 3"
                            type="button"
                            @click="nextStep"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-sm hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105"
                        >
                            Next
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <button
                            v-else
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-sm hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        >
                            <span v-if="!form.processing">Submit Application</span>
                            <span v-else class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Submitting...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

const props = defineProps({
    activePeriod: Object,
    programmes: Array
})

const currentStep = ref(1)
const steps = ['Programmes', 'Documents', 'Review']

const form = useForm({
    period_id: props.activePeriod?.id || '',
    programmes: [
        { programme_id: '', choice: 1 },
        { programme_id: '', choice: 2 },
        { programme_id: '', choice: 3 }
    ],
    documents: [
        { file: null, description: '' }
    ]
})

const getChoiceLabel = (choice) => {
    const labels = ['1st', '2nd', '3rd']
    return labels[choice - 1] || `${choice}th`
}

const availableProgrammes = (currentIndex) => {
    const selectedIds = form.programmes
        .map((p, index) => index !== currentIndex ? p.programme_id : null)
        .filter(id => id)

    return props.programmes.filter(programme => !selectedIds.includes(programme.id))
}

const getProgrammeName = (programmeId) => {
    const programme = props.programmes.find(p => p.id === programmeId)
    return programme ? programme.name : 'Unknown Programme'
}

const addDocument = () => {
    form.documents.push({ file: null, description: '' })
}

const removeDocument = (index) => {
    if (form.documents.length > 1) {
        form.documents.splice(index, 1)
    }
}

const handleFileChange = (event, index) => {
    const file = event.target.files[0]
    if (file) {
        form.documents[index].file = file
    }
}

const nextStep = () => {
    if (currentStep.value < 3) {
        currentStep.value++
    }
}

const previousStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--
    }
}

const submit = () => {
    // Prepare form data for file uploads
    const formData = new FormData()
    formData.append('period_id', form.period_id)

    form.programmes.forEach((programme, index) => {
        formData.append(`programmes[${index}][programme_id]`, programme.programme_id)
        formData.append(`programmes[${index}][choice]`, programme.choice)
    })

    form.documents.forEach((document, index) => {
        formData.append(`documents[${index}][description]`, document.description)
        if (document.file) {
            formData.append(`documents[${index}][file]`, document.file)
        }
    })

    form.post('/student/applications', {
        data: formData,
        forceFormData: true
    })
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}
</script>

<script>
export default {
    layout: Layout
}
</script>
