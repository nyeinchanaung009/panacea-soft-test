<template>
    <div>
      <div ref="editor" class="editor-container min-h-[300px] border border-gray-300"></div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted, watch } from 'vue';
  import Quill from 'quill';
  
  // Props
  defineProps({
    modelValue: {
      type: String,
      required: false,
      default: '',
    },
  });
  
  // Emit
  const emit = defineEmits(['update:modelValue']);
  
  // Quill Editor Instance
  const editor = ref(null);
  let quillInstance = null;
  
  // Initialize Quill
  onMounted(() => {
    quillInstance = new Quill(editor.value, {
      theme: 'snow',
      placeholder: 'Start typing...',
      modules: {
        toolbar: [
          [{ header: [1, 2, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ list: 'ordered' }, { list: 'bullet' }],
          ['link', 'image'],
          ['clean'], // Remove formatting
        ],
      },
    });
  
    // Set initial content
    quillInstance.root.innerHTML = modelValue;
  
    // Sync content changes
    quillInstance.on('text-change', () => {
      emit('update:modelValue', quillInstance.root.innerHTML);
    });
  });
  
  // Destroy Quill instance on unmount
  onUnmounted(() => {
    if (quillInstance) {
      quillInstance.off('text-change');
      quillInstance = null;
    }
  });
  
  // Watch for external updates to `modelValue`
  watch(
    () => modelValue,
    (newValue) => {
      if (quillInstance && newValue !== quillInstance.root.innerHTML) {
        quillInstance.root.innerHTML = newValue;
      }
    }
  );
  </script>
