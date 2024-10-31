function filterManhwa1() {
  let input, filter, article, titre, a;
  input = document.getElementById('nom_recherche_manhwa');
  filter = input.value.toUpperCase();
  article = document.querySelectorAll('article');

  for (let i = 0; i < article.length; i++) {
    a = article[i].querySelector('h3');
    titre = a.textContent || a.innerText;
    //toUpperCase mettre input majuscule
    if (titre.toUpperCase().indexOf(filter) > -1) {
      article[i].style.display = "";
    } else {
      article[i].style.display = 'none';
    }
  }
}
function filterManhwa() {
  
}
