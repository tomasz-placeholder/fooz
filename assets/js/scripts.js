document.addEventListener('DOMContentLoaded', function() {
    if (typeof foozData !== 'undefined' && document.getElementById('latest-books') && foozData.currentBookId) {
        fetch(foozData.ajaxUrl + '?action=get_latest_books&exclude=' + foozData.currentBookId)
            .then(r => r.json())
            .then(books => {
                const c = document.getElementById('latest-books');
                if (!books.length) return c.innerHTML = foozData.noOtherBooks;
                c.innerHTML = books.map(b => `
                    <div>
                        <a href="${b.permalink}"><strong>${b.title}</strong></a><br>
                        <span>${b.date}</span> | <span>${b.genre}</span><br>
                        <small>${b.excerpt}</small>
                    </div>
                    <hr>
                `).join('');
            });
    }
});
