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
      <el-button type="success" @click="onSubmit" :loading="submitting">Criar categoria</el-button>
      <el-button type="text" class="text-muted ml-5" @click="onCancel">Cancelar</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  const slugify = require('slugify')
  export default {
    props: ['cancelLink', 'formAction'],
    data() {
      return {
        submitting: false,
        errors: {},
        form: {
          title: '',
          slug: '',
        }
      }
    },

    methods: {
      onSubmit() {
        this.submitting = true;
        this.errors = {};

        axios.post(this.formAction, this.form)
        .then(response => {
          this.$message({
            message: 'Categoria criada com sucesso!',
            type: 'success',
            duration: 1500,
            showClose: true,
            onClose: function(){ window.location.reload() }
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
        if( [ this.form.title, this.form.slug, this.form.category, this.form.desc ].map( item => item == '' ).includes(false) )
          this.$confirm('Cancelar a criação da categoria?', 'Cancelar?', {
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