$('#add-image').click(function () {
    // get the next field
    const index = +$('#widgets-counter').val();

    // get the prototype of enter
    const tmpl = $('#annonce_images').data('prototype').replace(/__name__/g, index);

    // set the code in the prototype
    $('#annonce_images').append(tmpl);

    $('#widgets-counter').val(index + 1);

    // Manage the delete buttons
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function () {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#annonce_images div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();