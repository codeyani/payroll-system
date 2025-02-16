<script setup>
import { ref } from "vue";
import axios from "axios";
import { useToast } from "vue-toastification";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const toast = useToast();

const form = ref({
    bank_name: "",
    account_no: "",
});

const submitBankAccount = async () => {
    try {
        const response = await axios.post(route("bank-account.store"), form.value);
        toast.success(response.data.message || "Bank account created successfully!");
        form.value.bank_name = "";
        form.value.account_no = "";
    } catch (error) {
        toast.error(error.response?.data?.message || "Error! Please try again.");
    }
};
</script>

<template>
    <Head title="Create Bank Change Request" />

    <AuthenticatedLayout>
        <div class="p-6 max-w-lg mx-auto bg-white shadow-md rounded-lg mt-32">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Create Bank Account</h2>

            <form @submit.prevent="submitBankAccount" class="space-y-5">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Bank Name</label>
                    <input type="text" v-model="form.bank_name" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                        required />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Account Number</label>
                    <input type="text" v-model="form.account_no" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                        required />
                </div>

                <div class="flex justify-between items-center mt-4">
                    <a :href="route('dashboard')"  
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
                        Back to Dashboard
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
