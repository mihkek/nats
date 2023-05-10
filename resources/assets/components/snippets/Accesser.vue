<template>
    <div class="accessor-field" @click.ctrl.prevent="editAccessOpen">
        <PseudoWrapper
                v-slot="{ accessData }"
                :accessData="accessData"
                @ragazzo="ragazzo"
        >
            <slot :accessData="accessData"></slot>
        </PseudoWrapper>
        <v-dialog v-model="dialog" max-width="600px">
            <AccesserEdit
                v-if="dialog"
                :field_name="field_name"
                @submit="editAccessSubmit"
                @close="dialog = !dialog"
            />
        </v-dialog>
    </div>
</template>
<script>
    import AccesserEdit from './AccesserEdit';
    import Vue from 'vue';


    const PseudoWrapper = Vue.component('PseudoWrapper', {
      props: [ 'accessData' ],
      render(h) {
        if (this.$scopedSlots.default) {
          return h(
            'div',
            this.$scopedSlots.default({ accessData: this.accessData })
          )
        } else {
          console.log('sada');
        }
      },
    });

    const Buttonazzo = Vue.component('Buttonazzo', {
      template: `<button @click="$parent.$parent.$emit('ragazzo')">buttonazzo!</button>`,
    });

    export default {
      components: { AccesserEdit, PseudoWrapper },
      props: [ 'model', 'field', 'field_name' ],
      data: () => ({
        dialog: false,
        crap: 'hitler',
        accessData: {
          canEdit: true,
          text: 'wro',
          component: Buttonazzo,
        }
      }),
      methods: {
        editAccessOpen: function(e) {
          this.dialog = !this.dialog;
        },
        editAccessSubmit: function (data) {

        },
        ragazzo: function() {
          console.log('ragaaaaxxa');
        }
      },
      render(h) {
        if (this.$scopedSlots.default) {
          return h(
            'div',
            this.$scopedSlots.default({ accessData: this.accessData })
          )
        }
      }
    }
</script>
