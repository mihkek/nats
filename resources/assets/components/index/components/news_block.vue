<template>
    <v-container fluid>
        <!-- HTML -->
        <v-card color="transparent" flat class="my-3">
            <v-card-title>
                <h1 class="my-0 display-1">Новости и события</h1>
                <v-spacer></v-spacer>
            </v-card-title>
        </v-card>
        <v-card flat color="transparent" class="mb-3">
            <v-flex xs12>
                <v-layout row wrap>
                    <v-flex md3 xs12 v-for="i in 4" :key="i">
                        <v-card
                          class="mx-auto"
                          max-width="400"
                        >
                          <v-img
                            class="white--text align-end"
                            height="200px"
                            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                          >
                            <v-card-title>Top 10 Australian beaches</v-card-title>
                          </v-img>

                          <v-card-subtitle class="pb-0">
                            Number 10
                          </v-card-subtitle>

                          <v-card-text class="text--primary">
                            <div>Whitehaven Beach</div>

                            <div>Whitsunday Island, Whitsunday Islands</div>
                          </v-card-text>

                          <v-card-actions>
                            <v-btn
                              color="primary"
                              text
                            >
                              Просмотр
                            </v-btn>
                          </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-card>
   </v-container>
</template>

<!-- CSS -->
<style>
    
</style>

<script> 
export default {
    name: 'news_block',
    data () {
        return {
        }
    },
    mounted() {
    },
    methods: {
    },
    props: {
    },
    components: {
    },
    computed: {
    },
};
</script>


