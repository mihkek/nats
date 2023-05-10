<template>
    <v-card flat outlined class="mb-3">
        <v-card-title class="my-0" style="background: #fdfdfd;">
            <v-spacer></v-spacer>
            <span class="h4" >Отзывы покупателей</span>
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
                <tr class="table-row font-weight-medium" @click.stop="showItem(item)">
                    <td class="pa-0" :colspan="headers.length">
                        <v-card flat color="transparent">
                            <v-list-item three-line class="text-decoration-none">
                                <v-list-item-content>
                                    <v-list-item-title>
                                        <span class="h5">{{item.created_at}}</span>&nbsp;&nbsp;<span class="h5">{{item.username}}</span>
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
                                        <span>{{item.review}}</span>
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <span class="caption grey--text" style="line-height:125%;" v-html="item.created"></span>
                                </v-list-item-action>
                                  <v-list-item-icon v-if="auth_user.role_id == 1000">
                                    <v-tooltip top>
                                      <template v-slot:activator="{on}">
                                        <v-btn v-on="on" color="red" icon small @click.stop="deleteItem(item.id)"><v-icon size="18">mdi-delete</v-icon></v-btn>
                                      </template>
                                    </v-tooltip>
                                  </v-list-item-icon>
                            </v-list-item>
                        </v-card>
                    </td>
                </tr>
            </template>
        </v-data-table>

        <v-dialog v-model="delete_dialog" scrollable persistent max-width="420">
            <v-card>
            <v-card-title>
                Удалить отзыв
            </v-card-title>
            <v-card-text style="max-height: 70vh;">
                Вы действительно хотите удалить отзыв покупателя?
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="grey darken-3" text @click.stop="delete_dialog = false">Отменить</v-btn>
                <v-btn color="grey darken-3" text @click.stop="submitDelete" :loading="loading">Подтвердить</v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="show_dialog" scrollable persistent max-width="420">
                <v-card>
                <v-card-title>
                    Отзыв покупателя
                </v-card-title>
                <v-card-text style="max-height: 70vh;">
                 <span>{{item.username}}</span>&nbsp;&nbsp;<span>{{item.created_at}}</span><br><br>
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
</template>

<script> 
export default {
    name: 'dashboard_reviews',
    data () {
        return {
            type: 'drop',
            loading: false,
            headers: [
                { text: 'Отзывы', value: 'review', class: 'px-2' },
            ],
            delete_dialog: false,
            show_dialog: false,
            delete_review_id: 0,
            item: {'id': 0, 'username' : '', 'review': '', 'created_at' : ''}
        }
    },
    mounted() {
    },
    methods: {
        getItems() {
            this.loading = true;
            let params = {};
            this.$store.dispatch('GET_REVIEWS', params).then(res => {

            })
            .finally(() => (this.loading = false));
        },
        showItem(item) {
            this.item = item;
            this.show_dialog = true;
        },
        save_dialog(){
            this.loading = true;
            let params = {'id' : this.item.id, 'review' : this.item.review};
            this.$store.dispatch('UPDATE_REVIEW', params).then(res => {
              this.item.review = this.$store.state.review.review;
              this.show_dialog = false;
            })
            .finally(() => (this.loading = false))
        },
        deleteItem(id) {
            this.delete_review_id = id;
            this.delete_dialog = true;
        },
        submitDelete() {
            this.loading = true;
            let params = {'id' : this.delete_review_id};
            this.$store.dispatch('DELETE_REVIEW', params).then(res => {
              this.getItems();
              this.delete_dialog = false;
            })
            .finally(() => (this.loading = false))
        }
    },
    props: {
    },
    watch: {
        auth_user(val) {
            this.getItems();
        }
    },
    computed: {
        auth_user: {
            get() { return this.$store.state.auth_user }
        },
        items: {
            get() { return this.$store.state.review.reviews }
        },
    },
};
</script>
