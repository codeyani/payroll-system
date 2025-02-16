<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import EmployeeBankAccount from './Employee/BankAccount.vue';
import HRBankChangeRequests from './HR/BankChangeRequests.vue';
const props = defineProps({
    user: Object
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <EmployeeBankAccount v-if="user.role_name === 'Employee'"/>
                    <HRBankChangeRequests v-if="user.role_name === 'HR'"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
