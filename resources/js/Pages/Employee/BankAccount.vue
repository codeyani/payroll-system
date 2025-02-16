<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const bankDetails = ref(null);
const bankChangeRequests = ref([]);

const fetchBankDetails = async () => {
    try {
        const response = await axios.get(route('bank-account.detail'), {
            withCredentials: true,
        });
        bankDetails.value = response.data.data;
    } catch (error) {
        console.error('Error fetching bank details:', error);
        bankDetails.value = null; // No bank details found
    }
};

const fetchBankChangeRequests = async () => {
    try {
        const response = await axios.get(route('bank-account.my-change-request'), { 
            withCredentials: true, 
            headers: {
                Authorization: `Bearer ${localStorage.getItem('authToken')}`
            }
        });
        bankChangeRequests.value = response.data.data;
    } catch (error) {
        console.error('Error fetching requests:', error);
    }
};

onMounted(() => {
    fetchBankDetails();
    fetchBankChangeRequests();
});
</script>

<template>
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">Your Bank Details</h2>

        <div v-if="bankDetails" class="border p-6 rounded-lg bg-white shadow-md">
            <div class="mb-4">
                <p class="text-lg"><strong>Bank Name:</strong> {{ bankDetails.bank_name }}</p>
                <p class="text-lg"><strong>Account Number:</strong> {{ bankDetails.account_number }}</p>
            </div>

            <!-- Bank Change Requests Header with Button -->
            <div class="flex justify-between items-center mt-6">
                <h2 class="text-xl font-semibold">Your Bank Change Requests</h2>
                <a :href="route('create-bank-request')" 
                   class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 transition">
                    Create Bank Request
                </a>
            </div>

            <!-- Change Requests Table -->
            <table class="w-full mt-4 border border-gray-200 shadow-sm rounded-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="p-3 text-left">Old Bank Name</th>
                        <th class="p-3 text-left">New Bank Name</th>
                        <th class="p-3 text-left">Old Account No</th>
                        <th class="p-3 text-left">New Account No</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="bankChangeRequests.length > 0" v-for="request in bankChangeRequests" :key="request.id" class="border-t border-gray-300">
                        <td class="p-3">{{ request.old_bank_name }}</td>
                        <td class="p-3">{{ request.new_bank_name }}</td>
                        <td class="p-3">{{ request.old_account_no }}</td>
                        <td class="p-3">{{ request.new_account_no }}</td>                          
                        <td class="p-3">{{ request.status }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-if="bankChangeRequests.length === 0" class="w-full text-center mt-4">
                <span>No Data</span>
            </div>
        </div>

        <!-- No Bank Details Section -->
        <div v-else class="text-gray-500 text-center p-6 border rounded-lg bg-white shadow-md">
            <p>You don't have a bank account yet.</p>
            <a :href="route('create-bank-account')" 
               class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 transition">
                Create Bank Account
            </a>
        </div>
    </div>
</template>
