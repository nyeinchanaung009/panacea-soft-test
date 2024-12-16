<template>
    <file-pond
      ref="uploader"
      :server="server"
      :name="name"
      :files="files"
      class-name="my-pond"
      :allow-replace="!api"
      :label-idle="label"
      :accepted-file-types="acceptedFileType"
      :max-file-size="size"
      @init="handleFilePondInit"
      @removefile="removeFile"
      @updatefiles="onUpdateFiles"
    />
  </template>
  
  <script>
  import vueFilePond from 'vue-filepond';
  import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js';
  import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
  import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
  import 'filepond/dist/filepond.min.css';
  import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
  import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
  import FilePondPluginMediaPreview from 'filepond-plugin-media-preview';
  import 'filepond-plugin-media-preview/dist/filepond-plugin-media-preview.min.css';
  import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';
  
  const FilePond = vueFilePond(FilePondPluginFileValidateType,FilePondPluginFileValidateSize, FilePondPluginImagePreview,FilePondPluginFilePoster,FilePondPluginMediaPreview);
  export default {
      components:{FilePond},
      props:{
          api:{
              type:String,
              required:false
          },
          size:{
              type:String,
              default:'1MB'
          },
          name:{
              type:String,
              default:'uploader'
          },
          photo:{
              type:String,
              default:''
          },
          video:{
              type:String,
              default:''
          },
          label:{
              type:String,
              default:'Drag & Drop here...'
          },
          acceptedFileType:{
              type:String,
              default:'image/*'
          }
      },
      data(){
          return{
              server:null,
          };
      },
      computed:{
          files(){
              if(this.photo) {
                  return [ {
                      options: {
                          file: this.photo,
                          metadata: {
                              poster: this.photo,
                          },
                      },
                  }];
              } 
              if(this.video){
                  return [this.video];
              }
              return null;
          },
      },
  
      methods:{
          onUpdateFiles(files){
              let file=files[0]?.file;
              if(file) this.$emit('onUpload',file);
          },
          removeFile(){
              this.$emit('on-delete');
          },
          handleFilePondInit() {
              if(!this.api) return;
              this.server={
                  url:this.api,
                  process:{
                      onload: (jsonString) => {
                          let res=JSON.parse(jsonString);
                          this.$emit('after-upload',res.url);
                          return JSON.stringify({url:res.url});//revert payload
                      }
                  },
                  revert:{
                      headers:{
                          'content-type':'application/json'
                      }
                  }
              };
          },
      }
  };
  </script>
  
  <style>
  .filepond--root,
  .filepond--root .filepond--drop-label {
      height: 300px;
      @apply bg-slate-100 m-0;
  }
  .filepond--file-info-sub {
      display: none;
  }
  .filepond--credits{
      display: none;
  }
  </style>
  