<template>
    <v-card flat outlined class="mb-3">
        <v-card-title class="my-0">
            <v-spacer></v-spacer>
            <span class="h4">Настройки профиля</span>
            <v-spacer></v-spacer>
        </v-card-title>
        <v-card-text class="text-center">
            <v-icon size="64">mdi-account</v-icon>
        </v-card-text>
        <v-card-actions class="pt-2 px-4 pb-4">
            <v-spacer></v-spacer>
            <v-btn color="success" depressed class="rounded-btn px-6 text-decoration-none" href="/admin/settings/personal">Изменить</v-btn>
            <v-spacer></v-spacer>
        </v-card-actions>
    </v-card>
</template>

<script> 
export default {
    name: 'dashboard_personal',
    data () {
        return {
        }
    },
    mounted() {
    },
    methods: {
    },
    props: {
    },
    watch: {
        auth_user(val) {
            this.getItems()
        }
    },
    computed: {
    },
};
</script>
