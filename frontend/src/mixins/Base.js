export default {
  data () {
    return {
      formAdd: null,
      formEdit: null,
      formDetail: null
    }
  },
  methods: {
    openFormAdd () {
      this.$modal.show(this.formAdd)
    },
    openFormEdit (id) {
      let propsData = {
        params: {}
      }
      if (id) {
        propsData.params.id = id
      }
      this.$modal.show(this.formEdit, { params: {id: id}})
    },
    openFormDetail (id) {
      this.$modal.show(this.formDetail, { id: id })
    },
    delete (id) {

    }
  }
}
