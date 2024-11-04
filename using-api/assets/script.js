const toggleButtons = document.querySelectorAll('.toggleButton');
const forms = document.querySelectorAll('.form');

// Hide all forms
function hideAllForms() {
    forms.forEach(form => {
        form.style.display = 'none';
    });
}

// display the form that was clicked one
toggleButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent the event form happeining again
        const formId = button.getAttribute('data-form');
        const currentForm = document.getElementById(formId);

        // Check form: is the form visible?
        if (currentForm.style.display === 'block') {
            hideAllForms();
        } else {
            hideAllForms(); // The first hide all forms
            currentForm.style.display = 'block'; // display the form that was clicked one
        }
    });
});

// Hide forms when clicked anywhere else
document.addEventListener('click', hideAllForms);

// Prevent the form: from being hidden when the form is clicked
forms.forEach(form => {
    form.addEventListener('click', (event) => {
        event.stopPropagation();
    });
});