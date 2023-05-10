<template>
<v-container fluid>
    <v-card flat outlined class="mb-3">
        <v-card-title class="my-0" style="background: #fdfdfd;">
            <v-spacer></v-spacer>
            <span class="h2" >Отзывы покупателей</span>
            <v-spacer></v-spacer>
        </v-card-title>
        <v-divider class="my-0"></v-divider>
        <v-data-table
            :items="reviews"
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
                <tr class="table-row font-weight-medium" @click.stop="showItem(item)">
                    <td class="pa-0" :colspan="headers.length">
                        <v-card flat color="transparent">
                            <v-list-item three-line class="text-decoration-none">
                                <v-list-item-content>
                                    <v-list-item-title>
                                        <span class="h5">{{item.created_at}}</span>&nbsp;&nbsp;<span class="h4">{{item.username}}</span>
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
                                        <span style="font-size: 16px;">{{item.review}}</span>
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <span class="caption grey--text" style="line-height:125%;" v-html="item.created"></span>
                                </v-list-item-action>
                            </v-list-item>
                        </v-card>
                    </td>
                </tr>
            </template>
        </v-data-table>

        <v-dialog v-model="show_dialog" scrollable persistent max-width="420">
                <v-card>
                <v-card-title>
                    <h2>Отзыв покупателя</h2>
                </v-card-title>
                <v-card-text style="max-height: 70vh; font-size: 16px;">
                 <span >{{item.username}}</span>&nbsp;&nbsp;<span>{{item.created_at}}</span><br><br>
                    <span v-if="auth_user.role_id != 1000">{{item.review}}</span>
                    <v-textarea v-if="auth_user.role_id == 1000" v-model="item.review" solo rows="5" style="padding: 15px;"></v-textarea>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="grey darken-3" text @click.stop="show_dialog = false">Закрыть</v-btn>
                    <v-btn color="grey darken-3" text @click.stop="save_dialog()"  v-if="auth_user.role_id == 1000">Сохранить и закрыть</v-btn>
                </v-card-actions>
                </v-card>
        </v-dialog>
    </v-card>
</v-container>
</template>

<script> 
export default {
    name: 'reviews_block',
    data () {
        return {
            type: 'drop',
            loading: false,
            reviews: [],
            headers: [
                { text: 'Отзывы', value: 'review', class: 'px-2' },
            ],
            show_dialog: false,
            item: {'id': 0, 'username' : '', 'review': '', 'created_at' : ''}
        }
    },
    mounted() {
        this.getItems()
    },
    methods: {
        getItems() {
          this.loading = true;
          let params = {}
          axios.post('/review/getlist', params).then(res => {
              this.reviews = res.data.reviews;
          })
          .finally(() => (this.loading = false))
        },
        showItem(item) {
            this.item = item;
            this.show_dialog = true;
        },
    },
    props: {
    },
    computed: {
        auth_user: {
            get() { return this.$store.state.auth_user }
        },
    },
};
</script>
