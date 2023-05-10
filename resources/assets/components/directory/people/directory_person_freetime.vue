<template>
  <v-card flat color="#fff" tile>
    <v-container fluid grid-list-xl>
      <v-layout row wrap>
        <v-flex md6 xs12>
          <v-card color="transparent" flat>
            <ul class="list-group pl-0 ml-0 mb-0">
              <li class="list-group-item py-2" style="border-bottom: 0px;"></li>
                <v-list class="py-0" dense>
                  <FieldAccess model="directory_firm_freetime" field="add_new_note" :field_name="__('freetime.card_title')" v-slot="{ accessData }">
                    <v-list-item class="cardform-list-item pb-2" :class="accessData.canEdit ? 'pr-1' : ''">
                      <v-list-item-content class="inline-block" ><h4 class="font-weight-bold my-0" v-html="__('freetime.card_title')"></h4></v-list-item-content>
                      <v-list-item-icon class="ml-2 text-right mr-1">
                        <v-tooltip top v-if="accessData.canEdit">
                          <template v-slot:activator="{ on }">
                            <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="newBusy"><v-icon>mdi-plus</v-icon></v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.add_tooltip')"></span>
                        </v-tooltip>
                        <FieldAccessButton :accessData="accessData" />
                      </v-list-item-icon>
                    </v-list-item>  
                    <v-divider class="my-0"></v-divider>
                  </FieldAccess>
                  <template v-if="items.length > 0">
                    <template v-for="(time, i) in items">
                      <v-list-item class="cardform-list-item pr-1" :key="time.id">
                        <v-list-item-content class="body-2 inline-block">
                          <span v-html="time.week_label"></span>
                          <span v-if="time.type == 'once_week'"></span>
                          <span v-else><b>{{formatDate(time.date)}}</b></span>
                        </v-list-item-content>
                        <v-list-item-content class="body-2 inline-block text-right"><b>{{time.time_from}} - {{time.time_to}}</b></v-list-item-content>
                        <v-list-item-icon class="ml-2 text-right">
                          <v-tooltip top>
                            <template v-slot:activator="{ on }">
                              <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="editItem(time)"><v-icon>mdi-calendar</v-icon></v-btn>
                            </template>
                            <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                          </v-tooltip>
                          <v-tooltip top>
                            <template v-slot:activator="{ on }">
                              <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1" @click.stop="deleteItem(time)"><v-icon>mdi-minus-circle-outline</v-icon></v-btn>
                            </template>
                            <span class="caption" v-html="__('buttons.delete_tooltip')"></span>
                          </v-tooltip>
                        </v-list-item-icon>
                      </v-list-item>
                      <v-divider class="my-0" v-if="i != items.length - 1"></v-divider>
                    </template>
                  </template>
                  <template v-else>
                    <v-container class="text-center" style="border-left: 1px solid #ddd; border-right: 1px solid #ddd;">
                      <span v-html="__('freetime.empty')"></span>
                    </v-container>
                  </template>
   <!--                <FieldAccess model="directory_firm_freetime" field="note" field_name="Изменить строчку" v-slot="{ accessData }">
                    <v-list-item class="cardform-list-item" :class="accessData.canEdit ? 'pr-1' : ''">
                      <v-list-item-content class="body-2 inline-block">Понедельник</v-list-item-content>
                      <v-list-item-content class="body-2 inline-block text-right"><b>09:00 - 12:00</b></v-list-item-content>
                      <v-list-item-icon class="ml-2 text-right">
                        <v-tooltip top v-if="accessData.canEdit">
                          <template v-slot:activator="{ on }">
                            <v-btn color="red darken-1" icon x-small v-on="on" class="my-icon-btn mr-1"><v-icon>mdi-sync</v-icon></v-btn>
                          </template>
                          <span class="caption" v-html="__('buttons.edit_tooltip')"></span>
                        </v-tooltip>
                        <FieldAccessButton :accessData="accessData" />
                      </v-list-item-icon>
                    </v-list-item>
                  </FieldAccess> -->
                </v-list>
              <li class="list-group-item py-2" style="border-top: 0px;"></li>
            </ul>
          </v-card> 
        </v-flex>
      </v-layout>
      <v-dialog v-model="dialog" max-width="420px">
        <v-card color="#fafafa">
          <v-form :valid="valid">
            
        <v-card-title primary-title v-html="__('freetime.managment')"></v-card-title>
        <v-card-text>
          <v-container fluid grid-list-md class="px-0 py-0">
            <v-layout row wrap>
              <v-flex xs12>
                <v-select
                  outlined
                  :items="options"
                  item-value="id"
                  item-text="title"
                  v-model="selectedItem.type"
                  @change="changeType"
                  required
                >
                  <template v-slot:label><span v-html="__('freetime.type')"></span></template>
                  <template v-slot:item="{ item }"><span v-html="item.title"></span></template>
                  <template v-slot:selection="{ item }"><span v-html="item.title"></span></template>
                </v-select>
              </v-flex>
              <v-flex xs12>
                <template v-if="selectedItem.type == 'one_time'">
                  <v-text-field
                    v-model="selectedItem.date"
                    placeholder="##:##"
                    outlined
                    required
                    type="date"
                  >
                    <template v-slot:label><span v-html="__('freetime.date')"></span></template>
                  </v-text-field>
                </template>
                <template v-if="selectedItem.type == 'once_week'">
                  <v-select
                    outlined
                    :items="week_options"
                    item-value="id"
                    item-text="title"
                    v-model="selectedItem.week_day"
                    required
                  >
                    <template v-slot:label><span v-html="__('freetime.week_day')"></span></template>
                    <template v-slot:item="{ item }"><span v-html="item.title"></span></template>
                    <template v-slot:selection="{ item }"><span v-html="item.title"></span></template>
                  </v-select>
                </template>
              </v-flex>
              <v-flex xs6>
                <v-text-field
                  v-model="selectedItem.time_from"
                  placeholder="##:##"
                  outlined
                  required
                  v-mask="'##:##'"
                >
                  <template v-slot:label><span v-html="__('freetime.time_from')"></span></template>
                </v-text-field>
              </v-flex>
              <v-flex xs6>
                <v-text-field
                  v-model="selectedItem.time_to"
                  placeholder="##:##"
                  outlined
                  required
                  v-mask="'##:##'"
                >
                  <template v-slot:label><span v-html="__('freetime.time_to')"></span></template>
                </v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn small @click.stop="dialog = !dialog" text v-html="__('buttons.cancel')"></v-btn>
          <v-btn small color="primary" type="submit" @click.prevent="submit" text v-html="__('buttons.submit')"></v-btn>
        </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>
      <v-dialog v-model="delDialog" max-width="320px">
        <v-card color="#fafafa">
          <v-card-title primary-title v-html="__('forms.delete')"></v-card-title>
          <v-card-text><span v-html="__('forms.delete_text')"></span>{{item.name}}?</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text @click.stop="delDialog = !delDialog" small v-html="__('buttons.cancel')"></v-btn>
            <v-btn color="primary" text @click.stop="submitDelete" small v-html="__('buttons.delete')"></v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </v-card>
