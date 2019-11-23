<template>
  <div @click="onConfirm()">
    <el-tooltip :enterable="false" class="item" popper-class="el-tooltip__popper--danger" effect="dark" content="Deletar" placement="top-start">
      <i class="el-icon-delete"></i>
    </el-tooltip>
  </div>
</template>

<script>
  export default {
    props: ['deleteUrl'],
    methods: {
      onConfirm() {
        this.$confirm('Deletar essa foto? Essa ação não pode ser desfeita!', 'Deletar esta foto?', {
          confirmButtonText: 'Deletar',
          cancelButtonText: 'Cancelar',
          type: 'warning'
        }).then(() => {
          this.onSubmit()
        }).catch(() => {
          this.$message({
            type: 'info',
            message: 'Cancelado'
          });          
        });
      },
      onSubmit() {
        axios.post(this.deleteUrl, { _method: 'delete' })
        .then( response => {
          this.$message({
            message: 'Foto deletada!',
            type: 'success',
            duration: 1500,
            showClose: true,
            onClose: function() { window.location.reload() }
          })
        })
        .catch( ({ response : { status, data } }) => {
          this.$message.error( status == 422 ? Object.values(data.errors)[0][0] : `[${status}] ${data.message}`);
        })
      }
    }
  }
</script>