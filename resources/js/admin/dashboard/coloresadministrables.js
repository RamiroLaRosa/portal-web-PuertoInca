document.querySelectorAll('input[type="color"]').forEach(function(colorInput) {
    colorInput.addEventListener('input', function() {
        this.parentElement.querySelector('input[type="text"]').value = this.value.toUpperCase();
    });
});