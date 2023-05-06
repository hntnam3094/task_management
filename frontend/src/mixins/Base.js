export default {
  data () {
    return {
      formAdd: null,
      formEdit: null,
      formDetail: null,
      formDelete: null,
      modalProps: {
        width: '70%',
        height: 'auto'
      },
      baseUrl: process.env.BASE_URL,
      defautlImage: 'https://www.energyfit.com.mk/wp-content/plugins/ap_background/images/default/default_large.png'
    }
  },
  methods: {
    getImageUrl (imageUrl) {
      if (imageUrl) {
        return this.baseUrl + imageUrl
      }
      return this.defautlImage
    },
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
      this.$modal.show(this.formDelete, propsData, {width: '400px', height: '150px'})
    },
    close () {
      this.$modal.hideAll()
    }
  }
}
