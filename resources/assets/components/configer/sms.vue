<template>
    <v-app id="vue_block">
	    <v-container fluid grid-list-xl class="px-0 py-0">
    	    <FieldAccess model="admin" field="lang" field_name="Язык" v-slot="{ accessData }">
    	        <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    	    </FieldAccess>
    	    <v-layout row wrap>



                <v-flex md4 xs12>
                    <v-card class="rounded-lg" flat outlined>
                        <v-subheader>
                            Текущий баланс
                            <v-spacer></v-spacer>
                            <v-btn small :ripple="false" color="info" class="rounded-btn" text :loading="balance_loading" @click.stop="getItem()"> <v-icon left size="18">mdi-sync</v-icon> Обновить</v-btn>
                        </v-subheader>
                        <v-card-title class="display-1"  v-show="!balance_loading" >
                            <span v-html="formatPrice(balance)"></span> <v-icon right size="34">mdi-currency-rub</v-icon>
                        </v-card-title>
                    </v-card>
                </v-flex>



                <v-flex md8 xs12>
                    <v-card class="rounded-lg" flat outlined>
                        <v-subheader>
                            История
                            <v-spacer></v-spacer>
                            <v-btn small :ripple="false" color="success" class="rounded-btn" depressed :loading="loading" @click.stop="dialog = !dialog"> <v-icon left size="18">mdi-plus</v-icon> Новое смс</v-btn>
                        </v-subheader>
                        <v-divider class="my-0"></v-divider>
                        <v-card flat tile color="#fafafa" class="pa-2">
                            <v-text-field
                                solo
                                flat
                                hide-details
                                v-model="search"
                                placeholder="Поиск"
                            ></v-text-field>
                        </v-card>
                        <v-divider class="my-0"></v-divider>
                        <v-data-table
                            :items="items"
                            :headers="headers"
                            :search="search"
                            color="transparent"
                            class="rounded-lg"
                            :mobile-breakpoint="100"
                            :locale="$vuetify.lang.current"
                            :loading="loading"
                            :sort-by="['created']"
                            :sort-desc="['DESC']"
                            calculate-widths
                        >
                            <!-- СТРОЧКА ТАБЛИЦЫ -->
                            <template v-slot:item="{ item }">
                                <tr class="table-row font-weight-medium">
                                    <td @click.stop="goTo(item)">
                                        <span class="caption">{{formatDateTime(item.created_at)}}</span>
                                    </td>
                                    <td @click.stop="goTo(item)">
                                        <v-chip label small>{{item.phone}}</v-chip>
                                    </td>
                                    <td @click.stop="goTo(item)">
                                        <p class="my-0 caption">{{item.text}}</p>
                                    </td>
                                    <!--
                                   <td @click.stop="goTo(item)">
                                       <v-list-item dense class="px-0">
                                           <v-list-item-avatar size="30">
                                               <v-img
                                                   :src="'/storage/avatars/50x50.'+item.sender.avatar"
                                                   :lazy-src="'/storage/avatars/50x50.'+item.sender.avatar"
                                               ></v-img>
                                           </v-list-item-avatar>
                                           <v-list-item-content>
                                               <v-list-item-title v-html="item.sender.name_family"></v-list-item-title>
                                               <v-list-item-subtitle v-html="item.sender.name+' '+item.sender.name_patronymic"></v-list-item-subtitle>
                                           </v-list-item-content>
                                        </v-list-item>
                                    </td>
                                    -->
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-flex>



		    </v-layout>
	    </v-container>
	    <snackbar />
        <v-dialog v-model="dialog" max-width="420">
            <v-form v-model="valid" ref="form" @submit.prevent="submitNew">
                <v-card>
                    <v-card-title>
                        Отправить новое смс
                    </v-card-title>
                    <v-card-text>
                        <v-text-field
                            label="Номер телефона"  
                            required
                            :rules="rules"
                            solo
                            v-mask="'+7 (###) ###-##-##'"
                            flat
                            backgroundColor="#fafafa"
                            v-model="phone"
                        ></v-text-field>
                        <v-textarea
                            label="Текст сообщения"  
                            required
                            :rules="rules"
                            solo
                            flat
                            backgroundColor="#fafafa"
                            v-model="text"
                        ></v-textarea>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="grey darken-3" text @click.stop="dialog = false">Отменить</v-btn>
                        <v-btn color="grey darken-3" text type="submit" :loading="action_loading">Подтвердить</v-btn>
                    </v-card-actions>
                </v-card>                 
            </v-form>
        </v-dialog>
    </v-app>
</template>

<script> 
import snackbar from '../snackbar'
import AdminPanel from '../snippets/AdminPanel'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import { mask } from 'vue-the-mask'

export default {
    name: 'configer_sms',
    data () {
        return {
            loading: false,
            balance: 0,
            dialog: false,
            action_loading: false,
            valid: false,
            rules: [
                v => !!v || __('forms.required_field'),
            ],
            phone_rules: [
                v => !!v || __('forms.required_field'),
                v => v.length == 18 || __('forms.phone_error'),
            ],
            phone: '',
            text: '',
            items: [],
            headers: [
                { value: 'created_at', text: 'Дата и время' },
                { value: 'phone', text: 'Номер телефона' },
                { value: 'text', text: 'Текст сообщения' },
/*                { value: 'sender.full_name', text: 'Отправитель' }, */
            ],
            search: '',
            balance_loading: false,
        }
    },
    props: {
        user_id: Number,
    },
    components: {
        snackbar, 
        AdminPanel, 
        FieldAccess, 
        FieldAccessButton
    },
    mounted() {
        this.getItems()
    },
    methods: {
        submitNew() {
            if (this.valid) {
                this.action_loading = true
                let params = {
                    phone: this.phone,
                    text: this.text,
                    sender_id: this.user_id,
                }
                axios.post('/admin/sms/new', params).then(res => {
                    this.dialog = false
                    this.$store.commit('SET_SNACKBAR', res.data)
                    this.getItems()
                })
                .finally(() => (this.action_loading = false))
            }
            else {
                this.$refs.form.validate()
            }
        },
        getItems() {
            this.loading = true
            axios.post('/admin/sms/get').then(res => {
                this.items = res.data.items
                this.getItem()
            })
            .finally(() => (this.loading = false))
        },
        getItem() {
            this.balance_loading = true
            axios.post('/admin/sms/get_balance').then(res => {
                this.balance = res.data.balance.balance
            })
            .finally(() => (this.balance_loading = false))
        },
        formatDateTime(val) {
            if (!val) return null
            const [date, time] = val.split(' ')
            const [year, month, day] = date.split('-')
            return `${day}.${month}.${year} ${time}`
        },
        formatDate (date) {
            if (!date) return null
            const [year, month, day] = date.split('-')
            return `${day}.${month}.${year}`
        },
        formatPrice(value) {
            let val = (value/1).toFixed(2)
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        },
    },
    watch: {
    },
    computed: {
    },
    directives: {  
        mask 
    },
};
</script>

<style>
	
</style>