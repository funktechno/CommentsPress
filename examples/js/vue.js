Vue.component('comment-thread', {
    props: [
        'comment',
        'loading',
        'level',
        'is_guest',
        'user_data',
        'slug',
        "errors",
        "moderate_comments"
    ],
    data() {
        return {
            edit: false,
            showReply: false,
            body: null,
            showChildren: true,
            commentReply: null,
        }
    },
    computed: {
        pendingApproval() {
            return this.moderate_comments && this.comment.approved != '1';
        }
    },
    methods: {
        toggleEdit() {
            if (!this.edit) {
                this.body = this.comment.commentText
            }
            this.edit = !this.edit;
        },
        toggleReply() {
            if (!this.showReply) {
                // reset response on each toggle
                this.commentReply = {
                    text: ""
                }
            }
            this.showReply = !this.showReply;
        },
        updateComment() {
            if (this.loading)
                return;

            let config = {}
            if (this.user_data) {
                config = {
                    headers: {
                        Authorization: "Bearer " + this.user_data.token
                    }
                };
            }
            let request = {
                id: this.comment.id,
                body: this.body
            }

            this.$root.$emit("comment-loading", true);
            // this.loading = true;

            this.$http.post("/comments/?action=mod", request, config).then((response) => {
                // this.loading = false;
                this.$root.$emit("comment-loading", false);
                console.log(response)
                if (response.status == 200) {
                    // const commentData = JSON.parse(JSON.stringify(this.comment));
                    // commentData.commentText = this.body;
                    // for some reason fine to update prop data, maybe b/c not overriding directly but contents
                    this.comment.commentText = this.body;

                    // this.$emit("update:comment", commentData);
                } else {
                    // this.errors = "Failure in updating comment";
                    this.$root.$emit("global-error", "Failure in updating comment");
                }
            }).catch((error) => {
                // this.errors = "Failed to updating comment";
                this.$root.$emit("global-error", "Failed to update comment");
                console.log(error)
                // this.loading = false;
                this.$root.$emit("comment-loading", false);

            });
        },
        replyComment() {
            // don't run if not logged in or loading
            if (!this.is_guest && this.user_data == null || this.loading)
                return;
            let config = {}
            let request = {
                slug: this.slug,
                parentId: this.comment.id,
                body: this.commentReply.text
            }
            if (this.user_data) {
                config = {
                    headers: {
                        Authorization: "Bearer " + this.user_data.token
                    }
                };
            }
            if (this.is_guest) {
                request.guest = true;
            }
            // this.$emit("update:loading", true);
            this.$root.$emit("comment-loading", true);
            console.log(request)
            this.$http.post("/comments/?action=submit", request, config).then((response) => {
                this.$emit("update:loading", false);
                console.log(response)
                // this.message = response.data.message;
                if (response.status == 201) {
                    this.showReply = false;
                    console.log(response.data);
                    if (this.comment.children) {
                        this.comment.children.push(response.data);
                    } else {
                        this.comment.children = [response.data]
                    }
                } else {
                    this.$root.$emit("global-error", "Failed read new reply");
                }
            }).catch((error) => {
                // debugger;
                // data change up to root
                if (error && error.data && error.data.errors)
                    this.$root.$emit("global-error", error.data.errors);
                else
                    this.$root.$emit("global-error", "Failed to add reply");
                console.log(error)
                this.$emit("update:loading", false);
                this.$root.$emit("comment-loading", false);

            });
        }
    },
    template: `
<div :class="level == 0 ? 'root__thread' : 'thread_level_' + level" class="thread thread_theme_light thread_indented"
    role="listitem" aria-expanded="true">
    <article id="remark42__comment-01281c83-af78-455e-880b-dabe74fce317"
        :class="level == 0 ? '' :  'comment_level_' + level" class="comment comment_guest comment_theme_light "
        style="">
        <div class="comment__info">
            <img class="avatar-icon avatar-icon_theme_light comment__avatar" src="/images/no-image.png" alt="">
            <span role="button" tabindex="0" class="comment__username" :title="'anonymous_'+ comment.id">{{
                comment.displayName }}</span>
            <span role="button" v-if="pendingApproval"
                class="comment__score_view_negative">&nbsp;Pending Approval&nbsp;</span>
            <a class="comment__time">{{comment.updated_at}}</a>
            <a class="comment__link-to-parent" target="_blank" :href="'./comment/'+comment.parentId"
                aria-label="Go to parent comment" title="Go to parent comment">
            </a>
            <span class="comment__score">
                <span class="comment__vote comment__vote_type_up comment__vote_disabled" aria-disabled="true"
                    role="button" title="Sign in to vote">Vote up</span>
                <span class="comment__score-value" title="Controversy: 0.00">0</span>
                <span class="comment__vote comment__vote_type_down comment__vote_disabled" aria-disabled="true"
                    role="button" title="Sign in to vote">Vote down</span>
            </span>
        </div>
        <div class="comment__body">
            <div v-if="!edit" class="comment__text raw-content raw-content_theme_light" v-html="comment.commentText">
            </div>
            <div v-else class="comment-form__field-wrapper">
                <textarea id="textarea_1" class="comment-form__field" :readonly="loading" v-model="body"
                    placeholder="Your comment here" spellcheck="true" style="height: 109px;"></textarea>
                <button class="button button_kind_primary button_size_large comment-form__button"
                    v-on:click="updateComment()" type="submit">Send</button>
            </div>
            <div class="comment__actions">
                <button v-if="user_data && !pendingApproval" class="button button_kind_link comment__action" type="button" role="button" v-on:click="toggleReply"
                    tabindex="0">{{ showReply ? 'Cancel' : 'Reply' }}</button>
                <button class="button button_kind_link comment__action" type="button" role="button"
                    v-if="user_data && comment.userId == user_data.userInfo.id" v-on:click="toggleEdit()"
                    tabindex="0">Edit</button>
                <span v-if="comment.children && comment.children.length > 1" class="comment__controls"><button
                        class="button button_kind_link comment__control" type="button" role="button" tabindex="0"
                        v-on:click="showChildren = !showChildren">{{showChildren ? 'Hide':
                        'Show'}}</button></span>
            </div>
        </div>
        <div class="comment-form comment-form_theme_light comment-form_type_reply comment__input"
            aria-label="New comment" v-if="showReply">
            <div class="comment-form__field-wrapper">
                <textarea :id="'textarea_' + comment.id" v-model="commentReply.text" class="comment-form__field" placeholder="Your comment here" autofocus=""
                    spellcheck="true" style="height: 109px;"></textarea>
            </div>
            <div class="comment-form__actions">
                <div>
                    <button class="button button_kind_primary button_size_large comment-form__button"
                        v-on:click="replyComment"
                        type="submit">Reply</button>
                </div>
            </div>
        </div>
    </article>
    <comment-thread v-if="showChildren" :key="c.id" :moderate_comments="moderate_comments" :slug="slug"
        v-for="c in comment.children" :errors="errors" :loading="loading" :user_data="user_data" :is_guest="is_guest"
        :comment.sync="c" :level='level+1' />
    <div class="thread__collapse" role="button" tabindex="0">
        <div></div>
    </div>
</div>
    `
});

