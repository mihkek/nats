<template>
<v-app id="vue_block">
  <v-container fluid grid-list-md class="px-0 py-0">
    <FieldAccess model="admin" field="panel" field_name="Админ панель" v-slot="{ accessData }">
      <AdminPanel v-if="accessData.canAdmin" :loading="loading"/>
    </FieldAccess>
    <v-layout row wrap>
      <v-flex xs12 class="mt-3 py-0">
        <requester_notifications :user_id="user_id" @select="showNotifications"/>
      </v-flex>
      <v-flex xs12>
        <v-card class="rounded-lg">
          <v-container fluid>
            <v-layout row wrap>
              <v-flex xs12 md3 v-if="$props.status[0] != 7">
                <v-select
                    :items="date_options"
                    item-text="text"
                    item-value="value"
                    v-model="date_filter"
                    solo
                    flat
                    backgroundColor="#fdfdfd"
                    hide-details
                    @change="getItems"
                  ></v-select>
              </v-flex>
              <v-flex md6 xs12>
                <v-card flat>
                	<v-layout row wrap>
                		<v-flex xs12 md6>
                    		<v-text-field
                    		  	solo
                    		  	flat
                    		  	type="date"
                    		  	label="Начало периода"
                    		  	backgroundColor="#fdfdfd"
                    		  	hide-details
                    		  	@change="getItems"
                    		  	v-model="date_from"
                    		  	clearable
                    		>
                    			<template v-slot:prepend>
                    				<span>С</span>
                    			</template>
                    		</v-text-field>
                		</v-flex>
                		<v-flex xs12 md6>
                    		<v-text-field
                    		  	solo
                    		  	flat
                    		  	type="date"
                    		  	label="Конец периода"
                    		  	hide-details
                    		  	backgroundColor="#fdfdfd"
                    		  	@change="getItems"
                    		  	v-model="date_to"
                    		  	clearable
                    		>
                    			<template v-slot:prepend>
                    				<span>По</span>
                    			</template>
                    		</v-text-field>
                		</v-flex>
                	</v-layout>
                </v-card>
              </v-flex>
              <v-flex md3 v-if="$props.status[0] != 7">
                <v-card flat class="rounded-lg">
                  <v-select
                    prepend-icon="mdi-filter"
                    :items="deal_options"
                    item-text="text"
                    item-value="value"
                    v-model="deal_filter"
                    label="Фильтр"
                    solo
                    flat
                    backgroundColor="#fdfdfd"
                    hide-details
                    @change="getItems"
                    clearable
                  ></v-select>
                </v-card>
              </v-flex>
            	<v-flex md6 xs12 v-if="$props.status[0] != 7">
            		<v-card class="rounded-lg" outlined flat>
            			<v-card flat color="#fdfdfd" class="px-2 rounded-lg">
            				<v-chip-group center-active multiple v-model="status_group">
            					<template >
         							<v-chip 
         								v-for="(status, i) in status_options"
         								:key="i+1"
         								label
         								outlined
         								filter
         								:active-class="status.color_calendar+' '+status.color_calendar+'--text'"
         							>
         							  {{ status.title }}
         							</v-chip>
         						</template>
        					</v-chip-group>
            			</v-card>
            		</v-card>
            	</v-flex>
              <v-flex md3 xs12>
                <v-select
                  :items="subdivisions"
                  v-model="subdivision"
                  label="Подразделение"
                  v-if="auth_user.role_id == 1000"
                  solo
                  flat
                  item-text="title"
                  return-object
                  hide-details
                  backgroundColor="#fdfdfd"
                  required
                ></v-select>
              </v-flex>
            	<v-flex md3 xs12>
            		<v-card flat class="rounded-lg">
                  		<v-text-field
                  		 	prepend-icon="mdi-magnify"
                  		 	label="Поиск"
                  		 	solo
                  		 	flat
                  		 	hide-details
                  		 	backgroundColor="#fdfdfd"
                  		 	v-model="search"
                  		></v-text-field>
                	</v-card>
            	</v-flex>
            </v-layout>
          </v-container>
          <v-divider class="my-0"></v-divider>
          <v-data-table
            :items="items"
            :headers="table_headers"
            :search="search"
            color="transparent"
            class="rounded-lg"
            :mobile-breakpoint="100"
            :locale="$vuetify.lang.current"
            :loading="loading"
            :sort-by="['created']"
            :sort-desc="['DESC']"
            :expanded.sync="expanded"
            calculate-widths
          >
            <!-- ШАПКА ТАБЛИЦЫ -->
            <template v-slot:header.expanded="{ header }">
              <v-btn :color="selectedItems.length == items.length ? 'green' : 'grey darken-1' " icon x-small @click.stop="selectAll">
                <v-icon size="18" v-html="selectedItems.length == items.length ?  'mdi-checkbox-marked-outline' : 'mdi-checkbox-blank-outline'"></v-icon>
              </v-btn>
            </template>
            <template v-slot:header.created="{ header }"><span v-html="header.text"></span></template>
            <template v-slot:header.status="{ header }"><span v-html="header.text"></span></template>
            <template v-slot:header.customer.first_name="{ header }"><span v-html="header.text"></span></template>
            <template v-slot:header.customer.child_first_name="{ header }"><span v-html="header.text"></span></template>
            <template v-slot:header.customer.main_phone="{ header }"><span v-html="header.text"></span></template>
            <template v-slot:header.main_comment="{ header }"><span v-html="header.text"></span></template>

            <!-- СТРОЧКА ТАБЛИЦЫ -->
            <template v-slot:item="{ item }">
              <tr class="table-row font-weight-medium">
                <td class="px-2 text-center" @click.stop="item.status == 7 ? '' : selectItem(item)">
                  <v-btn :color="selectedItems.indexOf(item) == -1 ? 'grey darken-1' : 'green' " icon x-small :disabled="item.status == 7">
                    <v-icon size="18" v-html="selectedItems.indexOf(item) == -1 ? 'mdi-checkbox-blank-outline' : 'mdi-checkbox-marked-outline' "></v-icon>
                  </v-btn>
                </td>
                <td class="px-2" @dblclick.stop="goTo(item)">
                  <span class="caption">{{item.created_at}}</span>
                </td>
                <td class="px-2" @dblclick.stop="goTo(item)">
                  <v-tooltip top v-if="item.promoter != null">
                    <template v-slot:activator="{ on }">
                      <v-list-item class="px-0 text-center" v-on="on">
                        <v-list-item-title class="caption">
                          <a :href="'/admin/promoters/list/'+item.promoter_id" class="blue--text text--darken-3 font-weight-medium">{{item.promoter.code_opc}}</a>
                        </v-list-item-title>
                      </v-list-item>
                    </template>
                    <span class="caption">{{item.promoter.full_name}}</span>
                  </v-tooltip>
                </td>
                <td class="px-2" @dblclick.stop="goTo(item)">
                  <span class="caption">{{item.customer_full_name}}</span>
                </td>
                <td class="px-2" @dblclick.stop="goTo(item)">
                  <span class="caption">{{item.customer_child_full_name}}</span>
                </td>
                <td class="px-2" @dblclick.stop="goTo(item)">
                  <span class="caption">{{item.customer_age}}</span>
                </td>
                <td class="px-2" @dblclick.stop="goTo(item)">
                  <v-list-item class="px-0">
                    <v-list-item-content class="py-0">
                      <v-list-item-title class="caption">
                        <v-chip small :color="item.requester_status.color_calendar" label >
                          <v-icon @click.stop="setStatus(item)" size="12" left color="white" v-if="item.status != 7">mdi-sync</v-icon>
                          <span class="white--text" v-html="item.requester_status.title"></span>
                        </v-chip>
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </td>
                <td class="px-2" @dblclick.stop="goTo(item)">
                	<template v-if="item.status != 7">
                  		<v-list-item v-if="item.is_deal > 0" class="px-0">
                  		  <v-list-item-content class="py-0">
                  		    <v-list-item-title >
                            <v-icon v-if="item.status == 6" :color="item.confirmed == 1 ? 'green' : 'grey' " size="16" v-html="item.confirmed == 1 ? 'mdi-calendar-check' : 'mdi-calendar-blank-outline' "></v-icon>
                  		      <v-icon v-else size="16">mdi-phone</v-icon>
                  		      <span 
                  		        class="caption px-1 white--text"
                  		        v-html="item.status == 6 ? 'Запись' : 'Перезвонить' "
                  		        :class="item.status == 6 ? 'success' : 'warning' "
                  		      ></span>
                  		    </v-list-item-title>
                  		    <v-list-item-subtitle class="caption ">{{formatDate(item.deal_date)}} {{item.deal_time}}</v-list-item-subtitle>
                  		    <v-list-item-subtitle class="caption">
                  		      <a href="#" @click.stop="setDeal(item)" class="caption blue--text text--darken-3 font-weight-medium">Изменить</a>
                  		    </v-list-item-subtitle>
                  		  </v-list-item-content>
                  		</v-list-item>
                  		<a v-else href="#" @click.stop="setDeal(item)" class="caption blue--text text--darken-3 font-weight-medium">Установить</a>
                  	</template>
                </td>
                <td class="px-2" @dblclick.stop="goTo(item)">
                  <span class="caption">{{item.customer_main_phone}}</span>
                </td>
                <td class="px-2">
                  <v-list-item v-if="item.user != null" class="px-0">
                    <v-list-item-content class="py-0">
                      <v-list-item-title class="caption ">{{ item.user.full_name.split(' ')[0] }} {{ item.user.full_name.split(' ')[1] }} </v-list-item-title>
                      <v-list-item-subtitle class="caption" v-if="item.status != 7 && auth_user.role_id != 1004">
                        <a href="#" @click.stop="selectItemsUser(item)" class="caption blue--text text--darken-3 font-weight-medium">Изменить</a>
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-icon>
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn 
                            color="red" 
                            icon 
                            text
                            x-small
                            @click.stop="deleteItemUser(item)"
                            v-on="on"
                          >
                            <v-icon size="14">mdi-close</v-icon>
                          </v-btn>
                        </template>
                        <span>Снять ответственного</span>
                      </v-tooltip>
                    </v-list-item-icon>

                  </v-list-item>
                  <a v-else href="#" @click.stop="selectItemsUser(item)" class="caption blue--text text--darken-3 font-weight-medium">Назначить</a>
                </td>
              </tr>
            </template>

            <!-- ВСЕ ДЕЙСТВИЯ -->
            <template v-slot:body.append="{ headers }">
              <v-menu top :offset-x="true" :close-on-click="true">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on"
                    absolute
                    left
                    bottom
                    small
                    class="rounded-lg"
                    text
                  >
                    <v-badge left :color="selectedItems.length > 0 ? 'green' : 'primary' " offset-y="3">
                      <span slot="badge" >{{selectedItems.length}}</span> <!--slot can be any component-->
                      <span>Действие с выбранными</span>
                    </v-badge>
                  </v-btn>
                </template>
                <v-list dense dark color="primary">
                  <template v-if="auth_user.role_id != 1004">
                    <v-list-item @click.stop="selectItemsUser" :disabled="!(selectedItems.length > 0)" >
                      <v-list-item-title>Назначить ответственного</v-list-item-title>
                    </v-list-item>
                    <v-divider class="my-0"></v-divider>
                  </template>
                  <v-list-item @click.stop="confirm_dialog = true" :disabled="!(selectedItems.length > 0)">
                    <v-list-item-title>Подтвердить</v-list-item-title>
                  </v-list-item>
                  <v-divider class="my-0"></v-divider>
                  <v-list-item @click.stop="false_dialog = true" :disabled="!(selectedItems.length > 0)">
                    <v-list-item-title>Отметить ложными</v-list-item-title>
                  </v-list-item>
                  <v-divider class="my-0"></v-divider>
                  <v-list-item @click.stop="setDeal" :disabled="!(selectedItems.length > 0)">
                    <v-list-item-title>Установить дело</v-list-item-title>
                  </v-list-item>
                  <v-divider class="my-0"></v-divider>
                  <v-list-item @click.stop="setStatus" :disabled="!(selectedItems.length > 0)">
                    <v-list-item-title>Изменить статус</v-list-item-title>
                  </v-list-item>
                  <v-divider class="my-0"></v-divider>
                  <v-list-item @click.stop="deleteItems" :disabled="!(selectedItems.length > 0)">
                    <v-list-item-title>Удалить</v-list-item-title>
                  </v-list-item>
                  <v-divider class="my-0"></v-divider>
                  <v-list-item @click.stop="selectedItems = []" :disabled="!(selectedItems.length > 0)">
                    <v-list-item-title>Отменить выбор</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </template>

          </v-data-table>
        </v-card>
      </v-flex>
      <v-dialog v-model="tabledialog" width="95%">
        <tabledialog v-if="tabledialog" @submit="submitEdit" @close="tabledialog = !tabledialog" :item="selected"/>
      </v-dialog>
      <v-dialog v-model="status_dialog" max-width="500px">
        <v-card color="rgba(250, 250, 250)">
          <v-card-title class="pb-4" v-html="status_dialog_type == 'status' ? 'Изменить статус' : 'Установить дело' "></v-card-title>
          <v-card-text>
            <template v-if="status_dialog_type != 'deal' ">
            <v-select
              :items="status_options"
              item-text="title"
              item-value="id"
              v-model="new_status"
              label="Статус"
              solo
              dense
              :rules="rules"
              required
              flat
            >
              <template v-slot:item="{ item, on }">
                <v-list-item v-on="on" v-show="item.id != -1 && item.id != 7" >
                  <v-list-item-title>
                    <span v-html="item.title"></span>
                  </v-list-item-title>
                </v-list-item>
              </template>
            </v-select>
            <template v-if="new_status > 0 && new_status != 1 && new_status != 5 && new_status != 6">
              <v-card flat>
                <v-alert
                  outlined
                  type="warning"
                  prominent
                  border="right"
                >
                  <p class="my-0 mx-4">Перед сменой статуса, укажите дату и время следующего звонка</p>
                </v-alert>
              </v-card>
              <v-text-field
                label="Дата"
                v-model="deal_date"
                type="date"
                solo
                flat
                dense
                :rules="rules"
                required
              ></v-text-field>
              <v-text-field
                label="Время"
                v-model="deal_time"
                type="time"
                solo
                flat
                dense
                :rules="rules"
                required
              ></v-text-field>
            </template>
            <template v-if="new_status == 6">
              <v-card flat>
                <v-alert
                  outlined
                  type="success"
                  prominent
                  border="right"
                >
                  <p class="my-0 mx-4">Перед успешным закрытием сделки, укажите дату и время на которое клиент записался</p>
                </v-alert>
              </v-card>
              <v-text-field
                label="Дата"
                v-model="deal_date"
                type="date"
                solo
                flat
                dense
                :rules="rules"
                required
              ></v-text-field>
              <v-text-field
                label="Время"
                v-model="deal_time"
                type="time"
                solo
                flat
                dense
                :rules="rules"
                required
              ></v-text-field>
            </template>
            </template>
            <template v-else>
              <v-text-field
                label="Дата"
                v-model="deal_date"
                type="date"
                solo
                flat
                dense
                :rules="rules"
                required
              ></v-text-field>
              <v-text-field
                label="Время"
                v-model="deal_time"
                type="time"
                solo
                flat
                dense
                :rules="rules"
                required
              ></v-text-field>
            </template>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text small @click.stop="status_dialog = false">Отмена</v-btn>
            <v-btn color="primary" text small v-if="status_dialog_type == 'status' " @click.stop="editStatusRequesters" :loading="action_loading">Подтвердить</v-btn>
            <v-btn color="primary" text small v-if="status_dialog_type == 'deal' " @click.stop="editDealRequesters" :loading="action_loading">Подтвердить</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="false_dialog" max-width="480">
        <v-card color="rgba(250, 250, 250)">
          <v-card-title>Ложная заявка</v-card-title>
          <v-card-text>
            <v-card flat>
              <v-radio-group solo flat dense hide-details v-model="false_value" class="py-0">
                <v-card flat class="py-1 rounded-lg"></v-card>
                <v-radio
                  v-for="option in false_options"
                  :key="option.value"
                  :label="option.text"
                  :value="option.value"
                  solo
                  flat
                  dense
                  class="mx-2"
                ></v-radio>
                <v-card flat class="py-1 rounded-lg"></v-card>
              </v-radio-group>
            </v-card>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text small @click.stop="false_dialog = false">Отмена</v-btn>
            <v-btn color="primary" text small @click.stop="falseRequesters" :loading="action_loading">Подтвердить</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="delete_dialog" max-width="480">
        <v-card color="rgba(250, 250, 250)">
          <v-card-title>Удалить выбранные</v-card-title>
          <v-card-text>
            Подтвердите удаление выбранных заявок
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text small @click.stop="delete_dialog = false">Отмена</v-btn>
            <v-btn color="primary" text small @click.stop="submitDelete" :loading="action_loading">Подтвердить</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="confirm_dialog" max-width="480">
        <v-card color="rgba(250, 250, 250)">
          <v-card-title>Подтвердить записи</v-card-title>
          <v-card-text>
            Подтвердить выбранные записи
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text small @click.stop="confirm_dialog = false">Отмена</v-btn>
            <v-btn color="primary" text small @click.stop="submitConfirm" :loading="action_loading">Подтвердить</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-container>
  <snackbar />
