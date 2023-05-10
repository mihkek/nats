<template>
    <div>
        <v-container class="calendar-controls">
            <v-row>
                <v-col md4 xs12>
                    <button @click="navigate('prev')" type="button" class="fc-today-button fc-button fc-button-primary">&larr;</button>
                    <button @click="navigate('next')" type="button" class="fc-today-button fc-button fc-button-primary">&rarr;</button>
                    <button type="button" class="fc-today-button fc-button fc-button-primary">Сегодня</button>
                </v-col>
                <v-col md4 xs12 align="center">
                    <h2>{{ calendarSpan }}</h2>
                </v-col>
                <v-col md4 xs12 align="right">
                    <button
                            v-for="cType in types"
                            :class="{'fc-button-active': cType.id === type}"
                            type="button"
                            class="fc-button fc-button-primary"
                            @click.prevent="setCalendarType(cType.id)"
                    >
                        {{cType.name}}
                    </button>
                </v-col>
            </v-row>
        </v-container>

        <v-sheet height="600">
            <v-calendar
                    ref="calendar"
                    v-model="value"
                    :hide-header="hideHeader"
                    :weekdays="weekday"
                    :type="type"
                    :events="events"
                    :event-overlap-mode="mode"
                    :event-overlap-threshold="30"
                    :event-color="getEventColor"
                    :interval-format="intervalFormat"
                    locale="ru"
                    @change="getEvents"
                    @moved="navigated"
                    @click:event="showEvent"
            ></v-calendar>
        </v-sheet>
    </div>
</template>
<script>
  import { dateParsed, dateVerbal, getDateTimeFromTimestamp, getTimestampFromDate } from '../../js/utils'

  export default {
    props: ['model', 'model_id'],
    data: () => ({
      value: null,
      events: [],
      type: 'month',
      types: [
        {id: 'month', name: 'Месяц'},
        {id: 'week', name: 'Неделя'},
        {id: 'day', name: 'День'},
      ],
      weekday: [1, 2, 3, 4, 5, 6, 0],
      mode: 'stack',
    }),
    computed: {
      hideHeader: function () {
        return this.type === 'day';
      },
      calendarSpan: function () {
        if (!this.value) return '';
        if (this.type === 'month') {
          return dateParsed('%F, %Y', this.value);
        } else if (this.type === 'week') {
          return dateParsed('%F, %Y', this.value);
        } else if (this.type === 'day') {
          return dateParsed('full', this.value);
        }
      }
    },
    methods: {
      setCalendarType: function (type) {
        this.type = type;
      },
      intervalFormat: function(interval) {
        console.log('------');
        console.log(interval);
        return interval.time;
      },
      navigate: function (where) {
        this.$refs.calendar[where]();
      },
      navigated: function (now) {
      },
      showEvent: function(e) {
        const { event } = e;
        if (event.url) {
          document.location.href = event.url;
        }
      },
      getEventColor: (event) => {
        return event.color;
      },
      async getEvents ({start, end}) {
        if (!this.model_id && this.model !== 'all') return;

        const params = { status: ['planned', 'moved' ] }
        if (this.model === 'firm') {
          params.directory_firm_id = this.model_id;
        } else if (this.model === 'customer') {
          params.customer_id = this.model_id;
        }

        const events = await axios.get('/api/calendar/events', {params});
        this.events = events.data.items
          .filter(item => item.customer && item.person)
          .map((item) => {
          let name = item.customer.full_name;
          if (this.model === 'firm') {
            name = 'Клиент: ' + item.customer.full_name;
          } else if (this.model === 'all') {
            name = `Клиент: ${item.customer.full_name}, преподаватель: ${item.person.full_name}`;
          }

          let endTime = item.endtime;
          if (!endTime) {
             endTime = getDateTimeFromTimestamp(getTimestampFromDate(item.datetime).getTime() / 1000 + 3600);
          }

          return {
            name,
            url: item.url,
            start: item.datetime,
            end: endTime,
            color: item.status.color_calendar,
          }
        });
      },
    },
    created() {
      this.value = getDateTimeFromTimestamp((new Date()).getTime() / 1000);
    }
  };
</script>

<style lang="scss">
    .v-event {
        padding: 2px 4px;
    }
    .v-event.green {
        background-color: green;
        color: white;
    }

    .v-event.red {
        background-color: red;
        color: white;
    }

    .calendar-controls {
        background-color: white;

        button {
            margin-right: 4px;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 0;
        }
    }
</style>
