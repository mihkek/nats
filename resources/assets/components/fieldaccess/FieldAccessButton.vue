<template>
    <v-tooltip top v-if="accessData.canAdmin">
        <template v-slot:activator="{ on }">
            <v-btn :color="buttonColor" icon x-small v-on="on" class="my-icon-btn" @click.stop="handleClick" :absolute="absolute" :style="absolute ? 'right: 20px; top: 20px;' : ''">
                <v-icon>mdi-settings</v-icon>
            </v-btn>
        </template>
        <span class="caption">Изменить настройки прав</span>
    </v-tooltip>
</template>
<script>
    export default {
      props: [ 
        'accessData', 
        'style',
        'absolute'
      ],
      name: 'FieldAccessButton',
      methods: {
        handleClick(e) {
          console.log('signalled');
          this.$parent.$emit('edit-access-open');
          this.$parent.$parent.$emit('edit-access-open');
        }
      },
      computed: {
        buttonColor: {
          get() {
            return this.accessData.isDefault  ? 'red darken-1' : 'blue darken-1';
          }
        }
      }
    };
</script>
