function sendPostShowOrHide(id) {
    fetch('/Post/BlogEdit/' + id, {
        method: 'POST',
        body: 'ChangeVisibilityBlog',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    });
}

function sendPostDelete(id) {
    fetch('/Post/BlogEdit/' + id, {
        method: 'POST',
        body: 'DeleteBlog',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    });
}