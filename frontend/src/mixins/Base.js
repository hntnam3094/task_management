export default {
  data () {
    return {
      formAdd: null,
      formEdit: null,
      formDetail: null,
      formDelete: null,
      modalProps: {
        width: '1000px'
      }
    }
  },
  methods: {
    openFormAdd () {
      this.$modal.show(this.formAdd, {}, this.modalProps)
    },
    openFormEdit (id) {
      let propsData = {
        params: {}
      }
      if (id) {
        propsData.params.id = id
      }
      this.$modal.show(this.formEdit, propsData, this.modalProps)
    },
    openFormDetail (id) {
      let propsData = {
        params: {}
      }
      if (id) {
        propsData.params.id = id
      }
      this.$modal.show(this.formDetail, propsData, this.modalProps)
    },
    deleteForm (id) {
      let propsData = {
        params: {}
      }
      if (id) {
        propsData.params.id = id
      }
      this.$modal.show(this.formDelete, propsData, {width: '400px'})
    }
  }
}
