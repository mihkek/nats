<template>
  <v-card flat outlined class="my-3">
    <v-card-title>
      График занятий
    </v-card-title>
    <v-divider class="my-0"></v-divider>
    <v-card-text style="background: #fdfdfd;" v-if="item.orderers != undefined && item.orderers.length > 0" class="pa-0">
      <v-list two-line class="py-0" color="#fdfdfd">
        <template v-for="(orderer, i) in item.orderers" > 
          <v-list-item :key="i" :href="'/admin/orderer/now/card/'+orderer.id" style="text-decoration: none !important;">
            <v-list-item-avatar color="primary" class="my-auto" size="24" style="border-radius: 50% !important;">
              <span class="white--text">{{i+1}}</span>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>
                {{orderer.customer_status}}
                {{orderer.discipline.title}}
              </v-list-item-title>
              <v-list-item-subtitle>
                {{orderer.directory_firm.full_name}}, {{orderer.directory_person.full_name}}
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-acicon>
              <span class="font-weight-bold">{{formatDate(orderer.date)}} {{orderer.time}}</span>
            </v-list-item-acicon>
          </v-list-item>
          <v-divider class="my-0"></v-divider>
        </template>
      </v-list>
    </v-card-text>
    <v-list two-line subheader color="#fdfdfd">
      <FieldAccess model="customer_group" field="edit_orders" :field_name="__('buttons.edit_orders')" v-slot="{ accessData }">
        <v-list-item dense class="text-center pt-2 px-0" style="min-height: 52px;">
          <v-list-item-content>
            <v-list-item-title>
              <v-btn color="green lighten-1" dark depressed class="rounded-btn" @click.stop="dialog = !dialog">
                <v-icon left>mdi-calendar-plus</v-icon> 
                <span>Назначить занятия</span>
              </v-btn>
            </v-list-item-title>
          </v-list-item-content>
          <v-list-item-icon class="ml-2 my-auto">
            <FieldAccessButton :accessData="accessData" />
          </v-list-item-icon>
        </v-list-item>
      </FieldAccess>
    </v-list> 
    <v-dialog v-model="dialog" scrollable max-width="90%">
      <v-card>
        <v-card-title>
          <span v-show="!(selected.id > 0)">График занятий</span>
          <span v-show="selected.id > 0">{{selected.title}}</span>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click.stop="dialog = !dialog" class="d-none d-md-flex">Закрыть</v-btn>
        </v-card-title>
        <v-divider class="my-0"></v-divider>
        <v-card-text class="pa-0" style="height: 75vh;">
          <template v-if="!(selected.id > 0)">
            <v-item-group active-class="primary">
            <v-container fluid>
              <v-row>
                <v-col
                  v-for="(item, i) in items" 
                  :key="i"
                  cols="12"
                  md="4"
                >
                  <v-item v-slot="{ active, toggle }">
                    <v-card
                      class="d-flex align-center pa-3"
                      height="200"
                      @click.stop="select(item)"
                      dark
                    >
                      <v-scroll-y-transition>
                        <div
                          class="display-1 flex-grow-1 text-center"
                        >
                          {{item.title}}
                        </div>
                      </v-scroll-y-transition>
                    </v-card>
                  </v-item>
                </v-col>
              </v-row>
            </v-container>
            </v-item-group>
          </template>
          <template v-else>
            <v-container fluid class="py-0">
              <v-layout row wrap v-for="(discipline, i) in selected.disciplines" :key="i">
                <v-flex xs12>
                  <v-divider class="mb-0 mt-3" v-if="i != 0"></v-divider>
                  <v-card flat tile color="#fdfdfd">
                    <v-subheader class="font-weight-bold blue--text">{{discipline.title}}</v-subheader>
                    <v-card-text>
                      <v-layout row wrap v-for="(item, j) in discipline.items" :key="j">
                        <v-flex md1 xs12 class="pa-1 text-right">
                          <v-subheader class="caption pa-0">
                            <v-spacer></v-spacer>
                            Занятие {{j+1}}
                            <v-spacer></v-spacer>
                          </v-subheader>
                        </v-flex>
                        <v-flex md3 xs7 class="pa-1">
                          <v-text-field
                            type="date"
                            label="Дата"
                            v-model="item.date"
                            solo
                            flat
                            dense
                            hide-details
                          ></v-text-field>
                        </v-flex>
                        <v-flex md2 xs5 class="pa-1">
                          <v-text-field
                            type="time"
                            label="Время"
                            v-model="item.time"
                            @input="j == 0 ? changeTime(item, discipline) : ''"
                            solo
                            flat
                            dense
                            hide-details
                          ></v-text-field>
                        </v-flex>
                        <v-flex md3 xs12 class="pa-1">
                          <v-autocomplete
                            v-model="item.directory_person"
                            return-object
                            :items="directory_people"
                            @change="j == 0 ? change(item, discipline) : ''"
                            item-text="full_name"
                            solo
                            flat
                            dense
                            hide-details
                            label="Педагог"
                          ></v-autocomplete>
                        </v-flex>
                        <v-flex md3 xs12 class="pa-1">
                          <v-autocomplete
                            v-model="item.directory_firm"
                            return-object
                            :items="directory_firms"
                            @change="j == 0 ? changeFirm(item, discipline) : ''"
                            item-text="full_name"
                            solo
                            flat
                            dense
                            hide-details
                            label="Помещение"
                          ></v-autocomplete>
                        </v-flex>
                      </v-layout>
                    </v-card-text>
                  </v-card>
                  <v-divider class="mb-0 mt-0" v-if="i != selected.disciplines.length - 1"></v-divider>
                </v-flex>
              </v-layout>
            </v-container>
          </template>
        </v-card-text>
        <v-divider class="my-0"></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click.stop="dialog = false" v-show="!(selected.id > 0)">Отменить</v-btn>
          <v-btn color="primary" text @click.stop="selected = {}" v-show="selected.id > 0">Назад</v-btn>
          <v-btn color="primary" text @click.stop="submit" :loading="loading">Подтвердить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>

