<template>
  <div @click="onConfirm">
    <el-tooltip :enterable="false" class="item" effect="dark" :content="is_hidden ? 'Mostrar foto' : 'Ocultar foto'" placement="top-start">
      <i v-if="is_hidden" class="far fa-eye"></i>
      <i v-else class="far fa-eye-slash"></i>
    </el-tooltip>
  </div>
</template>

<script>
  export default {
    props: ['is_hidden', 'editUrl'],
    methods: {
      onConfirm() {
        this.$confirm( this.is_hidden ? 'Mostrar essa foto no álbum?' : 'Ocultar essa foto do álbum?', `${ this.is_hidden ? 'Mostrar' : 'Ocultar' } foto?`, {
          confirmButtonText: this.is_hidden ? 'Mostrar' : 'Ocultar',
          cancelButtonText: 'Cancelar',
          type: 'warning'
        }).then(() => {
          this.onSubmit( !this.is_hidden )
        }).catch(() => {
          this.$message({
            type: 'info',
            message: 'Cancelado'
          });          
        });
      },
      onSubmit( is_hidden ) {
        axios.post(this.editUrl, { ...{ 'is_hidden' : is_hidden }, _method: 'patch' })
        .then( response => {
          this.visible = false
          this.$message({
            message: !is_hidden ? 'Esta foto será mostrada no álbum!' : 'Esta foto será ocultada do álbum!',
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