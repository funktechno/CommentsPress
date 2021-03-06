
function renderComments(commentList) {
    var ele = document.getElementById(`commentThreads`)
    console.log(commentList);

    // ele.innerHTML="<li>test</li>"
    let commentsHtml = "";
    commentList.forEach(element => {
        let commentBody = `<div class="thread thread_theme_light root__thread" v-for="c in comments" role="listitem list"
        aria-expanded="true"
        >
        <article id="remark42__comment-515e3434-4161-4c55-8ee9-2752673c17d7" style=""
            class="comment comment_guest comment_theme_light">
            <div class="comment__info"><img class="avatar-icon avatar-icon_theme_light comment__avatar"
                    src="https://demo.remark42.com/api/v1/avatar/373820495cd26d40c26b6ffd0786b65c230238e2.image"
                    alt=""><span role="button" tabindex="0" class="comment__username"
                    title="anonymous_55d448b815f9829dd31c4f14dad3285350207118">`
        commentBody += element['displayName'] + `</span><a
        href="https://remark42.com/demo/#remark42__comment-515e3434-4161-4c55-8ee9-2752673c17d7"
        class="comment__time">`
        commentBody += element['updated_at'] + `</a><span class="comment__score"><span
        class="comment__vote comment__vote_type_up comment__vote_disabled"
        aria-disabled="true" role="button" title="Sign in to vote">Vote up</span><span
        class="comment__score-value" title="Controversy: 0.00">0</span><span
        class="comment__vote comment__vote_type_down comment__vote_disabled"
        aria-disabled="true" role="button" title="Sign in to vote">Vote
        down</span></span></div>
<div class="comment__body">
<div class="comment__text raw-content raw-content_theme_light">`
        commentBody += element['commentText'] + ` </div>
<div class="comment__actions"><button class="button button_kind_link comment__action"
        type="button" role="button" tabindex="0">Reply</button><span
        class="comment__controls"><button
            class="button button_kind_link comment__control" type="button" role="button"
            tabindex="0">Hide</button></span></div>
</div>
</article>

<div class="thread__collapse" role="button" tabindex="0">
<div></div>
</div>
</div>`
        commentsHtml += commentBody
    });


    ele.innerHTML = commentsHtml

}
const data = JSON.stringify({
    "slug": "test"
});

const xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function () {
    if (this.readyState === this.DONE) {
        try {
            const comments = JSON.parse(this.responseText);
            renderComments(comments);

        } catch (e) {
            console.log(e);
        }
        console.log(this.responseText);
    }
});

xhr.open("POST", "/comments/?action=get");
xhr.setRequestHeader("content-type", "application/json");
xhr.setRequestHeader("accept", "application/json");

xhr.send(data);