import Auth from "./Auth";
import errorr from "../components/common/errorr";
import moment from "moment";
export default {
  mixins: [Auth],
  components: {
    errorr
  },
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
  computed: {
    getUserData () {
      return this.userData
    }
  },
  methods: {
    dateTimeFormat (dateTime, format = '') {
      let formatDate = 'DD/MM/YYYY'

      if (format) {
        formatDate = format
      }

      return moment(dateTime).format(formatDate)

    },
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
