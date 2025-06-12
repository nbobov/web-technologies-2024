function getPostId() {
    const url = new URL(window.location.href);
    const id = url.searchParams.get('id');
    return id;
}

async function fetchPost(postId) {
    try {
        const response = await fetch(`https://jsonplaceholder.typicode.com/posts/${postId}`);

        if (!response.ok) {
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Ошибка при получении данных поста:', error);
        throw error;
    }
}

async function fetchComments(postId) {
    try {
        const response = await fetch(`https://jsonplaceholder.typicode.com/posts/${postId}/comments`);

        if (!response.ok) {
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Ошибка при получении комментариев:', error);
        throw error;
    }
}

function renderPost(post) {
    document.getElementById('post-title').textContent = post.title;
    document.getElementById('post-body').textContent = post.body;
    document.getElementById('post-author').textContent = `Автор: ID ${post.userId}`;

    document.getElementById('post-loading').style.display = 'none';
    document.getElementById('post-content').style.display = 'block';
}

function renderComments(comments) {
    const commentsList = document.getElementById('comments-list');
    commentsList.innerHTML = '';

    if (comments.length === 0) {
        commentsList.innerHTML = '<p>Комментариев пока нет.</p>';
    } else {
        comments.forEach(comment => {
            const commentItem = document.createElement('li');
            commentItem.className = 'comment-item';

            commentItem.innerHTML = `
                <div class="comment-email">${comment.email}</div>
                <div class="comment-name">${comment.name}</div>
                <div class="comment-body">${comment.body}</div>
            `;

            commentsList.appendChild(commentItem);
        });
    }

    document.getElementById('comments-loading').style.display = 'none';
    document.getElementById('comments-list').style.display = 'block';
}

function showError(containerId, message) {
    const container = document.getElementById(containerId);
    container.textContent = message;
    container.style.display = 'block';
}

async function init() {
    const postId = getPostId();

    if (!postId) {
        showError('post-error', 'ID поста не указан в URL');
        document.getElementById('post-loading').style.display = 'none';
        document.getElementById('comments-loading').style.display = 'none';
        return;
    }

    try {
        const post = await fetchPost(postId);
        renderPost(post);
    } catch (error) {
        showError('post-error', `Не удалось загрузить пост: ${error.message}`);
        document.getElementById('post-loading').style.display = 'none';
    }

    try {
        const comments = await fetchComments(postId);
        renderComments(comments);
    } catch (error) {
        showError('comments-error', `Не удалось загрузить комментарии: ${error.message}`);
        document.getElementById('comments-loading').style.display = 'none';
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}