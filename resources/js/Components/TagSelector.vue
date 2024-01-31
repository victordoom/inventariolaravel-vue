<template>
    <div>
      <select v-model="selectedTag" @change="addTag" class="tag-select block mt-1 w-full rounded-md form-input focus:border-indigo-600" style="width: 100%;">
        <option disabled value="">Select one or more</option>
        <option v-for="tag in availableTags" :key="tag" :value="tag">
          {{ tag }}
        </option>
      </select>
      <div v-for="(tag, index) in selectedTags" :key="index" class="tag">
        {{ tag }}
        <span @click="removeTag(index)" class="close-btn">×</span>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      modelValue: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        selectedTags: this.modelValue,
        availableTags: ["Rap", "Rock", "Classic"],
        selectedTag: ""
      };
    },
    watch: {
      modelValue(newValue) {
        this.selectedTags = newValue;
      },
      selectedTags(newSelectedTags) {
        this.$emit("update:modelValue", newSelectedTags);
      }
    },
    methods: {
      addTag() {
        if (this.selectedTag && !this.selectedTags.includes(this.selectedTag)) {
          this.selectedTags.push(this.selectedTag);
          this.selectedTag = "";
        }
      },
      removeTag(index) {
        this.selectedTags.splice(index, 1);
      }
    }
  };
  </script>
  
  <style>
  .tag {
    display: inline-block;
    margin: 0.25rem;
    padding: 0.25rem 0.5rem;
    background-color: #3490dc;
    color: #ffffff;
    border-radius: 0.25rem;
    cursor: pointer;
  }
  
  .close-btn {
    margin-left: 0.5rem;
    cursor: pointer;
  }
  </style>
  