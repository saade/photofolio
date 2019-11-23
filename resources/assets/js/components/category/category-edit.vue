<template>
  <el-form ref="form" :model="form" label-width="120px">
    <el-form-item label="Título" :class="{ 'is-error': !!errors.title }">
      <el-input prop="title" v-model="form.title" v-on:input="form.slug = slugify(form.title)"></el-input>
      <div v-if="!!errors.title" class="el-form-item__error position-relative">
        {{ errors.title[0] }}
      </div>
    </el-form-item>
    <el-form-item label="Slug" :class="{ 'is-error': !!errors.slug }">
      <el-input prop="slug" v-model="form.slug"></el-input>
      <div v-if="!!errors.slug" class="el-form-item__error position-relative">
        {{ errors.slug[0] }}
      </div>
    </el-form-item>
    <el-form-item class="justify-content-between">
      <el-button type="success" @click="onSubmit" :loading="submitting">Salvar Alterações</el-button>
      <el-button type="text" class="text-muted ml-5" @click="onCancel">Cancelar</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  const slugify = require('slugify')
  export default {
    props: ['category', 'cancelLink', 'formAction'],
    data() {
      return {
        submitting: false,
        errors: {},
        form: Object.assign({}, {
          title: '',
          slug: ''
        }, this.category)
      }
    },

    methods: {
      onSubmit() {
        this.submitting = true;
        this.errors = {};

        axios.post(this.formAction, { ...this.form, _method: 'patch' })
        .then(response => {
          this.$message({
            message: 'Alterações foram salvas!',
            type: 'success',
            duration: 1500,
            showClose: true
          });
        })
        .catch( ({ response : { status, data } }) => {
          if( status == 422 ){
            this.errors = data.errors
            this.$message.error('Por favor revise os erros abaixo e tente novamente.');
          } else {
            this.$message.error(data);
          }
        }).finally(() => {
          this.submitting = false;
        });
      },
      onCancel() {
        if( !_.isEqual(this.category, this.form) )
          this.$confirm('Cancelar a edição da categoria? Você tem alteracões não salvas.', 'Cancelar?', {
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