<template>
  <el-popover
    v-model="visible">
      <div @mouseleave="visible = false">
        <p>Qual formato deseja exibir esta foto?</p>
        <div class="d-flex align-items-center justify-content-around">
          <el-tooltip :enterable="false" class="item" effect="dark" content="Retrato" placement="top-start">
            <el-button icon="fas fa-portrait" style="font-size: 20px;" :class="{'el-button--primary': selectedLayout == 'portrait'}" @click="onSelect('portrait')"></el-button>
          </el-tooltip>
          <el-tooltip :enterable="false" class="item" effect="dark" content="Paisagem" placement="top-start">
            <el-button icon="fas fa-mountain" style="font-size: 20px;" :class="{'el-button--primary': selectedLayout == 'landscape'}" @click="onSelect('landscape')"></el-button>
          </el-tooltip>
          <el-tooltip :enterable="false" class="item" effect="dark" content="Quadrado" placement="top-start">
            <el-button icon="far fa-square" style="font-size: 20px;" :class="{'el-button--primary': selectedLayout == 'square'}" @click="onSelect('square')"></el-button>
          </el-tooltip>
          <el-tooltip :enterable="false" class="item" effect="dark" content="Quadrado Grande" placement="top-start">
            <el-button icon="fas fa-square" style="font-size: 20px;" :class="{'el-button--primary': selectedLayout == 'big-square'}" @click="onSelect('big-square')"></el-button>
          </el-tooltip>
          <el-tooltip :enterable="false" class="item" effect="dark" content="Aleatório" placement="top-start">
            <el-button icon="fas fa-random" style="font-size: 20px;" :class="{'el-button--primary': selectedLayout == 'random'}" @click="onSelect('random')"></el-button>
          </el-tooltip>
        </div>
        <div class="mt-4 d-flex justify-content-end w-100">
          <el-button type="success" size="mini" @click="onSubmit">Salvar</el-button>
        </div>
      </div>
      <template v-slot:reference>
        <div @click="visible = true">
          <el-tooltip :enterable="false" class="item" effect="dark" content="Alterar exibição" placement="top-start">
            <i v-if="selectedLayout == 'portrait'" class="fas fa-portrait"></i>
            <i v-else-if="selectedLayout == 'landscape'" class="fas fa-mountain"></i>
            <i v-else-if="selectedLayout == 'square'" class="far fa-square"></i>
            <i v-else-if="selectedLayout == 'big-square'" class="fas fa-square"></i>
            <i v-else-if="selectedLayout == 'random'" class="fas fa-random"></i>
            <i v-else class="el-icon-s-grid"></i>
          </el-tooltip>
        </div>
      </template>
  </el-popover>
</template>

<script>
  export default {
    props: ['layout', 'editUrl'],
    data() {
      return {
        visible: false,
        selectedLayout: this.layout
      }
    },
    methods: {
      onSelect( layout ) {
        this.selectedLayout = layout
      },
      onSubmit() {
        axios.post(this.editUrl, { ...{ 'grid_layout': this.selectedLayout }, _method: 'patch' })
        .then( response => {
          this.visible = false
          this.$message({
            message: 'Layout alterado com sucesso!',
            type: 'success',
            duration: 1500,
            showClose: true,
            onClose: function() { window.location.reload() }
          })
        })
        .catch( ({ response : { status, data } }) => {
          this.$message.error( status == 422 ? Object.values(data.errors)[0][0] : `[${status}] ${data.message}` );
        })
      }
    }
  }
</script>