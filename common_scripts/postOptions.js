function sendPostShowOrHide(id) {
    fetch('/Post/BlogEdit/' + id, {
        method: 'POST',
        body: 'ChangeVisibilityBlog',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    });
    window.location.href = "https://cyphub.tech/Settings/MyPost";
}

function sendPostDelete(id) {
    fetch('/Post/BlogEdit/' + id, {
        method: 'POST',
        body: 'DeleteBlog',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    });
    window.location.href = "https://cyphub.tech/Settings/MyPost";
}