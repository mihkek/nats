<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet-body">
                <div class="portlet light">
                    <table class="table table-striped table-advance dataTable">
                        <thead>
                        <tr>
                            <th>Дата и время занятия</th>
                            <th class="">Клиент</th>
                            <th class="text-center">Оценка</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="event in events" class="odd gradeX getDataId item-row" :class="event.statusCode">
                                <td>{{event.dateVerbal}}</td>
                                <td class="ava">
                                    <div>
                                        <img alt="" :src="event.person.avatar"></div>
                                    <div>
                                        <a :href="event.person.url" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку клиента">{{event.person.name}}</a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="hidden" v-if="event.review.rate > 0">{{ event.review.rate }}</span>
                                    <a href="/admin/orderer/now/card/100"
                                       data-toggle="tooltip"
                                       data-placement="left"
                                       :title="event.review.text"
                                    >
                                        <i class="fa fa-star" v-for="n in event.review.rate"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { dateParsed } from '../../js/utils';

    export default {
      props: [ 'model', 'model_id' ],
      data: () => ({
        events: [],
      }),
      async created() {
        const params = { status: ['completed', 'cancelled'] }
        if (this.model === 'firm') {
          params.directory_firm_id = this.model_id;
        } else if (this.model === 'customer') {
          params.customer_id = this.model_id;
        }
        const query = await axios.get('/api/calendar/events', {params});
        console.log(query.data.items);
        this.events = query.data.items.map((item) => {
          let person = {
            id: item.customer.id,
            name: item.customer.name,
            avatar: `/storage/avatars/customers/50x50.${item.customer.photo}`,
          }
          if (this.model === 'firm') {
            // something overridish
          }

          return {
            dateVerbal: dateParsed('full_time', item.datetime),
            url: item.url,
            start: item.datetime,
            style: {
              backgroundColor: item.status.color_calendar,
            },
            statusCode: item.status.code,
            person,
            review: item.review,
          }
        });
      }
    }
</script>
<style scoped lang="scss">
    .dataTable {
        .completed {
            background-color: #008800;
            color: white;
            A {
                color: white;
            }
        }

        .cancelled {
            background-color: #888888;
            color: white;
            A {
                color: white;
            }
        }
    }

</style>