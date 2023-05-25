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
      this.$modal.show('dialog', {
        title: 'Delete',
        text: 'Are you sure you want to delete this item?',
        buttons: [
          {
            title: 'Yes',
            handler: () => {
              this.deleteAction(id)
            }
          },
          {
            title: 'Close',
            handler: () => {
              this.$modal.hide('dialog')
            }
          }
        ]
      })
    },
    deleteAction (id) {},
    readingTime(content) {
      const wpm = 200;
      const words = content.trim().split(/\s+/).length;
      const time = Math.ceil(words / wpm);
      return time
    },
    close () {
      this.$modal.hideAll()
    }
  }
}
