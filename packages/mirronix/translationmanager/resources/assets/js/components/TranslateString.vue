<template>
    <div class="translate-string">
        <v-dialog v-model="dialog" max-width="640px" v-if="dialog">
            <v-card color="#fafafa">
                <v-form>
                    <v-card-title class="py-4">
                        Перевод {{ key }}
                    </v-card-title>
                    <v-card-text>
                        <v-card flat>
                            <v-container fluid grid-list-lg>
                                <v-text-field
                                    v-for="language in data.languages"
                                    key="language.id"
                                    outlined
                                    v-model="translations[language.id]"
                                    :label="language.name + ' => ' + language.id"
                                    :autofocus="currentLocale == language.id"
                                >
                                </v-text-field>
                            </v-container>
                        </v-card>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="black" small text class="font-weight-medium" @click.stop="$parent.$emit('close')">Отмена</v-btn>
                        <v-btn color="black" small text class="font-weight-medium" type="submit" @click.prevent="handleSubmit">Сохранить</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    const get = (p, o) => p.reduce((xs, x) => (xs && xs[x]) ? xs[x] : null, o);

    export default {
      components: { },
      data: () => ({
        dialog: true,
        key: false,
        currentLocale: 'ru',
        data: {},
        translations: {},

      }),
      async mounted() {
        this.key = this.$parent.key;
        this.currentLocale = this.$parent.currentLocale;
        const { data } = await axios.get(`/api/translation-manager/translation?key=${this.key}`);
        this.translations = data.translations;
        this.data = data;
      },
      methods: {
        handleSubmit() {
          // this.$parent.$emit('update', this.translations);
          const params = {key: this.key, translations: {}};
          this.data.languages.forEach((language) => params.translations[language.id] = this.translations[language.id]);
          axios.post('/api/translation-manager/translation', params);
          this.$parent.$emit('update', params.translations);
        }
      },
      watch: {
        data() {
          console.log('changed');

        }
      }
    }
</script>