</v-app>
</template>

<script> 
import {TheMask} from 'vue-the-mask'
import { dateParsed, dateVerbal, getDateTimeFromTimestamp, getTimestampFromDate } from '../../js/utils'
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'
import AdminPanel from '../snippets/AdminPanel'
import snackbar from '../snackbar'
import requester_notifications from './requester_notifications'
import tabledialog from '../tabledialog'

export default {
  name: 'requester_list',
  data () {
    return {
      search: '',
      loading: false,
      expanded: [],
      date_options: [
        { text: 'Дата заявки', value: 1 },
        { text: 'Перезвонить - дата', value: 2 },
        { text: 'Запись - дата', value: 3 },
      ],
      date_filter: 1,
      deal_options: [
        { text: 'Без назначенного дела', value: 1 },
        { text: 'С просроченным делом', value: 2 },
        { text: 'Без ответственного', value: 3 },
        { text: 'Содержит жалобу', value: 4 },
      ],
      deal_filter: '',
      false_options: [
        { text: 'Живут далее 50 км.', value: 1 },
        { text: 'Не тот клиент', value: 2 },
        { text: 'Ребенок инвалид', value: 3 },
        { text: 'Анкету заполнили без родителя', value: 4 },
        { text: 'Клиента заставили оставить данные', value: 5 },
        { text: 'Клиенту ничего не рассказывали про школу', value: 6 },
        { text: 'Лид заполнен не на родителя', value: 7 },
      ],
      false_value: '',
      selected_status: [],
      date_from: '',
      date_to: '',
      selectedItems: [],
      selected: {},
      tabledialog: false,
      false_dialog: false,
      status_dialog: false,
      action_loading: false,
      new_status: '',
      deal_date: '',
      deal_time: '',
      status_dialog_type: '',
      delete_dialog: false,
      status_group: [],
      notifications_filter: null,
      subdivision: {},
      confirm_dialog: false,
    }
  },
  props: {
    status: Array,
    user_id: Number,
    now: Boolean,
  },
  components: {TheMask, FieldAccess, FieldAccessButton, AdminPanel, tabledialog, snackbar, requester_notifications},
  mounted() {
    this.loading = true
    this.$store.dispatch('GET_AUTH_USER', { id: this.user_id }).then(res => {
      this.checkHeaders()
      this.getUsers()
      this.getSubdivisions()
    })
  },
  methods: {
    deleteItemUser(val) {
      let item = Object.assign({}, val)
      item.user = {}
      item.user_id = null
      this.selected = {}
      this.selected.items = [item]
      this.submitEdit()
    },
    getSubdivisions() {
      this.$store.dispatch('GET_CONFIGER_SUBDIVISIONS').then(res => {
        this.subdivision = this.subdivisions.find(el => el.id == this.auth_user.subdivision_id)
      })
    },
    selectAll() {
      if (this.selectedItems.length == this.items.length) this.selectedItems = []
      else this.selectedItems = this.items
    },
    showNotifications(val) {
      this.notifications_filter = val+1
      this.getItems()
    },
    submitConfirm() {
      this.action_loading = true
      this.selectedItems.map(selected_item => {
        if (selected_item.status == 6 && selected_item.confirmed == 0) {
          selected_item.confirmed = 1
        }
      })
      this.selected = {}
      this.selected.items = this.selectedItems
      this.submitEdit()
    },
  	submitDelete() {
  		this.action_loading = true
  		this.$store.dispatch('DELETE_REQUESTERS', this.selected).then(res => {
  			this.delete_dialog = false
  			this.getItems()
  		})
      .finally(() => (this.action_loading = false))
  	},
  	deleteItems() {
  		this.selected.items = this.selectedItems
  		this.delete_dialog = true
  	},
    setDeal(item) {
      this.selected = {}
      if (item.id > 0) this.selected.items = [item]
      else this.selected.items = this.selectedItems
      this.status_dialog_type = 'deal'
      this.status_dialog = true
    },
    setStatus(item) {
      this.selected = {}
      if (item.id > 0) this.selected.items = [item]
      else this.selected.items = this.selectedItems
      this.status_dialog_type = 'status'
      this.status_dialog = true
    },
    editStatusRequesters() {
      this.selected.status = this.new_status
      if (this.new_status > 0 && this.new_status != 1 && this.new_status != 5) {
        this.selected.deal_date = this.deal_date
        this.selected.deal_time = this.deal_time
      }
      this.submitEdit()
    },
    editDealRequesters() {
      this.selected.deal_date = this.deal_date
      this.selected.deal_time = this.deal_time
      this.submitEdit()
    },
    falseRequesters(item) {
      this.selected = {}
      let items = []
      if (item.id > 0) this.selected.items = [item]
      else {
        this.selectedItems.map(selectedItem => {
          selectedItem.is_false = this.false_value
          items.push(selectedItem)
        })
        this.selected.items = items
      }
      this.selected.is_false = this.false_value
      this.submitEdit()
    },
    submitEdit() {
      this.action_loading = true
      this.$store.dispatch('EDIT_REQUESTERS', this.selected).then(res => {
        this.new_status = ''
        this.deal_time = ''
        this.deal_date = ''
        this.status_dialog = false
        this.false_dialog = false
        this.tabledialog = false
        this.confirm_dialog = false
        this.getItems()
      })
      .finally(() => (this.action_loading = false))
    },
    selectItemsUser(item) {
      this.selected = {}
      let field = {
        text: __('requester.user'),
        val: 'user',
        items: this.users,
        headers: this.user_headers,
      }
      this.selected.field = field
      if (item.id > 0) this.selected.items = [item]
      else this.selected.items = this.selectedItems
      this.tabledialog = true
    },
    selectItem(item) {
      if (this.selectedItems.indexOf(item) == -1) this.selectedItems.push(item)
      else this.selectedItems.splice(this.selectedItems.indexOf(item), 1)
    },
    expand(item) {
      if (this.expanded.indexOf(item) == -1) { this.expanded.push(item) }
      else { this.expanded.splice(this.expanded.indexOf(item), 1) }
    },
    goTo(item) {
      let val = ''
      if (this.$props.status[0] == 3) { val = '/admin/requester/list/card/'+item.id }
      else { val = '/admin/requester/now/card/'+item.id }
      location.href = val
    },
    getItems(status) {
      let params = { user_id: this.$props.user_id }
      if (this.deal_filter != undefined && this.deal_filter != '') params.deal_filter = this.deal_filter
      if (this.selected_status.length > 0) params.status = this.selected_status
      else params.status = this.$props.status
      params.date = [this.date_from, this.date_to]
      params.date_from = this.date_from
      if (this.date_to != '' && this.date_from > this.date_to) this.date_to = this.date_from
      params.date_to = this.date_to
      params.date_filter = this.date_filter
      if (this.notifications_filter != undefined) params.notifications_filter = this.notifications_filter
      params._lang = this.locale
      params.subdivision_id = this.subdivision.id
      this.loading = true
      this.$store.dispatch('GET_REQUESTERS', params).then(res => { this.loading = false; this.selectedItems = [] })
      .catch(error => { this.loading = false })
    },
    getUsers() {
      this.$store.dispatch('GET_COMPANY_USERS', { user_id: this.user_id, _lang: this.locale, role_id: 1001 })
    },
    maskedPhone(val) {
      if (val.length == 10) { return '+7('+val[1]+val[2]+val[3]+')'+val[4]+val[5]+val[6]+'-'+val[7]+val[8]+'-'+val[9]+val[10] }
      else { return val }
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
      if (value != null) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      }
      else { return '0.00' }
    },
    checkHeaders() {
      this.table_headers.map(head => {
        if (head.text == head.title) {
          head.text = '<span class="no_translate">'+head.title+'</span>'
        }
      })
    },
  },
  watch: {
    subdivision(val) {
      console.log(val)
      if (val != undefined) {
        this.loading = true
        this.getItems()
      }
    },
  	status_group(val) {
  		this.selected_status = []
  		val.map(i => {
  			this.selected_status.push(this.status_options[i].id)
  		})
      this.loading = true
  		this.getItems()
  	},
    locale: function(val) {
      this.loading = true
      this.getItems()
    },
    items(val) {
      if (this.selectedItems.length > 0) {
        let new_selectedItems = []
        this.selectedItems.map(selectedItem => {
          if (selectedItem != undefined) {
            let new_selectedItem = this.items.find(el => el.id == selectedItem.id)
            new_selectedItems.push(new_selectedItem)
          }
        })
        this.selectedItems = new_selectedItems
      }
    }
  },
  computed: {
    subdivisions: {
      get() { return this.$store.state.configer_subdivisions.items }
    },
    users: {
      get() { return this.$store.state.configer_users.company_users },
      set(val) { this.$store.state.configer_users.company_users = val },
    },
    user_headers: {
      get() { return this.$store.state.configer_users.company_user_headers },
      set(val) { this.$store.state.configer_users.company_user_headers = val },
    },
    table_headers: {
      get() { return this.$store.state.requester.table_headers },
      set(val) { this.$store.state.requester.table_headers = val }
    },
    items: {
      get() { return this.$store.state.requester.items },
      set(val) { this.$store.state.requester.items = val }
    },
    auth_user: {
      get() { return this.$store.state.auth_user },
    },
    status_options: {
      get() { return this.$store.state.requester.status_options },
    },
    loading: {
      get() { return this.$store.state.loading },
      set(val) { this.$store.state.loading = val } 
    },
    locale: {
      get() { return this.$store.state.lang.lang } 
    }
  },
};
</script>

<style>
  
</style>