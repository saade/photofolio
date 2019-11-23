<template>
  <el-form ref="form" :model="form" label-width="120px">
    <el-row>
      <el-col :span="12">
        <el-form-item label="Título" :class="{ 'is-error': !!errors.title }">
          <el-input v-model="form.title" v-on:input="form.slug = slugify(form.title)"></el-input>
          <div v-if="!!errors.title" class="el-form-item__error position-relative">
            {{ errors.title[0] }}
          </div>
        </el-form-item>
      </el-col>
      <el-col :span="12">
        <el-form-item label="Slug" :class="{ 'is-error': !!errors.slug }">
          <el-input v-model="form.slug"></el-input>
          <div v-if="!!errors.slug" class="el-form-item__error position-relative">
            {{ errors.slug[0] }}
          </div>
        </el-form-item>
      </el-col>
    </el-row>
    <el-form-item label="Descricão">
      <el-input type="textarea" :autosize="{ minRows: 2, maxRows: 10}" v-model="form.description"></el-input>
    </el-form-item>
    <el-form-item label="Categoria" :class="{ 'is-error': !!errors.category_id }">
      <el-select v-model="form.category_id" placeholder="Selecione uma categoria">
        <template v-for="category in categories">
          <el-option :label="category.title" :value="category.id"></el-option>
        </template>
      </el-select>
      <div v-if="!!errors.category_id" class="el-form-item__error position-relative">
        {{ errors.category_id[0] }}
      </div>
    </el-form-item>
    <el-form-item label="Status" :class="{ 'is-error': !!errors.status }">
      <el-switch v-model="form.status"
        active-text="Publicado"
        active-value="published"
        inactive-text="Rascunho"
        inactive-value="draft"></el-switch>
        <div v-if="!!errors.status" class="el-form-item__error position-relative">
            {{ errors.status[0] }}
          </div>
    </el-form-item>
    <el-form-item class="justify-content-between">
      <el-button type="success" @click="onSubmit" :loading="submitting">Continuar para adicionar fotos</el-button>
      <el-button type="text" class="text-muted ml-5" @click="onCancel">Cancelar</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  const slugify = require('slugify')
  export default {
    props: ['categories', 'cancelLink', 'formAction', 'redirectUrl'],
    data() {
      return {
        submitting: false,
        errors: {},
        form: {
          title: '',
          slug: '',
          description: '',
          category_id: null,
          status: true,
        }
      }
    },

    methods: {
      onSubmit() {
        this.submitting = true;
        this.errors = {};

        axios.post(this.formAction, this.form)
        .then( response => {
          this.$message({
            message: 'Portifólio criado com sucesso! Você será redirecionado para adicionar as fotos.',
            type: 'success',
            duration: 3000,
            showClose: true,
            onClose: () => { window.location.href = this.redirectUrl.replace('@portifolio_id', response.data.id) }
          });
        })
        .catch( ({ response : { status, data } }) => {
          if( status == 422 ){
            this.errors = data.errors
          } else {
            this.$message.error(data);
          }
        }).finally(() => {
          this.submitting = false;
        });
      },
      onCancel() {
        if( [ this.form.title, this.form.slug, this.form.category, this.form.description ].map( item => item == '' ).includes(false) )
          this.$confirm('Cancelar a criação do portifólio?', 'Cancelar?', {
            distinguishCancelAndClose: true,
            confirmButtonText: 'Permanecer',
            cancelButtonText: 'Descartar Alterações'
          }).catch(action => {
            window.location.href = this.cancelLink
          });
        else
          window.location.href = this.cancelLink
      },
      slugify: text => slugify(text, {lower: true})
    }
  }
</script>