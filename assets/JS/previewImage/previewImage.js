function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();
    
    reader.onload = function() {
        const dataURL = reader.result;
        const imagePreview = document.getElementById('image-preview');
        imagePreview.src = dataURL;
        imagePreview.style.display = 'block';
    };
    
    reader.readAsDataURL(input.files[0]);
}

document.addEventListener('DOMContentLoaded', function(event) {
    event.preventDefault();
    const imageInput = document.querySelector('.image-input');
    if (imageInput) {
        imageInput.addEventListener('change', previewImage);
    }
});