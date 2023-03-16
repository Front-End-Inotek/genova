document.addEventListener("DOMContentLoaded", function() {
    var cards = document.querySelectorAll('.card');
    cards.forEach(function(card) {
      card.addEventListener('click', function(event) {
        event.currentTarget.classList.toggle('flipped');
      });
    });
  });