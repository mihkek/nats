<template>
<div>
  <v-card class="mb-3" flat outlined v-if="item.win_rate != undefined && (auth_user.role_id == 1000 || item.user_id == auth_user.id || item.win_rate.user.id == auth_user.id)">
    <v-list subheader>
    <v-subheader>Победитель аукциона <v-spacer></v-spacer><v-icon>mdi-trophy-award</v-icon></v-subheader>
      <v-list-item three-line>
        <v-list-item-avatar>
          <v-img 
            :src="item.win_rate.user.avatar == null ? '/storage/avatars/50x50.nophoto.png' : '/storage/avatars/48x48.'+item.win_rate.user.avatar">
          </v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title>{{item.win_rate.user.company_name}}</v-list-item-title>
          <v-list-item-subtitle>{{item.win_rate.user.email}}</v-list-item-subtitle>
          <v-list-item-subtitle>{{item.win_rate.user.phone}}</v-list-item-subtitle>
          <v-list-item-subtitle v-if="item.win_rate.user.company_check_file" style="overflow:visible;">
			<v-btn elevation="2" x-small class="my-1 success--text" :href="'/storage/proofs/'+item.win_rate.user.company_check_file" target="_blank"><v-icon size="18" color="success">mdi-check</v-icon><span class="ml-1">Результат проверки пользователя</span></v-btn>
		  </v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-action class="ma-1">
          <span class="success--text title" v-if="auth_user.role_id == 102">{{formatPrice(item.win_rate.price*item.size)}} ₽</span>
          <span class="grey--text subtitle-1" v-if="auth_user.role_id == 102">({{formatPrice(item.win_rate.price)}} ₽/{{item.unit}}</span>
          <span class="title" v-else>{{formatPrice(item.win_rate.price)}} ₽<span class="font-weight-light">/{{item.unit}}</span></span>
        </v-list-item-action>
      </v-list-item>
    </v-list>
  </v-card>

  <v-card class="mb-3" flat outlined v-if="item.win_rate != undefined && item.complete_reason !== null && item.complete_reason !== undefined">
    <v-list subheader>
    <v-subheader>Примечание <v-spacer></v-spacer><v-icon></v-icon></v-subheader>
      <v-list-item three-line>        
        <v-list-item-content>
          <v-list-item-title>{{item.complete_reason}}</v-list-item-title>     
        </v-list-item-content>        
      </v-list-item>
    </v-list>
  </v-card>
</div>
</template>
<script>
  export default {
    data: () => ({
    }),
    props: {
      item: Object,
    },
    computed: {
      auth_user: {
        get() { return this.$store.state.auth_user }
      },
    },
    created() {
    },
    mounted () {
    },
    methods: {
      formatDate(date) {
        if (!date) { return }
        else {
          const [ year, month, day ] = date.split('-')
          return day+'/'+month+'/'+year
        }
      },
      formatPrice(value) {
        let val = (value/1).toFixed(0)
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
      },
    },
    watch: {
    },
    computed: {
      auth_user: {
        get() { return this.$store.state.auth_user }
      }
    },
  };
</script>
