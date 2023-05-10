<template>
    <v-tooltip top v-if="canShow">
        <template v-slot:activator="{ on }">
            <v-btn :color="buttonColor" icon x-small v-on="on" class="my-icon-btn" @click.stop="handleClick">
                <v-icon>mdi-login</v-icon>
            </v-btn>
        </template>
        <span class="caption">Перелогиниться под данным пользователем</span>
    </v-tooltip>
</template>
<script>
    export default {
      props: [ 'accessData', 'id' ],
      name: 'FieldAccessReloginButton',
      methods: {
        async handleClick(e) {
          const {data} = await axios.post('/relogin', { id: this.id });
          if (data.success) {
            document.location.reload();
          }
        }
      },
      computed: {
        canShow: {
          get() {
            console.log('whoami');
            console.log(this.accessData.whoami);
            console.log(this.id);
            return this.accessData.canSuper && this.accessData.whoami != this.id;
          }
        },
        buttonColor: {
          get() {
            return 'blue darken-1';
            return this.accessData.isDefault  ? 'red darken-1' : 'blue darken-1';
          }
        }
      }
    };
</script>