<script>
import FieldAccess from '../fieldaccess/FieldAccess'
import FieldAccessButton from '../fieldaccess/FieldAccessButton'

export default {
  props: {
    item: Object,
  },
  data: () => ({
    dialog: false,
    loading: false,
    selected: {},
    items: [
      {
        id: 1,
        title: 'Модельное направление 1',
        disciplines: [
          { id: 1, title: 'Психология и этикет', qnt: 3, items: [] },
          { id: 2, title: 'Сценическая речь, риторика', qnt: 3, items: [] },
          { id: 3, title: 'Подиумный шаг', qnt: 10, items: [] },
          { id: 4, title: 'Стиль и визаж', qnt: 3, items: [] },
          { id: 5, title: 'Фото и видео позирование', qnt: 4, items: [] },
          { id: 6, title: 'Хореография', qnt: 5, items: [] },
        ]
      },
      {
        id: 1,
        title: 'Модельное направление 2',
        disciplines: [
          { id: 1, title: 'Психология и этикет', qnt: 3, items: [] },
          { id: 7, title: 'Фотосъемка - карта эмоций', qnt: 1, items: [] },
          { id: 2, title: 'Сценическая речь, риторика', qnt: 3, items: [] },
          { id: 8, title: 'Фотосъемка - модельные тесты', qnt: 1, items: [] },
          { id: 4, title: 'Стиль и визаж', qnt: 3, items: [] },
          { id: 9, title: 'Фотосъемка - портретная съемка', qnt: 1, items: [] },
          { id: 5, title: 'Фото и видео позирование', qnt: 4, items: [] },
          { id: 10, title: 'Фотосъемка - студийная съемка', qnt: 1, items: [] },
          { id: 3, title: 'Подиумный шаг', qnt: 10, items: [] },
          { id: 10, title: 'Фотосъемка - студийная съемка', qnt: 1, items: [] },
        ]
      },
      {
        id: 1,
        title: 'Актерское направление 1',
        disciplines: [
          { id: 1, title: 'Психология и этикет', qnt: 3, items: [] },
          { id: 11, title: 'Сценическое движение', qnt: 4, items: [] },
          { id: 5, title: 'Фото и видео позирование', qnt: 4, items: [] },
          { id: 12, title: 'Актерское мастерство', qnt: 17, items: [] },
        ]
      },
      {
        id: 1,
        title: 'Актерское направление 2',
        disciplines: [
          { id: 1, title: 'Психология и этикет', qnt: 3, items: [] },
          { id: 7, title: 'Фотосъемка - карта эмоций', qnt: 1, items: [] },
          { id: 11, title: 'Сценическое движение', qnt: 3, items: [] },
          { id: 8, title: 'Фотосъемка - модельные тесты', qnt: 1, items: [] },
          { id: 5, title: 'Фото и видео позирование', qnt: 4, items: [] },
          { id: 9, title: 'Фотосъемка - портретная съемка', qnt: 1, items: [] },
          { id: 13, title: 'Актерское мастерство', qnt: 17, items: [] },
          { id: 10, title: 'Фотосъемка - студийная съемка', qnt: 1, items: [] },
          { id: 14, title: 'Видеосъемка - видеовизитка', qnt: 1, items: [] },
        ]
      },
    ]
  }),
  components: { FieldAccess, FieldAccessButton },
  mounted() {
  },
  methods: {
    changeTime(item, discipline) {
      this.selected.disciplines.map(val => {
        if (val.id == discipline.id) {
          val.items.map(subitem => {
            subitem.time = item.time
          })
        }
      })
    },
    changeFirm(item, discipline) {
      this.selected.disciplines.map(val => {
        if (val.id == discipline.id) {
          val.items.map(subitem => {
            subitem.directory_firm = item.directory_firm
          })
        }
      })
    },
    change(item, discipline) {
      this.selected.disciplines.map(val => {
        if (val.id == discipline.id) {
          val.items.map(subitem => {
            subitem.directory_person = item.directory_person
          })
        }
      })
    },
    select(item) {
      this.selected = Object.assign({}, item)
      this.selected.disciplines.map(discipline => {
        let i = 0
        discipline.items = []
        while (i < discipline.qnt) { 
          let item = {}
          item.discipline_id = discipline.id
          discipline.items.push(item)
          i++
        }
      })
    },
    submit() {
      this.selected.customer_group_id = this.item.id
      this.loading = true
      this.$store.dispatch('ADD_CUSTOMER_GROUP_ORDERS', this.selected).then(res => {
        this.dialog = false
        this.$emit('refresh')
      })
      .finally(() => (this.loading = false))
    },
    getDirectoryFirms() {
      let params = {
        type: 1,
        user_id: this.auth_user.id,
        subdivision_id: this.item.subdivision_id
      }
      console.log(params)
      this.$store.dispatch('GET_DIRECTORY_FIRMS', params)
    },
    getDirectoryPeople() {
      let params = {
        user_id: this.auth_user.id,
        subdivision_id: this.item.subdivision_id
      }
      this.$store.dispatch('GET_DIRECTORY_PEOPLE', params)
    },
    formatDate(date) {
      if (!date) { return }
      else {
        const [ year, month, day ] = date.split('-')
        return day+'/'+month+'/'+year
      }
    },
  },
  watch: {
    auth_user(val) {
      
    },
    item(val) {
      if (val.id > 0) {
        this.getDirectoryPeople()
        this.getDirectoryFirms()
      }
    }
  },
  computed: {
    directory_people: {
      get() { return this.$store.state.directory_people.items }
    },
    directory_firms: {
      get() { return this.$store.state.directory_firms.items }
    },
    auth_user: {
      get() { return this.$store.state.auth_user }
    }
  }
};
</script>
