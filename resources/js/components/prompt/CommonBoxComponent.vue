<template>
    <div class="chatbox-container">
        <div class="chatbox-body">
            <chat-box-textarea/>
            <vue-editor/>
        </div>
    </div>
</template>
<script>
import ChatBoxTextarea from '../design/ChatBoxTextarea.vue'
import { VueEditor } from "vue3-editor";

export default {
    data() {
        return {
            // <vue-editor :editorToolbar="customToolbar"/>
            // customToolbar: [
            //     ["bold", "italic", "underline"],
            //     [{ list: "ordered" }, { list: "bullet" }],
            //     ["image", "code-block"]
            // ]
        };
    },
    components: {
        ChatBoxTextarea,
        VueEditor,
    },
}
</script>