</template>

<script>
import FieldAccess from '../../fieldaccess/FieldAccess'
import FieldAccessButton from '../../fieldaccess/FieldAccessButton'
import { mask } from 'vue-the-mask'

export default {
  props: {
    item: Object,
  },
  data () {
    return {
      dialog: false,
      selectedItem: {},
      options: [
        { id: 'one_time', title: __('freetime.one_time'), text: 'freetime.one_time' },
        { id: 'once_week', title: __('freetime.once_week'), text: 'freetime.once_week' },
      ],
      week_options: [
        { id: 1, title: __('freetime.monday'), text: 'freetime.monday' },
        { id: 2, title: __('freetime.tuesday'), text: 'freetime.tuesday' },
        { id: 3, title: __('freetime.wednesday'), text: 'freetime.wednesday' },
        { id: 4, title: __('freetime.thursday'), text: 'freetime.thursday' },
        { id: 5, title: __('freetime.friday'), text: 'freetime.friday' },
        { id: 6, title: __('freetime.saturday'), text: 'freetime.saturday' },
        { id: 7, title: __('freetime.sunday'), text: 'freetime.sunday' },
      ],
      valid: false,
      delDialog: false,
      items: [],
    }
  },
  components: { FieldAccess, FieldAccessButton },
  mounted() {
    this.options.map(option => {
      if (option.title == option.text) {
        option.title = '<span class="no_translate">'+option.text+'</span>'
      }
    })
    this.week_options.map(option => {
      if (option.title == option.text) {
        option.title = '<span class="no_translate">'+option.text+'</span>'
      }
    })
    this.getItems()
  },
  watch: {
    busy_times: function (val) {
      this.items = val
      this.items.map(item => {
        this.week_options.map(option => {
          if (item.week_day == option.id) { item.week_label = option.title; item.week_day = Number(option.id) }
        })
      })
    }
  },
  methods: {
    deleteItem(item) {
      this.selectedItem = Object.assign({}, item)
      this.delDialog = true
    },
    editItem(item) {
      this.selectedItem = Object.assign({}, item)
      this.dialog = true
    },
    newBusy() {
      this.selectedItem = {}
      this.selectedItem.directory_person_id = this.item.id
      this.dialog = true
    },
    submit() {
      console.log(this.selectedItem)
      this.$store.dispatch('EDIT_DIRECTORY_PERSON_BUSY_TIME', this.selectedItem).then(res => {
        this.getItems()
      })
    },
    submitDelete() {
      this.$store.dispatch('DELETE_DIRECTORY_PERSON_BUSY_TIME', this.selectedItem).then(res => {
        this.getItems()
      })
    },
    getItems() {
      this.$store.dispatch('GET_DIRECTORY_PERSON_BUSY_TIMES', this.item).then(res => {
        this.dialog = false
        this.delDialog = false
      })
    },
    formatDate (date) {
      if (!date) return null
      const [year, month, day] = date.split('-')
      return `${day}.${month}.${year}`
    },
  },
  computed: {
    busy_times: {
      get() { return this.$store.state.directory_people.busy_times },
      set(val) { this.$store.state.directory_people.busy_times = val },
    }
  },
  directives: {  mask },
};
</script>
