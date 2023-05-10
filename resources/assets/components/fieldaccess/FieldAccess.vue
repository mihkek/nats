<template>
    <div class="accessor-field" @click.ctrl.prevent="editAccessOpen" v-if="fieldAccess.canShow">
        <FieldAccessWrapper
                v-slot="{ accessData }"
                :accessData="accessData"
                @edit-access-open="editAccessOpen"
        >
            <slot :accessData="accessData"></slot>
        </FieldAccessWrapper>
        <v-dialog v-model="dialog" max-width="640px" v-if="dialog">
            <FieldAccessEditAccess
                :model="model"
                :field="field"
                :field_name="field_name"
                @submit="editAccessSubmit"
                @close="dialog = !dialog"
            />
        </v-dialog>
    </div>
</template>
<script>
    import FieldAccessEditAccess from './FieldAccessEditAccess';
    import FieldAccessWrapper from './FieldAccessWrapper';

    const get = (p, o) => p.reduce((xs, x) => (xs && xs[x]) ? xs[x] : null, o);

    export default {
      components: { FieldAccessEditAccess, FieldAccessWrapper },
      props: [ 'model', 'field', 'field_name' ],
      data: () => ({
        dialog: false,
      }),

      async mounted() {
        if (this.fields === null) {
          this.$store.dispatch('GET_ACCESS_DATA');
        }
        if (!this.modelFields) {
          await this.$store.dispatch('GET_ACCESS_MODEL_FIELDS', { model: this.model });
        }
      },
      computed: {
        accessData: {
          get() {
            return this.fieldAccess;
          }
        },
        fieldAccess: {
          get() {
            const f = {
              canShow: false,
              canEdit: false,
              canAdmin: this.canAdmin,
              canSuper: this.canSuper,
              whoami: this.whoami,
              isDefault: !this.modelFields || typeof this.modelFields[this.field] === 'undefined' || this.isDefault(this.modelFields[this.field]),
              settings: this.editAccessOpen,
            };
            if (this.fields) {
              let fieldAccess =
                get([this.model, this.field], this.fields)
                || get([this.model, '*'], this.fields)
                || 'write';

              if (fieldAccess === 'write') {
                f.canShow = true;
                f.canEdit = true;
              } else if (fieldAccess === 'read') {
                f.canShow = true;
                f.canEdit = false;
              }
            }

            return f;
          }
        },
        fields: {
          get() {
            return this.$store.state.fieldaccess.fields
          }
        },
        modelFields: {
          get() {
            return this.$store.state.fieldaccess.modelFields[this.model];
          }
        },
        canAdmin: {
          get() {
            return this.$store.state.fieldaccess.canAdmin;
          }
        },
        canSuper: {
          get() {
            return this.$store.state.fieldaccess.canSuper;
          }
        },
        whoami: {
          get() {
            return this.$store.state.fieldaccess.whoami;
          }
        },
      },
      methods: {
        editAccessOpen: function(e) {
          this.dialog = !this.dialog;
        },
        editAccessSubmit: function (access) {
          this.dialog = !this.dialog;
          let snackbar = { status: 1, text: 'Данные успешно сохранены' }
          this.$store.commit('SET_SNACKBAR', snackbar)
        },
        isDefault(data) {
          console.log(data);
          console.log(Object.keys(data).reduce((acc, value) => value === 'write' ? acc : false, true));

          return Object.keys(data).reduce((acc, value) => data[value] === 'write' ? acc : false, true);
        }
      },
    }
</script>
