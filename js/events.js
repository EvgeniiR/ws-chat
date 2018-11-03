document.querySelector('#textbox').addEventListener('keydown', function(e) {
    if (e.keyCode === 13) {
        e.preventDefault();
        sendMessage();
    }
});