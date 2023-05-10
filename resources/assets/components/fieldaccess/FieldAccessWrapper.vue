<script>
    export default {
      name: 'FieldAccessWrapper',
      props: [ 'accessData' ],
      render(h) {
        if (this.$scopedSlots.default) {
          return h(
            'div',
            this.$scopedSlots.default({ accessData: this.accessData })
          )
        }
      },
    }

</script>