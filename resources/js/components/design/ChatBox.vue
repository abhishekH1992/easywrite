<template>
    <div class="chat-body" :class="{isTextarea : pageInfo.isTextarea}">
        <div class="wrapper" v-if="pageInfo.pretext && !pageInfo.isTextarea">
            <div class="chat">
                <div class="message">{{ pageInfo.pretext }}</div>
            </div>
        </div>
        <div class="wrapper" v-for="(chat, i) in list" :key="i" :class="{blueBackground: i % 2 !== 0}">
            <div class="chat" v-if="pageInfo.isFreechat || pageInfo.isSystem || showUserIcons">
                <div class="profile user" v-if="chat.user === `user` ">
                    <img src="/assets/images/user.svg">
                </div>
                <div class="profile ai" v-else>
                    <img src="/assets/images/bot.svg">
                </div>
                <div class="message" v-html="chat.msg"></div>
                <div class="copy">
                    <span @click="copytxt(chat.msg)">Copy</span>
                    <span @click="emailTxt(chat.msg)">Email</span>
                    <span @click="setTranslatePayload(chat.msg, i)">Translate</span>
                </div>
                <div class="copy-inline">
                    <span @click="copytxt(chat.msg)">Copy</span>
                    <span @click="setTranslatePayload(chat.msg, i)">Translate</span>
                    <span @click="emailTxt(chat.msg)">Email</span>
                </div>
            </div>
            <div class="chat" v-else>
                <div class="message" v-html="chat.msg"></div>
                <div class="copy">
                    <span @click="copytxt(chat.msg)">Copy</span>
                    <span @click="emailTxt(chat.msg)">Email</span>
                    <span @click="setTranslatePayload(chat.msg, i)">Translate</span>
                </div>
                <div class="copy-inline">
                    <span @click="copytxt(chat.msg)">Copy</span>
                    <span @click="setTranslatePayload(chat.msg, i)">Translate</span>
                    <span @click="emailTxt(chat.msg)">Email</span>
                </div>
            </div>
        </div>
        <div class="wrapper blueBackground" v-if="typing">
            <div class="chat">
                <div class="profile ai" v-if="pageInfo.isFreechat || pageInfo.isSystem || showUserIcons">
                    <img src="/assets/images/bot.svg">
                </div>
                <div class="message">typing<span>...</span></div>
            </div>
        </div>
        <div class="modal-mask" v-if="showModal">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <h4>Select Language</h4>
                    </div>  
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-6" v-for="(lang, key) in translateLanguage" :key="key">
                                <input type="radio" v-model="language" :value="{ code: lang.code, name: lang.name }"> {{ lang.name }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn theme-btn" @click="translate()">Translate</button>
                        <button class="btn theme-btn" @click="cancelTranslate()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            txtToTranslate: '',
            keyToTranslate: null,
            showModal: false,
            language: {
                code: 'sm',
                name: 'Samoan'
            },
        }
    },
    props: {
        pageInfo: {
            required: true,
        },
        typing: {
            required: true,
        },
        list: {
            required: true,
        },
        translateLanguage: {
            required: true,
        },
        showUserIcons: {
            required: true,
        }
    },
    methods: {
        copytxt(txt) {
            navigator.clipboard.writeText(txt);
        },
        emailTxt(txt) {
            var mailToLink = "mailto:?body=" + encodeURIComponent(txt);
            window.location.href = mailToLink;
        },
        setTranslatePayload(txt, key) {
            this.txtToTranslate = txt;
            this.keyToTranslate = key;
            this.showModal = true;
        },
        cancelTranslate() {
            this.txtToTranslate = '';
            this.keyToTranslate = null;
            this.showModal = false;
        },
        translate() {
            let payload = {
                txt: this.txtToTranslate,
                language: this.language,
                key: this.keyToTranslate,
            }

            this.$store.dispatch('chat/translate_chat', payload);
            this.showModal = false;
        }
    },
}
</script>