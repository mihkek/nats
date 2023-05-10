<template>
  <v-app>
    <v-main>
      <v-container fluid id="main" grid-list-xl class="px-0 py-0">
        <table class="table table-striped table-bordered">
          <thead>
          <tr>
            <td>ID</td>
            <td>Тендер</td>
            <td>Заблокированный поставщик</td>
            <td>Комментарий</td>
            <td>Опция</td>
          </tr>
          </thead>
          <tbody id="table">
          <tr v-for="sublier, index in subliers_data">
            <td>{{ sublier.id }}</td>
            <td>{{ sublier.auction_id }}</td>
            <td>{{ sublier.suplier_id }}</td>
            <td>{{ sublier.comment }}</td>
            <td>
              <button class="btn btn-success" @click="deleteSublier(index,sublier)">Разблокировать</button>
            </td>
          </tr>
          </tbody>
        </table>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: 'auction_list',
  data() {
    return {
      subliers_data: '',
    }
  },
  props: {
    user_id: Number,
    subliers: Object,
  },
  mounted() {
    axios.get('/admin/block-subliers-list/').then(response => {
      this.subliers_data = response.data.subliers
    }).catch(error => {
    });
  },
  methods: {
    deleteSublier(index, sublier) {
      var app = this;
      axios.get('/admin/block-subliers/delete/' + sublier.id).then(response => {
        app.subliers_data.splice(index, 1);
      }).catch(error => {
      });
    },
  },
  components: {},
  watch: {},
};
</script>
<style>
.custom-tooltip {
  margin-top: -3.5em;
}
</style>
