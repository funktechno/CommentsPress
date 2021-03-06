

Vue.component('comment-thread', {
    props: [
        'comment',
        'level'
    ],
    data() {
        return {
            showChildren: true
        }
    },
    template: `
    <div :class="level == 0 ? 'root__thread' : 'thread_level_' + level" class="thread thread_theme_light thread_indented" role="listitem" aria-expanded="true"><article id="remark42__comment-01281c83-af78-455e-880b-dabe74fce317" :class="level == 0 ? '' :  'comment_level_' + level" class="comment comment_guest comment_theme_light " style=""><div class="comment__info"><img class="avatar-icon avatar-icon_theme_light comment__avatar" src="/images/no-image.png" alt=""><span role="button" tabindex="0" class="comment__username" title="anonymous_55d448b815f9829dd31c4f14dad3285350207118">{{ comment.displayName }}</span><a href="https://remark42.com/demo/#remark42__comment-01281c83-af78-455e-880b-dabe74fce317" class="comment__time">{{comment.updated_at}}</a><a class="comment__link-to-parent" href="https://remark42.com/demo/#remark42__comment-7591be8c-a247-400f-b318-49210d04cb56" aria-label="Go to parent comment" title="Go to parent comment"> </a><span class="comment__score"><span class="comment__vote comment__vote_type_up comment__vote_disabled" aria-disabled="true" role="button" title="Sign in to vote">Vote up</span><span class="comment__score-value" title="Controversy: 0.00">0</span><span class="comment__vote comment__vote_type_down comment__vote_disabled" aria-disabled="true" role="button" title="Sign in to vote">Vote down</span></span></div><div class="comment__body"><div class="comment__text raw-content raw-content_theme_light" v-html="comment.commentText">
</div><div class="comment__actions"><button class="button button_kind_link comment__action" type="button" role="button" tabindex="0">Reply</button><span v-if="comment.children && comment.children.length > 1" class="comment__controls"><button class="button button_kind_link comment__control" type="button" role="button" tabindex="0" v-on:click="showChildren = !showChildren">{{showChildren ? 'Hide': 'Show'}}</button></span></div></div></article>
<comment-thread v-if="showChildren" v-for="c in comment.children" :comment="c" :level='level+1'/>
<div class="thread__collapse" role="button" tabindex="0"><div></div></div></div>
    `
});

var app = new Vue({
    el: '#comments',
    data: {
        pageSlug: "test",
        newComment: {},
        comments: [],
        example: "comments",
        status: null,
        form: {},
        loading: {
            general: false,
            comments: false,
            form: false
        },
        userForm: {},
        modal: {
            type: 'email',
            signIn: false
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
            this.isGuest = false
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
                    this.comments.push(response.data);
                    // this.$set()
                    // this.comments = response.data;
                } else {
                    this.errors = "Failed to load comments"
                }
            }).catch((error) => {
                this.errors = "Failed to get comments"
                console.log(error)
                this.loading.general = null;

            });
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
        getComments() {
            this.loading.comments = true;
            this.errors = null;
            this.$http.post("/comments/?action=get", { "slug": this.pageSlug }).then((response) => {
                this.loading.comments = false;
                console.log(response)
                // this.message = response.data.message;
                if (response.status == 200) {
                    console.log(response.data)
                    this.comments = response.data;
                } else {
                    this.errors = "Failed to load comments"
                }
            }).catch((error) => {
                this.errors = "Failed to get comments"
                console.log(error)
                this.loading.comments = null;

            });
        }
    },
    mounted() {
        this.getComments();
    }
})