<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from "vue-toastification";

const requests = ref([]);
const showModal = ref(false);
const selectedRequest = ref(null);
const actionType = ref('');
const toast = useToast();

const fetchRequests = async () => {
    try {
        const response = await axios.get(route('bank-account.change-requests'));
        requests.value = response.data.data;
    } catch (error) {
        console.error('Error fetching requests:', error);
    }
};

const confirmAction = (request, type) => {
    selectedRequest.value = request;
    actionType.value = type;
    showModal.value = true;
};

const updateRequest = async () => {
    try {
        await axios.post(`/api/bank/${actionType.value.toLowerCase()}/${selectedRequest.value.id}`, { status: actionType.value });
        toast.success(`Request ${actionType.value.toLowerCase()} successfully!`);
        fetchRequests();
    } catch (error) {
        toast.error(`Error updating request: ${error.response.data.message || 'Please try again later.'}`);
    } finally {
        showModal.value = false;
        selectedRequest.value = null;
    }
};

onMounted(fetchRequests);
</script>

<template>
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">Bank Change Requests</h2>
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Employee</th>
                    <th class="p-2">Old Bank Name</th>
                    <th class="p-2">New Bank Name</th>
                    <th class="p-2">Old Account No</th>
                    <th class="p-2">New Account No</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="request in requests" :key="request.id" class="border-t">
                    <td class="p-2 text-center">{{ request.employee_id }}</td>
                    <td class="p-2 text-center">{{ request.old_bank_name }}</td>
                    <td class="p-2 text-center">{{ request.new_bank_name }}</td>
                    <td class="p-2 text-center">{{ request.old_account_no }}</td>
                    <td class="p-2 text-center">{{ request.new_account_no }}</td>
                    <td class="p-2 text-center">{{ request.status }}</td>
                    <td class="p-2 text-center">
                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 mr-2" 
                                @click="confirmAction(request, 'Approved')">
                            Approve
                        </button>
                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                @click="confirmAction(request, 'Rejected')">
                            Reject
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="requests.length === 0" class="w-full text-center mt-4">
            <span>No Data</span>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm text-center">
            <h3 class="text-lg font-semibold mb-4">Confirm {{ actionType }} Request</h3>
            <p class="mb-4">Are you sure you want to <strong>{{ actionType.toLowerCase() }}</strong> this request?</p>
            <div class="flex justify-center space-x-4">
                <button class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" @click="showModal = false">
                    Cancel
                </button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" @click="updateRequest">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</template>
