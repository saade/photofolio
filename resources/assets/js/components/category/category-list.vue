<template>
  <el-table
    :data="categoryItems.filter(data => !search || data.title.toLowerCase().includes(search.toLowerCase()))"
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
      label="Slug"
      prop="slug">
    </el-table-column>
    <el-table-column
      label="Qtd. portifólios"
      prop="portifolios_count">
    </el-table-column>
     <el-table-column
      label="Criado em">
      <template slot-scope="scope">
        {{ new Date(scope.row.created_at).toLocaleString() }}
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
    props: ['categories', 'editUrl', 'deleteUrl'],
    data() {
      return {
        search: '',
        categoryItems: Array.from(this.categories)
      }
    },

    methods: {
      handleEdit(category_id) {
        window.location.href = this.editUrl.replace('@category_id', category_id)
      },
      handleDelete(index, row) {
        this.$confirm('<b>Deletar uma categoria</b> fará com que todos os seus portifólios que pertencem á ela, fiquem sem nenhuma categoria. <b>Nenhum portifólio será deletado</b>. Continuar?', `Deletar categoria "${row.title}"?`, {
          confirmButtonText: 'Deletar',
          cancelButtonText: 'Cancelar',
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          axios.delete(this.deleteUrl.replace('@category_id', row.id))
            .then( response => {
              this.$message({
                message: 'Categoria deletada! Os portifólios que pertenciam à ela, agora estão sem categoria.',
                type: 'success',
                showClose: true,
                duration: 1500
              });
              this.categoryItems.splice(index, 1);
            })
            .catch( ({ response : { status, data } }) => {
              this.$message.error(data.message);
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