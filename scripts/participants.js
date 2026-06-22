var timer = null;
var parPage = 50;
var pageCourante = 1;
var listeComplete = [];

document.getElementById('search-input').addEventListener('input', function() {
    var search = this.value;
    clearTimeout(timer);
    timer = setTimeout(function() {
        fetch('?page=api_participants&search=' + encodeURIComponent(search))
            .then(function(res) { return res.json(); })
            .then(function(data) {
                listeComplete = data;
                pageCourante = 1;
                afficherListe();
            });
    }, 400);
});
document.getElementById('btn-reset').addEventListener('click', function() {
    document.getElementById('search-input').value = '';
    document.getElementById('search-input').dispatchEvent(new Event('input'));
});

function afficherListe() {
    var debut = (pageCourante - 1) * parPage;
    var page = listeComplete.slice(debut, debut + parPage);
    var html = '';

    if (page.length == 0) {
        html = '<p>Aucun résultat.</p>';
    }

    for (var i = 0; i < page.length; i++) {
        var user = page[i];
        var statut = user.points > 0 ? 'actif' : 'inactif';
        html += "<div class='participants-row'>";
        html += "<img src='" + user.profil_picture + "' alt='avatar'>";
        html += "<p class='row-rank'>#" + (debut + i + 1) + "</p>";
        html += "<p class='row-name'>" + user.username + "</p>";
        html += "<p>" + statut + "</p>";
        html += "<p class='row-points'>" + user.points + " pts</p>";
        html += "</div>";
    }
    document.getElementById('participants-list').innerHTML = html;
    afficherPagination();
}

function afficherPagination() {
    var nbPages = Math.max(1, Math.ceil(listeComplete.length / parPage));
    var html = '';

    for (var n = 1; n <= nbPages; n++) {
        if (n == 1 || n == nbPages || (n >= pageCourante - 2 && n <= pageCourante + 2)) {
            var classe = n == pageCourante ? 'active' : '';
            html += "<a href='#' class='" + classe + "' onclick='allerPage(" + n + "); return false;'>" + n + "</a>";
        } else if (n == pageCourante - 3 || n == pageCourante + 3) {
            html += "<a>...</a>";
        }
    }
    document.getElementById('participants-pagination').innerHTML = html;
}

function allerPage(n) {
    pageCourante = n;
    afficherListe();
}