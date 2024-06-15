document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    if (name && email && message) {
        alert('Thank you for contacting us, ' + name + '. We will get back to you shortly.');
        this.reset();
    } else {
        alert('Please fill out all fields before submitting.');
    }
});
