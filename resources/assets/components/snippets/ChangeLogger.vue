<template>
    <ul class="list-group" v-if="changes">
        <li class="list-group-item small bg-default font-grey-cascade">
            ID
            <span>{{model_id}}</span>
            <div style="clear:both;"></div>
        </li>
        <li v-for="item in changes" class="list-group-item small bg-default font-grey-cascade">
            {{item.fields.join(', ')}}
            <span>{{item.createdVerbal}}</span>
            <div style="clear:both;"></div>
        </li>
    </ul>
</template>
<script>
    export default {
      props: [ 'model', 'model_id' ],
      data: () => ({
        changes: false,
        expanded: false,
      }),
      methods: {
        async getChanges() {
          try {
            const data = await axios.get(`/api/log-global/${this.model}/${this.model_id}/changes/`);
            this.changes = data.data;

          } catch (e) {
            console.log('error requesting');
          }
        }
      },
      computed: {
        items: () => {
          return this.expanded ? this.changes : this.changes.slice(0, 2)
        }
      },
      created() {
        this.getChanges();
      }
    }
</script>
<style scoped>

</style>