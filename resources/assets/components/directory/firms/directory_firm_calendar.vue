<template>
  <v-card flat tile>
      <v-sheet height="64">
        <v-toolbar flat>
          <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday" v-html="__('calendars.today_label')"></v-btn>
          <v-btn fab text small color="grey darken-2" @click="prev"><v-icon small>mdi-chevron-left</v-icon></v-btn>
          <v-btn fab text small color="grey darken-2" @click="next"><v-icon small>mdi-chevron-right</v-icon></v-btn>
          <v-toolbar-title>{{calendarSpan}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-menu top right>
            <template v-slot:activator="{ on }">
              <v-btn outlined color="grey darken-2" v-on="on"><span v-html="typeToLabel[type]"></span><v-icon right>mdi-menu-down</v-icon></v-btn>
            </template>
            <v-list>
              <v-list-item @click="type = 'day'">
                <v-list-item-title><span :class="__('calendars.day_label') != 'calendars.day_label' ? '' : 'empty'" v-html="__('calendars.day_label')">{{__('calendars.day_label')}}</span></v-list-item-title>
              </v-list-item>
              <v-list-item @click="type = 'week'">
                <v-list-item-title><span :class="__('calendars.week_label') != 'calendars.week_label' ? '' : 'empty'" v-html="__('calendars.week_label')">{{__('calendars.week_label')}}</span></v-list-item-title>
              </v-list-item>
              <v-list-item @click="type = 'month'">
                <v-list-item-title><span :class="__('calendars.month_label') != 'calendars.month_label' ? '' : 'empty'" v-html="__('calendars.month_label')">{{__('calendars.month_label')}}</span></v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-toolbar>
      </v-sheet>
      <v-sheet height="600">
        <v-calendar
          ref="calendar"
          v-model="value"
          color="primary"
          :events="events"
          :event-color="getEventColor"
          :now="today"
          :type="type"
          :weekdays="[1,2,3,4,5,6,0]"
          @click:event="showEvent"
          @click:more="viewDay"
          @click:date="viewDay"
          @change="updateCalendar"
          :event-height="40"
          :event-overlap-mode="'column'"
          :event-overlap-threshold="120"
        >
          <template v-slot:event="{ event }">
            <v-card flat color="transparent" dark class="px-1">
              <span class="overline">{{event.time_from}} - {{event.time_to}}</span>
              <br>
              <span :class="event.name == 'directory_firm.busy' ? 'no_translate' : ''">{{event.name}}</span>
            </v-card>
          </template>
        </v-calendar>
        <v-menu
          v-model="selectedOpen"
          :close-on-content-click="false"
          :activator="selectedElement"
          top
          offset-x
          max-width="360px"
        >
          <v-card flat max-width="360px"> 
            <v-toolbar :color="selectedEvent.color" dark flat dense>
              <v-icon class="mr-4">mdi-information-outline</v-icon>
              <v-toolbar-title v-if="selectedEvent.date != undefined">{{formatDate(selectedEvent.date)}} {{selectedEvent.time}}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon @click.stop="selectedOpen = false" class="mr-0 ml-4" x-small><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
            <v-card-text>
              <v-list subheader>
                <v-list-item v-if="selectedEvent.customer != null">
                  <v-list-item-avatar>
                    <v-avatar size="50" color="transparent" class="profile-avatar">
                      <v-img v-if="selectedEvent.customer.avatar != null" :src="'/storage/avatars/150x150.'+selectedEvent.customer.avatar" alt="alt" ></v-img>
                      <v-img src='/storage/avatars/150x150.nophoto.png'  v-else></v-img>
                    </v-avatar>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>
                      <span :class="__('orderer.customer') != 'orderer.customer' ? '' : 'empty'" v-html="__('orderer.customer')"></span>
                    </v-list-item-subtitle>
                    <v-list-item-title>{{selectedEvent.customer.full_name}}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-divider class="my-3"></v-divider>
                <v-list-item v-if="selectedEvent.directory_person != null">
                  <v-list-item-avatar>
                    <v-avatar size="50" color="transparent" class="profile-avatar">
                      <v-img v-if="selectedEvent.directory_person.avatar != null" :src="'/storage/avatars/150x150.'+selectedEvent.directory_person.avatar"></v-img>
                      <v-img src='/storage/avatars/150x150.nophoto.png' style="border-radius: 50% !important;" v-else></v-img>
                    </v-avatar>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>
                    <v-list-item-subtitle>
                      <span :class="__('orderer.directory_person') != 'orderer.directory_person' ? '' : 'empty'" v-html="__('orderer.directory_person')"></span>
                    </v-list-item-subtitle>
                    </v-list-item-subtitle>
                    <v-list-item-title>{{selectedEvent.directory_person.full_name}}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-divider class="my-3"></v-divider>
                <v-list-item v-if="selectedEvent.directory_firm != null">
                  <v-list-item-avatar>
                    <v-avatar size="50" color="transparent" class="profile-avatar">
                      <v-img v-if="selectedEvent.directory_firm.avatar != null" :src="'/storage/avatars/150x150.'+selectedEvent.directory_firm.avatar"></v-img>
                      <v-img src='/storage/avatars/150x150.nophoto.png' style="border-radius: 50% !important;" v-else></v-img>
                    </v-avatar>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>
                      <span :class="__('orderer.directory_firm') != 'orderer.directory_firm' ? '' : 'empty'" v-html="__('orderer.directory_firm')"></span>
                    </v-list-item-subtitle>
                    <v-list-item-title>{{selectedEvent.directory_firm.full_name}}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item v-if="selectedEvent.additional_place != null">
                  <v-list-item-avatar v-if="selectedEvent.additional_place.avatar != null">
                    <v-avatar size="50" color="transparent" class="profile-avatar">
                      <v-img src="'/storage/avatars/additional_places/'+selectedEvent.additional_place.avatar" style="border-radius: 50% !important;"></v-img>
                    </v-avatar>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>
                      <span :class="__('orderer.directory_firm') != 'orderer.directory_firm' ? '' : 'empty'" v-html="__('orderer.directory_firm')"></span>
                    </v-list-item-subtitle>
                    <v-list-item-title>{{selectedEvent.additional_place.title}}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text :href="'/admin/orderer/now/card/'+selectedEvent.id" small>
                <span :class="__('buttons.follow_label') != 'orderer.follow_label' ? '' : 'empty'" v-html="__('buttons.follow_label')">{{__('buttons.follow_label')}}</span> <v-icon right small>mdi-share</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-menu>
      </v-sheet>
  </v-card>
</template>
<script>
  import { dateParsed, dateVerbal, getDateTimeFromTimestamp, getTimestampFromDate } from '../../../js/utils'
  export default {
    data: () => ({
      today: new Date().toISOString().substr(0, 10),
      value: null,
      type: 'month',
      typeToLabel: {
        month: __('calendars.month_label'),
        week: __('calendars.week_label'),
        day: __('calendars.day_label'),
      },
      start: null,
      end: null,
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
      events: [],
      colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
    }),
    props: {
      item: Object,
    },
    computed: {
      monthFormatter () {
        return this.$refs.calendar.getFormatter({
          timeZone: 'UTC', month: 'long',
        })
      },
      calendarSpan: function () {
        if (!this.value) return '';
        const [date, time] = this.value.split(' ')
        const [year, month, day] = date.split('-')
        if (this.type === 'month') {
          return `${month}.${year}`
        } else if (this.type === 'week') {
          return `${month}.${year}`
        } else if (this.type === 'day') {
          return `${day}.${month}.${year}`
        }
        //return dateParsed(`${month}.${year}`, this.value);
      },
      selectedEventTitle: function() {
        if (!this.selectedEvent.start) return '';
        return dateParsed('full', this.selectedEvent.start)
      },
      orderer_statuses: {
        get() { return this.$store.state.orderers.statuses }
      },
      auth_user: {
        get() { return this.$store.state.auth_user }
      },
      busy_times: {
        get() { return this.$store.state.directory_firms.busy_calendar_times },
        set(val) { this.$store.state.directory_firms.busy_calendar_times = val },
      }
    },
    created() {
      this.$store.dispatch('GET_ORDERER_STATUSES')
    },
    mounted () {
      this.$refs.calendar.checkChange()
      this.value = getDateTimeFromTimestamp((new Date()).getTime() / 1000);
    },
    methods: {
      viewDay ({ date }) {
        this.value = date
        this.type = 'day'
      },
      getEventColor (event) {
        return event.color
      },
      setToday () {
        this.value = this.today
      },
      prev () {
        this.$refs.calendar.prev()
      },
      next () {
        this.$refs.calendar.next()
      },
      showEvent ({ nativeEvent, event }) {
        if (event.disabled) { return null }
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          setTimeout(() => this.selectedOpen = true, 10)
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          setTimeout(open, 10)
        } else {
          open()
        }

        nativeEvent.stopPropagation()
      },
      getBusy() {
        this.$store.dispatch('GET_DIRECTORY_FIRM_BUSY_CALENDAR_TIMES', this.item).then(res => {
          this.busy_times.map(item => {
            this.events.push({
              name: __('directory_firm.busy'),
              start: item.start_datetime,
              end: item.end_datetime,
              color: '#333',
              date: item.date,
              hour: item.hour,
              minute: item.minute,
              time_from: item.time_from,
              time_to: item.time_to,
              disabled: true
            })
          })
        })
      },
      updateCalendar () {
        const events = []
        if (this.item.orderers != undefined) {
          this.item.orderers.map(orderer => {
            if (orderer.date_time != null) {
              events.push({
                id: orderer.id,
                name: orderer.order_status.name,
                time: orderer.time,
                time_from: orderer.time,
                time_to: orderer.time_to,
                start: orderer.date_time,
                end: orderer.end_date_time,
                color: orderer.order_status.color_calendar,
                directory_firm: orderer.directory_firm,
                directory_person: orderer.directory_person,
                customer: orderer.customer,
                additional_place: orderer.additional_place,
                status: orderer.order_status.title,
                date: orderer.date
              })
            }
          })
        }
        this.events = events
        this.getBusy()
        /*for (let i = 0; i < eventCount; i++) {
          const allDay = this.rnd(0, 3) === 0
          const firstTimestamp = this.rnd(min.getTime(), max.getTime())
          const first = new Date(firstTimestamp - (firstTimestamp % 900000))
          const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
          const second = new Date(first.getTime() + secondTimestamp)

          events.push({
            name: this.names[this.rnd(0, this.names.length - 1)],
            start: this.formatDate(first, !allDay),
            end: this.formatDate(second, !allDay),
            color: this.colors[this.rnd(0, this.colors.length - 1)],
          })
        }*/
      },
      nth (d) {
        return d > 3 && d < 21
          ? 'th'
          : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
      },
      rnd (a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
/*      formatDate (a, withTime) {
        return withTime
          ? `${a.getFullYear()}-${a.getMonth() + 1}-${a.getDate()} ${a.getHours()}:${a.getMinutes()}`
          : `${a.getFullYear()}-${a.getMonth() + 1}-${a.getDate()}`
      },*/
      formatDate (date) {
        if (!date) return null
        const [year, month, day] = date.split('-')
        return `${day}.${month}.${year}`
      },
      formatTime(val) {
        if (!val) return null
        const [date, time] = val.split(' ')
        return `${time}`
      }
    },
    watch: {
      item: function (val) {
        this.updateCalendar()
      },
    }
  };
</script>
