<template>
    <div class="chat-body" :class="{isTextarea : pageInfo.isTextarea}">
        <div class="how-div" v-if="!list.length && !pageInfo.isTextarea && !showCourtForm">
            <h2>Welcome to chat by ARLO+</h2>
            <h5>How can I help you today?</h5>
        </div>
        <div class="court-form" v-if="showCourtForm">
            <h5 class="text-center">Select Country & Court</h5>
            <div class="row">
                <div class="form-group row mb-2">
                    <label class="pb-1">Country</label>
                    <div class="col-sm-12 pe-0">
                        <select class="form-control" v-model="selectedCountry" required>
                            <option value="" disabled selected>Select country</option>
                            <option v-for="(items, key) in countryCourtList" :key="key" :value="key">{{ key }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="pb-1">Court</label>
                    <div class="col-sm-12 pe-0">
                        <select class="form-control" v-model="selectedCourt" :disabled="!selectedCountry" multiple>
                            <option value="" disabled selected>Select court</option>
                            <option v-for="(items, key) in countryCourtList[selectedCountry]" :key="key" :value="items">{{ items }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <div class="col-sm-12 pe-0">
                        <button class="btn theme-btn" @click="setCountryCourtData()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper user-chat" v-if="pageInfo.pretext && !pageInfo.isTextarea">
            <div class="chat">
                <div class="message">{{ pageInfo.pretext }}</div>
            </div>
        </div>
        <div class="wrapper" v-for="(chat, i) in list" :key="i" :class="{'blueBackground':i % 2 !== 0,'user-chat':i % 2 == 0}">
            <div class="chat" v-if="pageInfo.isFreechat || pageInfo.isSystem || showUserIcons">
                <div class="profile user" v-if="chat.user === `user` ">
                    <img src="/assets/images/user.svg">
                </div>
                <div class="profile ai" v-else>
                    <span class="e-logo">a</span>
                </div>
                <div class="message">
                    <div v-html="chat.msg"></div>
                    <div class="pl-2" v-if="chat.source && chat.source.length">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header related-text-bold collapsed" id="headingOne">
                                    <button class="accordion-button related-text-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fa-solid fa-link me-2"></i>Source Urls
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body bg-white">
                                        <ul class="p-0">
                                            <li v-for="(source, key) in chat.source" :key="key" class="source-link">
                                                <p class="div-link m-0 py-2" @click="linkClicked(source.link)">{{ source.txt }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>       
                    </div>
                    <div class="pl-2" v-if="chat.related && chat.related.length">
                        <h4 class="related-text-bold my-2 pb-2 mt-4"><i class="fa-solid fa-layer-group me-2"></i>Related questions</h4>
                        <ul class="p-0 mb-4">
                            <li v-for="(related, key) in chat.related" :key="key" 
                                class="related-option py-2 flex justiy-between" @click="handleOptionClick(related)">
                                <span>{{ related }}</span> <i class="fa fa-plus"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="pl-2" v-if="chat.relatedUrl && chat.relatedUrl.length">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header related-text-bold" id="headingUrl">
                                    <button class="accordion-button related-text-bold collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapseUrl" aria-expanded="false" aria-controls="collapseUrl">
                                        <i class="fa-solid fa-link me-2"></i>Related Urls
                                    </button>
                                </h2>
                                <div id="collapseUrl" class="accordion-collapse collapse" aria-labelledby="headingUrl" data-bs-parent="#accordionExample">
                                    <div class="accordion-body bg-white">
                                        <ul class="p-0">
                                            <li v-for="(relatedUrl, key) in chat.relatedUrl" :key="key" class="source-link">
                                                <p class="div-link m-0 py-2" @click="linkClicked(relatedUrl.link)">{{ relatedUrl.txt }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>     
                    </div>
                    <div class="pl-2" v-if="chat.answer && chat.answer.length">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header related-text-bold" id="headingUrl">
                                    <button class="accordion-button related-text-bold collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapseUrl" aria-expanded="false" aria-controls="collapseUrl">
                                        <i class="fa-solid fa-link me-2"></i>Answer Sources
                                    </button>
                                </h2>
                                <div id="collapseUrl" class="accordion-collapse collapse" 
                                    aria-labelledby="headingUrl" data-bs-parent="#accordionExample">
                                    <div class="accordion-body bg-white accordion-ans-source">
                                        <ul class="p-0">
                                            <li v-for="(answer, key) in chat.answer" :key="key" class="source-link py-2">
                                                <h5 class="">{{ answer.title }}</h5>
                                                <p>{{ answer.snippet }}</p>
                                                <p class="div-link m-0" @click="linkClicked(answer.link)">{{ answer.link }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>     
                    </div>
                </div>
                <div class="copy">
                    <span @click="copytxt(chat.msg)">
                        <i class="far fa-copy" aria-hidden="true" title="Copy"></i>
                    </span>
                    <span @click="emailTxt(chat.msg)">
                        <i class="far fa-envelope" aria-hidden="true" title="Email"></i>
                    </span>
                    <span @click="setTranslatePayload(chat.msg, i)">
                        <i class="fa fa-language" aria-hidden="true" title="Translate"></i>
                    </span>
                </div>
                <div class="copy-inline">
                    <span @click="copytxt(chat.msg)"><i class="far fa-copy" aria-hidden="true" title="Copy"></i></span>
                    <span @click="setTranslatePayload(chat.msg, i)"><i class="fa fa-language" aria-hidden="true" title="Translate"></i></span>
                    <span @click="emailTxt(chat.msg)"><i class="far fa-envelope" aria-hidden="true" title="Email"></i></span>
                </div>
            </div>
            <div class="chat" v-else>
                <div class="message" v-html="chat.msg"></div>
                <div class="copy">
                    <span @click="copytxt(chat.msg)"><i class="far fa-copy" aria-hidden="true" title="Copy"></i></span>
                    <span @click="emailTxt(chat.msg)"><i class="far fa-envelope" aria-hidden="true" title="Email"></i></span>
                    <span @click="setTranslatePayload(chat.msg, i)"><i class="fa fa-language" aria-hidden="true" title="Translate"></i></span>
                </div>
                <div class="copy-inline">
                    <span @click="copytxt(chat.msg)"><i class="far fa-copy" aria-hidden="true" title="Copy"></i></span>
                    <span @click="setTranslatePayload(chat.msg, i)"><i class="fa fa-language" aria-hidden="true" title="Translate"></i></span>
                    <span @click="emailTxt(chat.msg)"><i class="far fa-envelope" aria-hidden="true" title="Email"></i></span>
                </div>
            </div>
        </div>
        <div class="wrapper blueBackground" v-if="typing">
            <div class="chat">
                <div class="profile ai" v-if="pageInfo.isFreechat || pageInfo.isSystem || showUserIcons">
                    <span class="e-logo">a</span>
                </div>
                <div class="message">
                    <div class="loader-outer">
                        <div class="loader-header"></div>
                        <div class="loader-body"></div>
                        <div class="loader-body"></div>
                        <div class="loader-body"></div>
                    </div>
                </div>
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
            picked: null,
            selectedCountry: null,
            selectedCourt: [],
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
            required: false,
        },
        showCourtForm: {
            required: false,
        },
        countryCourtList: {
            required: false,
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
        },
        linkClicked(link) {
            this.$emit('div-link', link);
        },
        handleOptionClick(option) {
            if (this.picked !== option) {
                this.$emit('related-question-selected', option);
            }
        },
        setCountryCourtData() {
            let data = {
                'country': this.selectedCountry,
                'court': this.selectedCourt
            };
            this.$emit('selected-country-court', data);
        }
    },
    watch: {
        picked(newValue, oldValue) {
            if(oldValue != newValue && newValue) 
                this.$emit('related-question-selected', newValue);
        },
        $route(to, from) {
            console.log(to, from);
        },
    }
}
</script>
