<template>
<div>
<h1>api </h1>




<div v-for="auction in auctions">
{{auction.auction.id}}
{{auction.auction.title}}
</div>


</div>
</template>

<script>
export default {
  data: () => ({
    auctions: []
  }),
  mounted() {
    this.getItems()
  },
  methods: {
   
        getItems() {
        
        let params = {
            date_filter: null,
            date_from: null,
            date_to: null,
            now: true,
            region: null,
            status: [1],
            type: "drop",
            user_id: 0,
            verb: null        
        }
        axios.post('/api/get_auctions', params).then(res => {
            this.auctions = res.data.auctions
        })
        
    },

  },
  computed: {
  
  },
  watch: {
   
  }
};
</script>
