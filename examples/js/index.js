
function renderComments(commentList) {
    var ele = document.getElementById(`comments`)
    console.log(commentList);

    // ele.innerHTML="<li>test</li>"
    let commentsHtml = "";
    commentList.forEach(element => {
        let commentBody = `<li>`
        commentBody += "<strong>User:" + element['displayName'] + "</strong>"
        commentBody += "<p>" + element['commentText'] + "</p>"

        commentBody += `</li>`
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