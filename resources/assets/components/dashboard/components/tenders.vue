<template>
    <v-card flat outlined class="mb-3">
        <v-card-title class="my-0" style="background: #fdfdfd;">
            <v-spacer></v-spacer>
            <span class="h4" v-if="this.auth_user.id"><span v-if="this.auth_user.role_id == 101">Ваши</span><span v-else>Новые</span> тендеры</span>
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
                            <v-list-item three-line :href="'/admin/tender/now/card/'+item.id" class="text-decoration-none">
                                <v-list-item-content>
                                    <v-list-item-title>
                                        <span class="h5">{{item.title}}</span>
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
                                        {{item.active_material}} <span v-if="item.is_analog == 1">или аналог</span>
                                    </v-list-item-subtitle>
                                    <v-card-actions class="pa-0 mt-1 mb-0">
                                        <span class="caption grey--text" style="line-height:125%;" v-html="item.created_formated+''+((item.delivery_condition == 2 || item.delivery_condition == 3) ? '<br>'+item.delivery_region : '')"></span>
                                        <v-spacer></v-spacer>
                                    </v-card-actions>
                                </v-list-item-content>
                                <v-list-item-action v-if="auth_user.role_id == 102">
									<span class="font-weight-bold success--text" v-if="item.rate != undefined">{{formatPrice(item.rate.price*item.size)}} ₽</span>
                                    <span class="font-weight-light grey--text mb-2" v-if="item.rate != undefined">({{formatPrice(item.rate.price)}} ₽/{{item.unit}})</span>
                                    <span class="font-weight-bold success--text mb-2" v-else>0 ₽</span>
                                    <span class="caption grey--text">до {{item.date_formated}}</span>
                                </v-list-item-action>
                                <v-list-item-action v-else>
                                    <span class="font-weight-bold success--text mb-2" v-if="item.rate != undefined">{{formatPrice(item.rate.price)}} ₽<span class="font-weight-light">/{{item.unit}}</span></span>
                                    <span class="font-weight-bold success--text mb-2" v-else>0 ₽</span>
                                    <span class="caption grey--text">до {{item.date_formated}}</span>
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
            <v-btn color="success" depressed class="rounded-btn px-6 text-decoration-none" :href="all_tenders_link">Смотреть все</v-btn>
            <v-spacer></v-spacer>
        </v-card-actions>
    </v-card>
</template>

<script> 
export default {
    name: 'dashboard_tenders',
    data () {
        return {
            type: 'drop',
            loading: false,
            headers: [
                { text: 'Создан', value: 'created', class: 'px-2' },
                { text: 'Дата окончания', value: 'date_formated', class: 'px-2' },
                { text: 'Наименование', value: 'title', class: 'px-2' },
                { text: 'Активное вещество', value: 'active_material', class: 'px-2' },
                { text: 'Текущая ставка', value: 'rate.price', class: 'px-2' },
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
                limit: this.auth_user.role_id == 101? 0 : 5,
				own: this.auth_user.role_id == 101? true : false,
                orderBy: 'id',
                orderType: 'desc',
                status: [1]
            }
            this.$store.dispatch('GET_TENDERS', params).then(res => {
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
//            console.log(val)
            this.getItems()
        }
    },
    computed: {
        auth_user: {
            get() { return this.$store.state.auth_user }
        },
        items: {
            get() { return this.$store.state.auction.tenders }
        },
        status_options: {
            get() { return this.$store.state.auction.status_options },
        },
		all_tenders_link: {
			get() { return this.auth_user.role_id == 101 ? '/admin/tender/mylist' : '/admin/tender/now' },
		},
    },
};
</script>
