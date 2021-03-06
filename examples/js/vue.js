

var app = new Vue({
    el: '#comments',
    data: {
        message: 'test',
        newComment: {},
        comments: [],
        loading: false,
        modal: {
            signIn: false
        },
        errors: null
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
        getComments() {
            this.loading = true;
            this.errors = null;
            this.$http.post("/comments/?action=get", { "slug": "test" }).then((response) => {
                this.loading = false;
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
                this.loading = null;

            });
        }
    },
    mounted() {
        this.getComments();
    }
})