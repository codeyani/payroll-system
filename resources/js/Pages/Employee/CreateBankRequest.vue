<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useToast } from "vue-toastification";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const toast = useToast();

const form = ref({
    new_bank_name: '',
    new_account_no: '',
    reason: '',
});

const resetForm = () => {
    form.value = {
        new_bank_name: '',
        new_account_no: '',
        reason: '',
    };
};

const submitRequest = async () => {
    try {
        await axios.post(route('bank-account.change-request'), form.value, { withCredentials: true });
        toast.success('Bank change request submitted successfully!');
        resetForm(); // Reset form after successful submission
    } catch (error) {
        toast.error('Error submitting request: ' + (error.response?.data?.message || 'Please try again.'));
    }
};
</script>

<template>
    <Head title="Create Bank Change Request" />

    <AuthenticatedLayout>
        <div class="p-6 max-w-lg mx-auto bg-white shadow-md rounded-lg mt-32">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Request Bank Change</h2>

            <form @submit.prevent="submitRequest" class="space-y-5">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">New Bank Name</label>
                    <input type="text" v-model="form.new_bank_name" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                        required />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">New Account Number</label>
                    <input type="text" v-model="form.new_account_no" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                        required />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Reason for Change</label>
                    <textarea v-model="form.reason" 
                        class="w-full border border-gray-300 rounded-lg p-3 h-24 focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none" 
                        required></textarea>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <a :href="route('dashboard')"  
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
                        Back to Dashboard
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
