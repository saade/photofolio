<template>
  <div>
    <el-upload
      ref="upload"
      :action="formAction"
      list-type="picture-card"
      :auto-upload="false"
      multiple
      :on-change="onChange"
      :on-success="onSuccess"
      :on-error="onError"
      :headers="headers"
      :file-list="attachments"
      :http-request="doUpload"
      with-credentials
      accept=".jpg,.jpeg,.png"
      >
        <template v-slot:tip>
          <div class="my-3">
            <small class="text-muted"><i class="el-icon-info"></i>&nbsp;&nbsp;Selecione quantos arquivos quiser de até <b>10mb</b> cada.</small>
          </div>
        </template>
        <i slot="default" class="el-icon-plus"></i>
        <div slot="file" slot-scope="{file}">
          <img
            class="el-upload-list__item-thumbnail"
            :src="file.url" alt=""
          >
          <template v-if="file.percentage == 0">
            <span class="el-upload-list__item-actions">
              <span
                class="el-upload-list__item-preview"
                @click="handlePictureCardPreview(file)"
              >
                <i class="el-icon-zoom-in"></i>
              </span>
              <span
                v-if="!disabled"
                class="el-upload-list__item-delete"
                @click="handleRemove(file)"
              >
                <i class="el-icon-delete"></i>
              </span>
            </span>
          </template>
          <template v-else>
            <span class="el-upload-list__item-actions" style="opacity: 1">
              <el-progress type="circle" :percentage="file.percentage" :status="{ 'success' : 'success', 'error' : 'exception' }[file.status] || null"></el-progress>
            </span>
          </template>
        </div>
    </el-upload>
    <el-button class="my-4" type="success" @click="submitUpload">Enviar imagens</el-button>
    <el-dialog :visible.sync="dialogVisible">
      <img width="100%" :src="dialogImageUrl" alt="">
    </el-dialog>
  </div>
</template>

<script>
  export default {
    props: ['formAction'],
    data() {
      return {
        headers: {
          'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        attachments: [],
        dialogImageUrl: '',
        dialogVisible: false,
        disabled: false
      }
    },

    methods: {
      doUpload( http ) {
        const formData = new FormData;
        formData.append('file', http.file, http.file.name)

        axios.post( http.action, formData, {
          onUploadProgress: progressEvent => {
            const percent = Math.round( (progressEvent.loaded * 100) / progressEvent.total )
            progressEvent.percent = percent
            http.onProgress(progressEvent)
          }
        }).then( response => {
          http.onSuccess(response.data)
        })
        .catch( ({ response : { status, data } }) => {       
          http.onError({ status, data })
        })
      },
      onChange( file, fileList ) {
        this.attachments = fileList
      },
      onSuccess(response, file, fileList) {        
        this.$message({
          message: `Sucesso! Upload do arquivo <b>${file.name}</b> realizado com sucesso!.`,
          type: 'success',
          showClose: true,
          duration: 2000,
          dangerouslyUseHTMLString: true
        });
        setTimeout(() => {
          this.attachments.splice( this.attachments.findIndex( f => f.uid = file.uid) , 1);
        }, 1500)
      },
      onError(err, file, fileList) {
        this.$message({
          message: err.status == 422 ? `Erro! Falha ao realizar upload do arquivo <b>${file.name}</b>. ${err.data.errors.file[0]}` : `Erro! Falha ao realizar upload do arquivo <b>${file.name}</b>. ${err.data.message}`,
          type: 'error',
          showClose: true,
          duration: 10000,
          dangerouslyUseHTMLString: true
        });
      },
      submitUpload() {
        this.$refs.upload.submit();
      },
      handleRemove(file) {
        this.attachments.splice( this.attachments.findIndex( f => f.uid = file.uid) , 1);
      },
      handlePictureCardPreview(file) {
        this.dialogImageUrl = file.url;
        this.dialogVisible = true;
      }
    }
  }
</script>