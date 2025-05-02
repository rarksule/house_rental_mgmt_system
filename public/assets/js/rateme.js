document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingValue = document.getElementById('rating-value');
    const submitBtn = document.getElementById('submit-rating');
    const commentField = document.getElementById('comment');

    // Star hover and click functionality
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.getAttribute('data-value'));
            ratingValue.value = value;
            updateStars(value);
        });

        star.addEventListener('mouseover', function() {
            const hoverValue = parseInt(this.getAttribute('data-value'));
            updateStars(hoverValue, false);
        });

        star.addEventListener('mouseout', function() {
            const currentValue = parseInt(ratingValue.value);
            updateStars(currentValue);
        });
    });

    // Update star display
    function updateStars(value, permanent = true) {
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-value'));
            const icon = star.querySelector('i');
            
            if (starValue <= value) {
                icon.classList.remove('far');
                icon.classList.add('fas');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
            
            if (permanent) {
                star.classList.remove('hover');
            } else {
                star.classList.add('hover');
            }
        });
    }

    // Submit rating via AJAX
    submitBtn.addEventListener('click', function(event) {
        const rating = ratingValue.value;
        const comment = commentField.value;
        
        if (rating == 0) {
            event.preventDefault();
            alert('Please select a rating');
            return;
        }
    });
});