<template>
<BaseForm :form-name="isEdit ? 'Edit task' : 'Add task'">
  <div class="container mt-5 form-group-app">
    <div class="row">
      <div class="col-3">
        Name
      </div>
      <div class="col-6">
        <b-form-input v-model="dataForm.name" placeholder="Enter your task name"></b-form-input>
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

    <div v-if="isEdit" class="row">
      <div class="col-3" style="align-self: unset">
        Subtask
      </div>
      <div  class="col-4">
        <div
          v-if="dataForm.subTask && dataForm.subTask.length > 0"
          v-for="(item, index) in dataForm.subTask" :key="index">
          <div class="row" style="margin-bottom: 0px">
            <div class="col-11">
              <div class="row" style="margin-bottom: 0px">
                <div class="col-1">
                  {{ index + 1 }}.
                </div>
                <div class="col-11">
                  {{ item.name }}
                  <div>
                    <div style="font-size: 12px">{{ item.description }}</div>
                    <div style="font-size: 12px">({{ dateTimeFormat(item.startDate) }} ~ {{ dateTimeFormat(item.endDate) }})</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-1 d-flex justify-content-between">
              <i class="bi bi-pencil-square m-1 text-primary iconCustom" @click="openFormEditSubTask({id: item.id, taskId: dataForm.id})"></i>
              <i class="bi bi-check2-circle m-1 iconCustom" :class="item.status == 1 ? 'text-success' : ''" :title="item.status == 1 ? 'Done' : 'Processing'" @click="callApiDoneStatus(item.id)"></i>
              <i class="bi bi-x-circle m-1 iconCustom text-danger" @click="deleteSubtask(item.id)"></i>
            </div>
          </div>
        </div>
        <button v-if="dataForm.status != 1" class="btn btn-primary mt-2" @click="openFormAddSubTask(dataForm.id)">
          <i class="bi bi-plus-circle"></i>
        </button>
      </div>
    </div>

    <div class="row">
      <div class="col-3">
      </div>
      <div class="col-6 text-center">
        <button class="btn btn-success btn-sm m-2" :disabled="loadingSave" @click="save">Save</button>
        <button class="btn btn-danger btn-sm m-2" @click="close">Close</button>
      </div>
    </div>
  </div>
</BaseForm>
</template>

<script>
import BaseForm from "../common/BaseForm";
import Base from "../../mixins/Base";
import {EventBus} from "../app/EventBus";
import SubTaskForm from "./Subtask/SubTaskForm";
export default {
  name: "TaskForm",
  mixins: [Base],
  components: {
    BaseForm
  },
  data () {
    return {
      formAdd: SubTaskForm,
      formEdit: SubTaskForm,
      modalProps: {
        width: '50%',
        height: 'auto'
      },
      dataForm: {
        userId: '',
        name: '',
        description: '',
        startDate: '',
        endDate: '',
        subTask: []
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
  created() {
    EventBus.$on('reloadSubTask', this.loadDataForm);
  },
  destroyed() {
    EventBus.$off('reloadSubTask');
  },
  mounted() {
    this.dataForm.userId = this.getUserData.id
    if (this.isEdit) {
      this.loadDataForm()
    }
  },
  methods: {
    deleteSubtask (id) {
      this.loadingSave = true
      this.$api.delete('/task_child/' + id)
        .then(response => {
          this.loadDataForm()
          this.loadingSave = false
        })
        .catch(rej => {
          this.errors = rej.errors
          this.loadingSave = false
        })
    },
    callApiDoneStatus (id) {
      if (this.dataForm.status == 0) {
        this.loadingSave = true
        this.$api.post('/task_child/done/' + id)
          .then(response => {
            EventBus.$emit('reloadStatus')
            this.loadDataForm()
            this.loadingSave = false
          })
          .catch(rej => {
            this.errors = rej.errors
            this.loadingSave = false
          })
      }
    },
    openFormEditSubTask (params = {}) {
      let propsData = {
        params: {}
      }
      if (params) {
        propsData.params = params
      }
      this.$modal.show(this.formEdit, propsData, this.modalProps)
    },
    openFormAddSubTask (id) {
      let propsData = {
        params: {}
      }
      if (id) {
        propsData.params.taskId = id
      }
      this.$modal.show(this.formAdd, propsData, this.modalProps)
    },
    loadDataForm () {
      this.$api.get('/tasks/'+this.$attrs.params.id)
        .then(res => {
          this.dataForm = res.data
        }).catch(rej => {
        console.log(rej)
      })
    },
    save () {
      if (!this.isEdit) {
        this.loadingSave = true
        this.$api.post('/tasks', this.dataForm)
          .then(response => {
            EventBus.$emit('reloadData')
            this.close()
            this.loadingSave = false
          })
          .catch(rej => {
            this.errors = rej.errors
            this.loadingSave = false
          })
      } else {
        this.loadingSave = true
        this.$api.put('/tasks/' + this.dataForm.id, this.dataForm)
          .then(response => {
            EventBus.$emit('reloadData')
            this.close()
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
.iconCustom {
  cursor: pointer;  font-size: 20px
}
</style>
