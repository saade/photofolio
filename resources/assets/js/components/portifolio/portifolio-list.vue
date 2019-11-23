<template>
  <el-table
    :data="portifolioItems.filter(data => !search || data.title.toLowerCase().includes(search.toLowerCase()))"
    style="width: 100%"
    stripe
    >
    <template v-slot:empty>
      <div class="my-5">
        <img src="/photofolio-assets?path=images/undraw.co/undraw_no_data_qbuo.svg" height="200">
        <h2 class="h6 title text-muted">Nenhum item</h2>
      </div>
    </template>
    <el-table-column
      label="#"
      prop="id"
      width="50px">
    </el-table-column>
    <el-table-column
      label="Título"
      prop="title">
    </el-table-column>
    <el-table-column
      label="Categoria">
      <template slot-scope="scope">
        <template v-if="!scope.row.category_id">
          <small class="text-muted">Sem categoria</small>
        </template>
        <el-tag
          v-else
          effect="plain"
          type="primary"
          disable-transitions>{{ !!scope.row.category_id ? scope.row.category.title : 'Sem categoria' }}</el-tag>
      </template>
    </el-table-column>
    <el-table-column
      label="Status">
      <template slot-scope="scope">
        <el-tag
          :type="{'draft': 'info', 'published': 'success'}[scope.row.status] || 'danger'"
          disable-transitions>{{ getPortifolioStatus(scope.row.status) }}</el-tag>
      </template>
    </el-table-column>
    <el-table-column
      label="Última edicão">
      <template slot-scope="scope">
        {{ new Date(scope.row.updated_at).toLocaleString() }}
      </template>
    </el-table-column>
    <el-table-column
      fixed="right"
      align="right"
      width="200">
      <template slot="header" slot-scope="scope">
        <el-input
          v-model="search"
          size="mini"
          placeholder="Digite para pesquisar"/>
      </template>
      <template slot-scope="scope">
        <el-button
          size="mini"
          @click="handleEdit(scope.row.id)">Editar</el-button>
        <el-button
          size="mini"
          type="danger"
          @click="handleDelete(scope.$index, scope.row)">Deletar</el-button>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
  export default {
    props: ['portifolios', 'editUrl', 'deleteUrl'],
    data() {
      return {
        search: '',
        portifolioItems: Array.from(this.portifolios)
      }
    },

    methods: {
      getPortifolioStatus( status ){
        switch(status){
          case 'draft':
            return 'Rascunho';
            break;
          case 'published':
            return 'Publicado';
            break;
          default:
            return '[erro]';
            break;
        }
      },
      handleEdit(portifolio_id) {
        window.location.href = this.editUrl.replace('@portifolio_id', portifolio_id)
      },
      handleDelete(index, row) {
        this.$confirm('Deletar um portifólio deleratá todas as imagens contidas nele. Continuar?', `Deletar ${row.title}?`, {
          confirmButtonText: 'Deletar',
          cancelButtonText: 'Cancelar',
          type: 'warning'
        }).then(() => {
          axios.delete(this.deleteUrl.replace('@portifolio_id', row.id))
            .then( response => {
              this.$message({
                message: 'Portifólio deletado!',
                type: 'success',
                showClose: true,
                duration: 1500
              });
              this.portifolioItems.splice(index, 1);
            })
            .catch( ({ response : { status, data } }) => {
              this.$message.error(data);
            })
          
        }).catch(() => {
          this.$message({
            type: 'info',
            message: 'Cancelado'
          });          
        });
      }
    }
  }
</script>