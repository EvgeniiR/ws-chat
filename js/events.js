document.querySelector('#textbox').addEventListener('keydown', function(e) {
    e.preventDefault();
    if (e.keyCode === 13) {
        sendMessage();
    }
});