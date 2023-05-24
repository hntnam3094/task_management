<template>
  <BaseForm :form-name="isEdit ? 'Edit sub task' : 'Add sub task'">
    <div class="container mt-5 form-group-app">
      <div class="row">
        <div class="col-3">
          Name
        </div>
        <div class="col-6">
          <b-form-input v-model="dataForm.name" placeholder="Enter your sub task name"></b-form-input>
          <errorr :errors="errors.name" />
        </div>
      </div>

      <div class="row">
        <div class="col-3">
          Description
        </div>
        <div class="col-6">
          <b-form-textarea
            v-model="dataForm.description"
            placeholder="Enter description"
            rows="3"
            max-rows="6"
          ></b-form-textarea>
        </div>
      </div>

      <div class="row">
        <div class="col-3">
          Date
        </div>
        <div class="col-6">
          <input v-model="dataForm.startDate" type="date">
          ~
          <input v-model="dataForm.endDate" type="date">
        </div>
      </div>

      <div class="row">
        <div class="col-3">
        </div>
        <div class="col-6">
          <errorr :errors="errors.startDate" />
          <errorr :errors="errors.endDate" />
        </div>
      </div>

      <div class="row">
        <div class="col-3">
        </div>
        <div class="col-6 text-center">
          <button class="btn btn-success btn-sm m-2" :disabled="loadingSave" @click="save">Save</button>
          <button class="btn btn-danger btn-sm m-2" @click="closeModal">Close</button>
        </div>
      </div>
    </div>
  </BaseForm>
</template>

<script>
import BaseForm from "../../common/BaseForm";
import Base from "../../../mixins/Base";
import {EventBus} from "../../app/EventBus";

export default {
  name: "SubTaskForm",
  mixins: [Base],
  components: {
    BaseForm
  },
  data () {
    return {
      dataForm: {
        taskId: '',
        name: '',
        description: '',
        startDate: '',
        endDate: '',
        status: 0
      },
      errors: {},
      loadingSave: false
    }
  },
  computed: {
    isEdit () {
      if (this.$attrs.params && this.$attrs.params.id) {
        return true
      }
      return false
    }
  },
  mounted() {
    this.dataForm.taskId = this.$attrs.params.taskId
    console.log(this.isEdit)
    if (this.isEdit) {
      this.loadDataForm()
    }
  },
  methods: {
    closeModal () {
      this.$emit('close')
    },
    loadDataForm () {
      this.$api.get('/task_child/'+this.$attrs.params.id)
        .then(res => {
          this.dataForm = res.data
        }).catch(rej => {
        console.log(rej)
      })
    },
    save () {
      if (!this.isEdit) {
        this.loadingSave = true
        this.$api.post('/task_child', this.dataForm)
          .then(response => {
            EventBus.$emit('reloadSubTask')
            this.closeModal()
            this.loadingSave = false
          })
          .catch(rej => {
            this.errors = rej.errors
            this.loadingSave = false
          })
      } else {
        this.loadingSave = true
        this.$api.put('/task_child/' + this.$attrs.params.id, this.dataForm)
          .then(response => {
            EventBus.$emit('reloadSubTask')
            EventBus.$emit('reloadStatus')
            this.closeModal()
            this.loadingSave = false
          })
          .catch(rej => {
            this.errors = rej.errors
            this.loadingSave = false
          })
      }
    }
  }
}
</script>

<style scoped>

</style>
