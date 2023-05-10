<template>
    <v-card flat outlined class="mb-3">
        <v-card-title class="my-0" style="background: #fdfdfd;">
            <v-spacer></v-spacer>
            <span class="h4">Новые аукционы</span>
            <v-spacer></v-spacer>
        </v-card-title>
        <v-divider class="my-0"></v-divider>
        <v-data-table
            :items="items"
            :headers="headers"
            :mobile-breakpoint="100"
            :locale="$vuetify.lang.current"
            :loading="loading"
            :sort-by="['created_at']"
            :sort-desc="['DESC']"
            calculate-widths
            hide-default-header
            hide-default-footer
            dense
        >
            <!-- СТРОЧКА ТАБЛИЦЫ -->
            <template v-slot:item="{ item }">
                <tr class="table-row font-weight-medium">
                    <td class="pa-0" :colspan="headers.length">
                        <v-card flat color="transparent">
                            <v-list-item three-line :href="'/admin/auction/now/card/'+item.id" class="text-decoration-none">
                                <v-list-item-avatar class="my-auto">
                                    <v-img v-if="item.photo != null" :src="'/storage/avatars/auctions/'+item.photo"></v-img>
                                    <v-icon v-else>mdi-camera</v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        <span class="h5">{{item.title}}</span>
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
                                        {{item.description}}
                                    </v-list-item-subtitle>
                                    <v-card-actions class="pa-0 mt-2 mb-0">
                                        <span class="caption grey--text">Создан {{item.created_formated}}</span>
                                        <v-spacer></v-spacer>
                                        <span class="caption grey--text">До {{item.date_time_formated}}</span>
                                    </v-card-actions>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <span class="font-weight-bold">{{formatPrice(item.price)}}</span>
                                </v-list-item-action>
                            </v-list-item>
                        </v-card>
                    </td>
                </tr>
            </template>
        </v-data-table>
        <v-divider class="my-0"></v-divider>
        <v-card-actions class="pa-4" style="background: #fdfdfd;">
            <v-spacer></v-spacer>
            <v-btn color="success" depressed class="rounded-btn px-6 text-decoration-none" href="/admin/auction/now">Смотреть все</v-btn>
            <v-spacer></v-spacer>
        </v-card-actions>
    </v-card>
</template>

<script> 
export default {
    name: 'dashboard_auctions',
    data () {
        return {
            type: 'rise',
            loading: false,
            headers: [
                { text: 'Создан', value: 'created_at', class: 'px-2' },
                { text: 'Дата окончания', value: 'date_time', class: 'px-2' },
                { text: 'Наименование', value: 'title', class: 'px-2' },
                { text: 'Описание', value: 'description', class: 'px-2' },
                { text: 'Текущая ставка', value: 'price', class: 'px-2' },
                { text: 'Статус', value: 'status', class: 'px-2' },
            ],
        }
    },
    mounted() {
    },
    methods: {
        getItems() {
            this.loading = true
            let params = {
                user_id: this.auth_user.id,
                type: this.type,
                now: true,
                limit: 5,
                orderBy: 'id',
                orderType: 'desc',
                status: [1]
            }
            this.$store.dispatch('GET_AUCTIONS', params).then(res => {
            })
            .finally(() => (this.loading = false))
        },
        formatDate (date) {
            if (!date) return null
            const [year, month, day] = date.split('-')
            return `${day}.${month}.${year}`
        },
        formatDateWithoutYear (date) {
            if (!date) return null
            const [year, month, day] = date.split('-')
            return `${day}.${month}`
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0)
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        },
    },
    props: {
    },
    watch: {
        auth_user(val) {
            this.getItems()
        }
    },
    computed: {
        auth_user: {
            get() { return this.$store.state.auth_user }
        },
        items: {
            get() { return this.$store.state.auction.items }
        },
        status_options: {
            get() { return this.$store.state.auction.status_options },
        },
    },
};
</script>
