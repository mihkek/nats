<template>
    <v-app>
        <v-container fluid grid-list-md>
            <v-card width="420" class="mx-auto my-12">
                <v-form v-model="valid" ref="form" @submit.prevent="sendSms" v-show="step == 1">
                    <v-card-title>
                        Вход в систему
                    </v-card-title>
                    <v-card-text>
                        <v-text-field
                            class="mt-4"
                            outlined
                            filled
                            v-model="phone"
                            :rules="phone_rules"
                            v-mask="'+7 (###) ###-##-##'"
                            required
                        ></v-text-field>
                        <span class="grey--text">На указаный номер телефона будет выслано СМС с одноразовым паролем.</span>
                    </v-card-text>
                    <v-card-actions class="pa-2">
                        <v-spacer></v-spacer>
                        <v-btn color="success" type="submit" :loading="loading">Далее</v-btn>
                    </v-card-actions>
                </v-form>
                <v-form v-model="sms_valid" ref="form" @submit.prevent="login" v-show="step == 2">
                    <v-card-title>
                        Вход в систему
                    </v-card-title>
                    <v-card-text>
                        <v-text-field
                            class="mt-4"
                            outlined
                            filled
                            v-model="sms"
                            :rules="sms_rules"
                            v-mask="'######'"
                            required
                        ></v-text-field>
                        <span class="grey--text">
                            На указанный номер было отправлено СМС с паролем.
                            <br/>
                            Введите пароль из смс.
                        </span>
                    </v-card-text>
                    <v-card-actions class="pa-2">
                        <v-spacer></v-spacer>
                        <v-btn color="success" type="submit" :loading="loading">Войти</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-container>
        <snackbar />
    </v-app>
</template>

<script> 
import { mask } from 'vue-the-mask'
import snackbar from './snackbar'

export default {
    name: 'login',
    data () {
        return {
            step: 1,
            valid: false,
            sms_valid: false,
            loading: false,
            phone: '',
            sms: '',
            phone_rules: [
                v => !!v || 'Поле обязательно',
                v => v.length == 18 || 'Неверный формат',
            ],
            sms_rules: [
                v => !!v || 'Поле обязательно',
                v => v.length == 6 || 'Пароль состоит из 6 символов',
            ],
        }
    },
    components: {
        snackbar
    },
    methods: {
        login() {
            this.loading = true
            let params = {}
            params.phone = this.phone
            params.sms = this.sms
            axios.post('/auth/login_sms', params).then(res => {
                if (res.data.status == 1) {
                    location.href = '/admin'
                }
                else this.$store.commit('SET_SNACKBAR', res.data)
            })
            .finally(() => (this.loading = false))
        },
        sendSms() {
            this.loading = true
            let params = {}
            params.phone = this.phone
            axios.post('/auth/send_sms', params).then(res => {
                if (res.data.status == 1) this.step = 2
                else this.$store.commit('SET_SNACKBAR', res.data)
            })
            .finally(() => (this.loading = false))
        },
    },
    computed: {

    },
    directives: { 
        mask 
    },
};
</script>