var app = new Vue({
    el: '#comments',
    name: "ExampleComponent",
    data: {
        pageSlug: null,
        newComment: {},
        chat: {},
        pageResult: null,
        example: "comments",
        status: null,
        form: {},
        threadId: null,
        conversations: [],
        loading: {
            general: false,
            comments: false,
            form: false,
            chat: false
        },
        userForm: {},
        modal: {
            type: 'email',
            signIn: false,
            chat: true
        },
        errors: null,
        userData: null,
        isGuest: false
    },
    filters: {
        date: function (str) {
            if (!str) { return '(n/a)'; }
            str = new Date(str);
            return str.getFullYear() + '-' + ((str.getMonth() < 9) ? '0' : '') + (str.getMonth() + 1) + '-' +
                ((str.getDate() < 10) ? '0' : '') + str.getDate();
        }
    },
    methods: {
        logout() {
            this.userData = null
            this.isGuest = false;
            this.getComments();
        },
        canComment() {
            if (this.pageResult && this.pageResult.page) {
                const page = this.pageResult.page;
                return page.lockedComments != '1' && (page.manualPages == "true" || page.exists);
            }
            return false;
        },
        submitMessage() {
            if (this.loading.form) {
                return;
            }
            this.errors = null;
            this.status = null;
            let request = JSON.parse(JSON.stringify(this.form));
            this.loading.form = true;
            this.$http.post("/form/?action=submit", request).then((response) => {
                this.loading.form = false;
                console.log(response)
                // this.message = response.data.message;
                if (response.status == 201) {
                    this.form = {};
                    console.log(response.data);
                    this.status = "Message Sent"
                } else {
                    this.errors = "Failed to submit message"
                }
            }).catch((error) => {
                this.errors = error.data
                console.log(error)
                this.loading.form = null;

            });


        },
        sendMessage() {
            if (this.loading.chat)
                return;
            // retrieve from cookie
            // will start from

            // let threadId = "effba2487ece11eb8e3a0242ac110002"
            let threadId = this.threadId;
            let config = {}
            let request = {
                threadId: threadId || null,
                message: this.chat.message
            }
            console.log(request);
            this.loading.chat = true;

            this.$http.post("/conversations/?action=submit", request, config).then((response) => {
                this.loading.chat = false;
                console.log(response)
                // this.message = response.data.message;
                if (response.status == 201) {
                    this.chat.message = "";
                    console.log(response.data);
                    this.threadId = response.data.threadId;
                    Cookies.set('thread', this.threadId, { expires: 7, path: '' })
                    this.conversations.push(response.data);
                    // this.$set()
                    // this.comments = response.data;
                } else {
                    this.errors = "Failed to send message"
                }
            }).catch((error) => {
                this.errors = error.data
                console.log(error)
                this.loading.chat = null;

            });
        },
        addComment() {
            // don't run if not logged in or loading
            if (!this.isGuest && this.userData == null || this.loading.general)
                return;
            let config = {}
            let request = {
                slug: this.pageSlug,
                body: this.newComment.text
            }
            if (this.userData) {
                config = {
                    headers: {
                        Authorization: "Bearer " + this.userData.token
                    }
                };
            }
            if (this.isGuest) {
                request.guest = true;
            }
            this.loading.general = true;

            this.$http.post("/comments/?action=submit", request, config).then((response) => {
                this.loading.general = false;
                console.log(response)
                // this.message = response.data.message;
                if (response.status == 201) {
                    this.newComment.text = "";
                    console.log(response.data);
                    this.pageResult.comments.push(response.data);
                    // this.$set()
                    // this.comments = response.data;
                } else {
                    this.errors = "Failed read new comment"
                }
            }).catch((error) => {
                // TODO; make error parse a standard function
                if (error && error.data && error.data.errors)
                    this.errors = error.data.errors;
                else
                    this.errors = "Failed to add comment"
                console.log(error)
                this.loading.general = null;

            });
        },
        updateLoadingComment(n) {
            this.loading.comments = n;
        },
        updateErrors(n){
            this.errors = n;
        },
        login() {
            if (this.isGuest || this.userData != null)
                return;
            if (this.modal.type == 'anonymous') {
                this.isGuest = true;
            } else {
                console.log(this.userForm)
                let request = {
                    email: this.userForm.email,
                    password: this.userForm.password
                }
                this.errors = null;
                console.log(request)
                this.loading.general = true;
                this.$http.post("/users/?action=login", request).then((response) => {
                    this.loading.general = false;
                    console.log(response)
                    // this.message = response.data.message;
                    if (response.status == 200) {
                        console.log(response.data)
                        this.userData = response.data;
                        // update comments
                        this.getComments();
                    } else {
                        this.errors = "Failed to login"
                    }
                }).catch((error) => {
                    this.errors = error.data
                    console.log(error)
                    this.loading.general = null;

                });
            }
            this.modal.signIn = false;
        },
        getConversation() {
            // check from cookie for conversation id
            let threadId = this.threadId;
            // "effba2487ece11eb8e3a0242ac110002"
            this.loading.chat = true;
            this.errors = null;
            let config = {}
            if (this.userData) {
                config = {
                    headers: {
                        Authorization: "Bearer " + this.userData.token
                    }
                };
            }
            this.$http.post("/conversations/?action=get", { "threadId": threadId }, config).then((response) => {
                this.loading.chat = false;
                console.log(response)
                // this.message = response.data.message;
                if (response.status == 200) {
                    console.log(response.data)
                    this.conversations = response.data;
                } else {
                    this.errors = "Failed to load chat"
                }
            }).catch((error) => {
                this.errors = "Failed to get chat"
                console.log(error)
                this.loading.chat = null;

            });

        },
        getComments() {
            this.loading.comments = true;
            this.errors = null;
            let config = {}
            if (this.userData) {
                config = {
                    headers: {
                        Authorization: "Bearer " + this.userData.token
                    }
                };
            }
            this.$http.post("/comments/?action=get", { "slug": this.pageSlug }, config).then((response) => {
                this.loading.comments = false;
                console.log(response)
                // this.message = response.data.message;
                if (response.status == 200) {
                    console.log(response.data)
                    this.pageResult = response.data;
                } else {
                    this.errors = "Failed to load page comments"
                }
            }).catch((error) => {
                this.errors = "Failed to get page comments"
                console.log(error)
                this.loading.pageResult = null;

            });
        }
    },
    mounted() {
        const urlSearchParams = new URLSearchParams(window.location.search);
        const params = Object.fromEntries(urlSearchParams.entries());
        if (params.page)
            this.pageSlug = params.page
        else
            this.pageSlug = "test";
        this.getComments();
        this.threadId = Cookies.get('thread');
        if (this.threadId)
            this.getConversation();

        this.$root.$on('comment-loading', this.updateLoadingComment)
        this.$root.$on('global-error', this.updateErrors)
    }
})