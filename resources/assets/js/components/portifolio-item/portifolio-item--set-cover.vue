<template>
  <div @click="is_cover || onConfirm()">
    <el-tooltip :enterable="false" class="item" :popper-class="is_cover ? 'el-tooltip__popper--success' : ''" effect="dark" :content="is_cover ? 'Esta é sua capa' : 'Definir como capa do portifólio'" placement="top-start">
      <i v-if="is_cover" class="el-icon-check"></i>
      <i v-else class="el-icon-picture-outline"></i>
    </el-tooltip>
  </div>
</template>

<script>
  export default {
    props: ['is_cover', 'editUrl'],
    methods: {
      onConfirm() {
        this.$confirm('Definir esta foto como capa do álbum?', 'Definir como capa?', {
          confirmButtonText: 'Definir',
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
        axios.post(this.editUrl, { ...{ 'is_cover': true }, _method: 'patch' })
        .then( response => {
          this.visible = false
          this.$message({
            message: 'Esta foto agora é a capa do álbum!',
            type: 'success',
            duration: 1500,
            showClose: true,
            onClose: function() { window.location.reload() }
          })
        })
        .catch( ({ response : { status, data } }) => {
          if( status == 422 ){
            this.$message.error( Object.values(data.errors)[0][0] );
          } else {
            console.error('onError', status, data);
            this.$message.error(`[${status}] ${data.message}`);
          }
        })
      }
    }
  }
</script>